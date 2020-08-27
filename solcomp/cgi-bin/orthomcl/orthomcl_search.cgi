#!/usr/bin/perl

use strict;
use warnings;

use CGI qw{ :standard };
use CGI::Carp qw{ fatalsToBrowser };

use HTML::Template;
use DBM::Deep;
use Cwd qw{ abs_path };
use File::Basename qw{ dirname basename };
#use String::Similarity;
use String::Approx qw{ amatch };

$| = 1;

my $server_addr = $ENV{'SERVER_ADDR'};
my $server_name = $ENV{'SERVER_NAME'};
my $doc_path    = $ENV{'DOCUMENT_ROOT'};

my $script_path = dirname(abs_path($0));
my $script_base = basename($0, '.cgi');

my $data_path = $script_path.'/data';

#open(my $cluster_function_fh, $script_path.'/orthomcl_clusters.function.db') || die "Failed to open function db: $!";
#my $cluster_function    = new DBM::Deep('fh' => $cluster_function_fh);

my $cgi = new CGI;

print $cgi->header();

my $key = $cgi->param('key');
my $approx = $cgi->param('approx');

my $key_len = length($key);

$key =~ tr/\x80-\xFF//d;
$key =~ tr/<>{}'"~`#$%^*=|\\//d;
$key =~ s/^\s+|\s+$//g;

if ($key_len == 0) {
    print error_html('You submitted a keyword search without specifying a keyword to search on.');
    exit(1);
} elsif (! $key) {
    print error_html('The keyword you submitted for searching consisted entirely of invalid characters.');
    exit(1);
}

my @results = ();

open (my $infh, "<:gzip", "$data_path/all_clusters.function.txt.gz") || die "Failed opening function table for reading: $!";
while (<IN>) {
    chomp;
    my ($cluster_id, $function) = split("\t");

#while (my ($cluster_id, $function) = each %{$cluster_function} ) {
#    print similarity($key, $cluster_function->{$cluster_id})."\t$cluster_function->{$cluster_id}\n";
#    if ($function =~ /$key/i) {
    
    if ($approx && amatch($key, ['i', '2'], ($function))) {
       push(@results, { 'cluster_id' => $cluster_id, 'annotation' => $function });
    } elsif ($function =~ /$key/i) {
       push(@results, { 'cluster_id' => $cluster_id, 'annotation' => $function });
    }
}

unless (scalar(@results)) {
    print "<h3>OrthoMCL Cluster Annotation Keyword Search Results</h3><p>Your search for keyword '$key' returned no results.</p>";
#    my $tmpl = new HTML::Template(
#                                filename => "$script_path/$script_base.error.tmpl",
#                             );
#    print $tmpl->output();
    exit();
}


## sort the results by function string
@results = sort {$a->{'annotation'} cmp $b->{'annotation'}} @results;

my $tmpl = new HTML::Template(
                                filename => "$script_path/$script_base.tmpl",
                             );

$tmpl->param('search_key'       => $key);
$tmpl->param('total_results'    => scalar(@results));
$tmpl->param('search_results'   => \@results);

print $tmpl->output();

sub error_html {
    my ($text) = @_;

    return "<div class='search_error'><h3>Error</h3><p>$text</p></div>";
}
