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
my $id_query = "select u.accession as id, u.description as description, u.rank as rank, u.score as score, u.expect as expect from name n, uniref u where n.id = u.name_id and n.value = ? order by rank";

my $cgi = new CGI;
my $tmpl;

my $id = $cgi->param('id');

my $template_file = '';

$template_file = 'grp_uniref100.tmpl';

$tmpl = HTML::Template->new(filename => $template_file);

my $dbh = DBI->connect("dbi:Pg:dbname=$db_name;host=pg", $db_user, $db_pass);

my $sth;

$sth = $dbh->prepare($id_query);
$sth->execute($id);

## print headers
print $cgi->header();

my @results_table = ();
while (my $row = $sth->fetchrow_hashref) {

    my $accession_link;
    my $accession = $row->{'id'};
    my $url_accession = $row->{'id'};
    $url_accession =~ s/([^A-Za-z0-9])/sprintf("%%%02X", ord($1))/seg;

    #$row->{'id'} = $accession_link;
    #delete $row->{'db_id'};
    #delete $row->{'annotation'};
    push (@results_table, $row);
}

if (@results_table) {
    $tmpl->param('search_results'   => \@results_table);
        print $tmpl->output;
} else {
    print "No data available.";
}
