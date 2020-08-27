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

## search for an identifier
my $id_query = "select d.id as db_id, d.value as db_name, n.value as id, o.value as annotation, ts_headline(o.value, plainto_tsquery('english', ?)) as html from (name n left outer join alias a on n.id = a.name_id) join db d on n.db_id = d.id join note o on n.id = o.name_id and o.value @@ plainto_tsquery('english', ?)";

my $cgi = new CGI;
my $tmpl;

my $key = $cgi->param('key');
my $view = $cgi->param('view');
my $text = $cgi->param('text');
my $db = $cgi->param('db');
my $sp = $cgi->param('sp');

my $template_file = '';

$template_file = 'search_annotation.tmpl';

$tmpl = HTML::Template->new(filename => $template_file);

my $dbh = DBI->connect("dbi:Pg:dbname=$db_name;host=pg", $db_user, $db_pass);

my $sth;

if ($sp) {
    $id_query .= " n.value @@ plainto_tsquery('english', ?)";
}

if ($db) {
    $id_query .= ' and d.id = ?';
}

$sth = $dbh->prepare($id_query);
if ($sp && $db) {
    $sth->execute($key, $key, $sp, $db);
} elsif ($sp) {
    die $sp;
    $sth->execute($key, $key, $sp);
} elsif ($db) {
    $sth->execute($key, $key, $db);
} else {
    $sth->execute($key, $key);
}
## print headers
print $cgi->header();
my $seq = {};
my @results_table = ();
while (my $row = $sth->fetchrow_hashref) {
    if ($text) {
        print join("\t", (
                $row->{'db_id'},
                $row->{'db_name'},
                $row->{'id'},
                $row->{'annotation'},
                $row->{'html'},
        ))."\n";
    } else {
        delete $row->{'db_id'};
        delete $row->{'annotation'};
        push (@results_table, $row);
    }
}

$tmpl->param('search_results'   => \@results_table);
print $tmpl->output;

