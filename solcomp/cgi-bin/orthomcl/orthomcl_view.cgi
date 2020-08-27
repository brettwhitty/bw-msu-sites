#!/usr/bin/perl

use strict;
use warnings;

use CGI qw{ :standard };
use CGI::Carp('fatalsToBrowser');
use HTML::Template;
use DBM::Deep;
use DBI;
use Cwd qw{ abs_path };
use File::Basename qw{ dirname basename };


$| = 1;

my $server_addr = "$ENV{'SERVER_ADDR'}";
my $server_name = $ENV{"SERVER_NAME"};
my $doc_path = $ENV{"DOCUMENT_ROOT"};

my $script_path = dirname(abs_path($0));
my $script_base = basename($0, '.cgi');
my $db_path = $script_path.'/db';

open(my $clusters_fh,           $db_path.'/orthomcl_clusters.db')               || die "Failed to open clusters db: $!";
open(my $cluster_function_fh,   $db_path.'/orthomcl_clusters.function.db')      || die "Failed to open function db: $!";
open(my $cluster_membership_fh, $db_path.'/orthomcl_clusters.membership.db')    || die "Failed to open membership db: $!";

my $clusters            = new DBM::Deep('fh' => $clusters_fh);
my $cluster_function    = new DBM::Deep('fh' => $cluster_function_fh);
my $cluster_membership  = new DBM::Deep('fh' => $cluster_membership_fh);

my $dbh = DBI->connect("DBI:mysql:database=sol_gbrowse;host=mysql", "access", "access") or die "Error connecting to database ";

my $cgi = new CGI;

print $cgi->header();

my $clid = $cgi->param('clid');
my $id = $cgi->param('id');
my $grp = $cgi->param('grp');

$id =~ s/\s+//g;
$clid =~ s/\s+//g;

my $template_file;
if ($clid) {
    $template_file = "$script_path/$script_base.window.tmpl";
} else {
    if ($grp) {
        $template_file = "$script_path/$script_base.grp.tmpl";
    } else {
        $template_file = "$script_path/$script_base.result.tmpl";
    }
}
my $error_template_file;
if ($clid) {
    $error_template_file = "$script_path/$script_base.window.err.tmpl";
} else {
    $error_template_file = "$script_path/$script_base.result.err.tmpl";
}

if ($id =~ /^ORTHOMCL/i) {
    $clid = $id;
}

if ($id && ! $clid) {
    $clid = ($cluster_membership->exists($id)) ? $cluster_membership->{$id} : '';
}

if ($clid eq '' && $id eq '') {
    print "<h3>Error</h3><p>No identifier provided for searching. See examples for identifier format.</p>";
    exit(1);
}

if (! $clusters->exists($clid)) {
    if ($grp) {
        print "<div class='grp_null'>\n";
        print "No data available.\n";
        print "</div>\n";
    } else {
        print "<h3>Error</h3><p>Search for identifier '$id' returned no results.</p>";
        print "<p>Please check that the identifier is valid.</p>";
    }
    
    exit(1);
}

my $tmpl = new HTML::Template(
                                filename => $template_file,
                             );

my @rows;
foreach my $member_dbm(@{$clusters->{$clid}}) {

    my $member = $member_dbm->export();

    my $species;
    my $otu;

    if ($member->[0] =~ /^PUT-\d+[a-z]+-(.*)-\d+$/) {
        $species = $1;
        $species =~ s/_/ /g;
        $otu = 'solanales';
    } elsif ($member->[0] =~ /^AT\d+/i) {
        $species = 'Arabidopsis thaliana';
        $otu = 'brassicales';
    } elsif ($member->[0] =~ /^GSVIV/i) {
        $species = 'Vitis vinifera';
        $otu = 'vitales';
    } else {
        $species = 'Populus trichocarpa';
        $otu = 'malpighiales'; 
    }

    if ($member->[1] eq '-') {
        @{$member}[1..6] = ('N/A') x 6;
    } else {
        $member->[5] *= 100;
        $member->[6] *= 100;
    }
    
    my $up_id = $member->[1];
    $up_id =~ s/UniRef\d+_//;
   
    my $has_link = ($up_id ne 'N/A') ? 1 : 0;
    
    my $url_member_name = $member->[0];
    $url_member_name =~ s/([^A-Za-z0-9])/sprintf("%%%02X", ord($1))/seg;

    my $member_name_link;
    if ($species eq 'Arabidopsis thaliana') {
        $member_name_link = "<a href='/cgi-bin/gbrowse/arabidopsis?name=$url_member_name'>$member->[0]</a>";
    } elsif ($species eq 'Vitis vinifera') {
        $member_name_link = "<a href='/cgi-bin/gbrowse/grape?name=$url_member_name'>$member->[0]</a>";
    } elsif ($species eq 'Populus trichocarpa') {
        $member_name_link = "<a href='/cgi-bin/gbrowse/poplar?name=$url_member_name'>$member->[0]</a>";
    } else {
        $member_name_link = "<a href='/gene_overview.php?id=$url_member_name'>$member->[0]</a>";
    }

    ## query gbrowse database to see if it's been mapped
    my $feat_query = "select id from name where name = \"$member->[0]\"";
    my $sth = $dbh->prepare($feat_query);
    $sth->execute();
    my $has_gbrowse = 0;
    if ($sth->rows > 0) {
        $has_gbrowse = 1;
    }
    my $row_hash = {
                        'member_name'   =>  $member_name_link,
                        'has_gbrowse'   =>  $has_gbrowse,
                        'url_member_name'   =>  $url_member_name,
                        'species'       =>  $species,
                        #     'top_hit'       =>  $member->[1],
                        'up_id'         =>  $up_id,
                        'has_link'      =>  $has_link,
                        'score'         =>  $member->[3],
                        'evalue'        =>  $member->[4],
                        'ident'         =>  $member->[5],
                        'cov'           =>  $member->[6],
                   };

    push(@rows, $row_hash);                   
}
@rows = sort { $a->{'species'} cmp $b->{'species'}} @rows;

$tmpl->param('clid'           =>  $clid);
$tmpl->param('annotation'     =>  $cluster_function->{$clid});
$tmpl->param('member_table'   =>  \@rows);

print $tmpl->output();
