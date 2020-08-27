#!/usr/bin/perl

use strict;
use warnings;

use DBI;
use CGI qw{ :standard };
use CGI::Carp('fatalsToBrowser');
use HTML::Template;

$| = 1;

my $db_server   = 'mysql';
my $db_name     = 'whitty_test';
my $db_user     = $ENV{'DB_USER'};
my $db_pass     = $ENV{'DB_PASS'};

## this query must return sequence as fasta
my $fasta_query   = 'select fasta from puts where accession = ?';
my $estscan_query = 'select fasta from estscan where accession = ?';

my $dbh = DBI->connect("dbi:mysql:dbname=$db_name;host=$db_server", $db_user, $db_pass);

my $cgi = new CGI;

print $cgi->header();

my $id = $cgi->param('id');
my $type = $cgi->param('type');

unless ($id) {
    ## Not being too descriptive in the error message here on purpose
    print '<div><p>Error fetching data.</p></div>';
    exit(1);
}


my $fasta;
if ($type eq 'na') {
    my $nth = $dbh->prepare($fasta_query);
    $nth->execute($id);
    my @row = $nth->fetchrow_array();
    if (@row) {
        $fasta = $row[0];
        print "<pre>$fasta</pre>\n";
    } else {
        ## Not being too descriptive in the error message here on purpose
        print '<div><p>No data available.</p></div>';
        exit(1);
    }
} elsif ($type eq 'aa') {
    my $aah = $dbh->prepare($estscan_query);
    $aah->execute($id);
    my $count = 0;
    while (my @row = $aah->fetchrow_array()) {
        $fasta = $row[0];
        print "<pre>$fasta</pre>\n";
        $count++;
    }
    if ($count == 0) {
        print '<div><p>No data available.</p></div>';
        exit(1);
    }
} else {
    print "Invalid CGI access.";
    exit(1);
}
