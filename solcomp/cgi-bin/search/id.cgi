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
my $id_query = "select d.id as db_id, d.value as db_name, n.value as id from (name n left outer join alias a on n.id = a.name_id) join db d on n.db_id = d.id and (a.value ~* ? or n.value ~* ?)";

my $cgi = new CGI;
my $tmpl;

my $id = $cgi->param('key');
my $view = $cgi->param('view');
my $text = $cgi->param('text');
my $db = $cgi->param('db');
my $rc = $cgi->param('rc');
my $json = $cgi->param('json');

## for using the ~* operator in postgres
$id = '^'.$id.'$';

my $template_file = '';

$template_file = 'id.tmpl';

$tmpl = HTML::Template->new(filename => $template_file);

my $dbh = DBI->connect("dbi:Pg:dbname=$db_name;host=pg.plantbiology.msu.edu", $db_user, $db_pass);

my $sth;

if ($db) {
    $id_query .= ' and d.id = ?';
}
$sth = $dbh->prepare($id_query);
if ($db) {
    $sth->execute($id, $id, $db);
} else {
    $sth->execute($id, $id);
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
        ))."\n";
    } else {
        delete $row->{'db_id'};
        $row->{'id'} = $accession_link;
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
        $tmpl->param('search_results'   =>  \@results_table);
        print $tmpl->output;
    }
}
