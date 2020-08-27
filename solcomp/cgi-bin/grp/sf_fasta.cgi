#!/usr/bin/perl

use strict;
use warnings;

use DBI;
use CGI qw{ :standard };
use CGI::Carp('fatalsToBrowser');
use HTML::Template;

$| = 1;

my $db_server   = 'mysql.plantbiology.msu.edu';
my $db_name     = 'solcomp_seqfeature';
my $db_user     = $ENV{'SOLCOMP_SEQFEATURE_DB_USER'};
my $db_pass     = $ENV{'SOLCOMP_SEQFEATURE_DB_PASS'};

##
## PUT type: 'expressed_sequence_assembly:PlantGDB'

my $fasta_query = "select s.id as id, group_concat(s.sequence) as seq
                   from sequence s
                   where s.id in (
                        select f.id from feature f, typelist t, attributelist al, attribute a
                        where f.typeid = t.id
                        and f.id = a.id 
                        and al.id = a.attribute_id
                        and t.tag=? 
                        and al.tag='load_id'
                        and a.attribute_value=?
                   ) group by id order by offset";

my $defline_query = "select a.attribute_value from attributelist al, attribute a
                     where al.id = a.attribute_id
                     and al.tag = 'defline'
                     and a.id = ?";

my $dbh = DBI->connect("dbi:mysql:dbname=$db_name;host=$db_server", $db_user, $db_pass);

my $cgi = new CGI;

print $cgi->header();

my $load_id = $cgi->param('id');
my $type = $cgi->param('type');

my $fasta;
if (defined($load_id) && defined($type)) {

    my $fqh = $dbh->prepare($fasta_query);
    my $dqh = $dbh->prepare($defline_query);

    $fqh->execute($type, $load_id);

    my $count = 0;
    while (my $row_ref = $fqh->fetchrow_hashref()) {
        my $id = $row_ref->{'id'};
        my $seq = $row_ref->{'seq'};

        $seq =~ s/(.{1,60})/$1\n/g;
        
        $dqh->execute($id);
        my $defline = ($dqh->fetchrow_array())[0] || $load_id;
        $defline =~ s/\%([A-Fa-f0-9]{2})/pack('C', hex($1))/seg;
    
        print "<pre>>$defline\n$seq</pre>\n";
        $count++;
    }
    if ($count == 0) {
        ## Not being too descriptive in the error message here on purpose
        print '<div><p>No data available.</p></div>';
        exit(1);
    }
} else {
    print "Invalid CGI access.";
    exit(1);
}

