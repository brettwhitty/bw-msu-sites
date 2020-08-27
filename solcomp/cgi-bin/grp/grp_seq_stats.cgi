#!/usr/bin/perl

$| = 1;

use strict;
use warnings;

use CGI;
use DBI;
use XML::Dumper;
use Bio::SimpleAlign;
use HTML::Template;

my $db_name = 'solcomp_search';
my $db_user = $ENV{'DB_USER'};
my $db_pass = $ENV{'DB_PASS'};

my $template_name = "grp_seq_stats.tmpl";

my $cgi = new CGI;
print $cgi->header;

my $id = clean_id($cgi->param("id"));

if ($id !~ /^PUT-/i) {
    die "Invalid CGI access";
}

#my $dumper = new XML::Dumper;

my (
    $species,
    $taxon_id,
    $members,
    $seq_len,
    $function_text,
) = qw(? ? ? ? ?);

my $put = get_put_hash($id);

if (defined($put)) {
    $species = $put->{'scientific_name'};
    $taxon_id = $put->{'taxon_id'};
    $members = $put->{'members'};
    $seq_len = $put->{'seqlen'};
};


#my $msa_query = 'select m.value as xml from name n, msa m where n.id = m.name_id and n.value = ?';
#my $sth = $dbh->prepare($msa_query);
#$sth->execute($id);
#my ($xml) = $sth->fetchrow_array();

#my $msa;
#if ($xml) {
#    $msa = $dumper->xml2pl($xml);
#}

#my ($members, $seq_len);
#if ($msa) {
#    $members = $msa->no_sequences;
#    $seq_len = $msa->length;
#} else {
#    $members = '?';
#    $seq_len = '?';
#}

## set # of members from MSA
#my $members = 1;
#if (defined($msa)) {
#    $members = $msa->{'member_count'};
#}

$function_text = get_function_text($id);

my $tmpl = HTML::Template->new(filename => $template_name);
$tmpl->param(
    'species'      =>  $species
);
$tmpl->param(
    'taxon_id'     =>  $taxon_id
);
$tmpl->param(
    'put_id'       =>  $id
);
$tmpl->param(
    'seq_len'      =>  $seq_len
);
$tmpl->param(
    'members'      =>  $members
);
$tmpl->param(
    'function'     =>  $function_text
);

print $tmpl->output;

#use Data::Dumper;
#print Dumper $msa;

sub clean_id {
    my ($id) = @_;

    $id =~ s/^\s*//;
    $id =~ s/\s*$//;
    $id = lc($id);
    $id =~ s/put\-(\d+[a-z]\-)([a-z]+)/PUT\-$1\u\L$2/;
    $id =~ s/_x_([a-z]+)(_[a-z]+)/_x_\u\L$1$2/;

    return $id;
}

sub get_put_hash {
    my ($id) = @_;
    
    my $mdbh = DBI->connect('dbi:mysql:dbname=whitty_test;host=mysql', $DB_USER, $DB_PASS);

    my $put_query = 'select p.*, o.scientific_name as scientific_name from puts p, organism o where p.taxon_id = o.taxon_id and accession = ?';

    my $sth = $mdbh->prepare($put_query);

    $sth->execute($id);

    if (my $row = $sth->fetchrow_hashref()) {
        return $row;
    } else {
        return undef;
    }
}

sub get_function_text {
    my ($id) = @_;

    my $dbh = DBI->connect("dbi:Pg:dbname=$db_name;host=pg", $DB_USER, $DB_PASS);

    my $function_query = 'select o.value from name n, note o where n.id = o.name_id and n.value = ? order by o.id limit 1';

    my $fsth = $dbh->prepare($function_query);
    $fsth->execute($id);
    if (my $row = $fsth->fetchrow_arrayref()) {
        return $row->[0];
    } else {
        return 'No data available.';
    }
}
