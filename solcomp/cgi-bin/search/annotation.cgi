#!/usr/bin/perl

use warnings;
use strict;

## for supporting ajax fulltext searching for the solcomp site

my $db_name = 'solcomp_search';

my $db_user = $ENV{'DB_USER'};
my $db_pass = $ENV{'DB_PASS'};

use CGI qw{ :standard };
use CGI::Carp('fatalsToBrowser');
use DBI;
use HTML::Template;
use JSON;

## search for an identifier
my $id_query = "select d.id as db_id, d.value as db_name, n.value as id, o.value as annotation, ts_headline(o.value, plainto_tsquery('english', ?)) as html from name n join db d on n.db_id = d.id join note o on n.id = o.name_id and o.value @@ plainto_tsquery('english', ?)";

my $cgi = new CGI;
my $tmpl;

my $key = $cgi->param('key');
my $view =$cgi->param('view');
my $text = $cgi->param('text');
my $db = $cgi->param('db');
my $sp = $cgi->param('sp');
my $rc = $cgi->param('rc');
my $json = $cgi->param('json');

my $result_limit = 1000; ## limit number of results to a reasonable number

my $template_file = '';

$template_file = 'annotation.tmpl';

$tmpl = HTML::Template->new(filename => $template_file);

my $dbh = DBI->connect("dbi:Pg:dbname=$db_name;host=pg", $db_user, $db_pass);

my $sth;

if ($sp) {
    $id_query .= " and n.value @@ plainto_tsquery('english', ?)";
}

if ($db) {
    $id_query .= ' and d.id = ?';
}

$id_query .= ' order by o.value, d.id, n.value limit 1000';

$sth = $dbh->prepare($id_query);
if ($sp && $db) {
    $sth->execute($key, $key, $sp, $db);
} elsif ($sp) {
    $sth->execute($key, $key, $sp);
} elsif ($db) {
    $sth->execute($key, $key, $db);
} else {
    $sth->execute($key, $key);
}
## print headers
print $cgi->header();

## support returning number of results only
if ($rc) {
    print $sth->rows();
    exit();
}

my $seq = {};
my @results_table = ();
while (my $row = $sth->fetchrow_hashref) {

    my $accession_link;
    my $accession = $row->{'id'};
    my $url_accession = $row->{'id'};
    $url_accession =~ s/([^A-Za-z0-9])/sprintf("%%%02X", ord($1))/seg;

    if ($row->{'db_id'} == 1) {
        $accession_link = "<a href='/gene_overview.php?id=$url_accession'>$accession</a>";
    } elsif ($row->{'db_id'} == 2) {
        $accession_link = "<a href='/cgi-bin/gbrowse/solanaceae?name=$url_accession'>$accession</a>";
    } elsif ($row->{'db_id'} == 3) {
        $accession_link = "<a href='/cgi-bin/gbrowse/arabidopsis?name=$url_accession'>$accession</a>";
    } elsif ($row->{'db_id'} == 4) {
        $accession_link = "<a href='/cgi-bin/gbrowse/grape?name=$url_accession'>$accession</a>";
    } elsif ($row->{'db_id'} == 5) {
        $accession_link = "<a href='/cgi-bin/gbrowse/poplar?name=$url_accession'>$accession</a>";
    }

    if ($text) {
        print join("\t", (
                $row->{'db_id'},
                $row->{'db_name'},
                $row->{'id'},
                $row->{'annotation'},
                $row->{'html'},
        ))."\n";
    } else {
        $row->{'id'} = $accession_link;
        delete $row->{'db_id'};
        delete $row->{'annotation'};
        push (@results_table, $row);
    }
}
if (@results_table) {
    if ($json) {
        my $jo = new JSON();
        print $jo->pretty->encode(\@results_table);
        exit();
    }
    unless ($text) {
        $tmpl->param('search_results'   => \@results_table);
        print $tmpl->output;
    }
}
