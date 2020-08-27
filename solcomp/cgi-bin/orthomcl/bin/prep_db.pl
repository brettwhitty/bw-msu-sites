#!/usr/bin/perl

use strict;
use warnings;

use DBM::Deep;
use Getopt::Long;

my $data_dir = '../data';

## remove any DB data files that already exist
unlink('orthomcl_clusters.db');
unlink('orthomcl_clusters.function.db');
unlink('orthomcl_clusters.membership.db');

my $clusters            = new DBM::Deep(file => 'orthomcl_clusters.db',             autoflush => 0);
my $cluster_function    = new DBM::Deep(file => 'orthomcl_clusters.function.db',    autoflush => 0);
my $cluster_membership  = new DBM::Deep(file => 'orthomcl_clusters.membership.db',  autoflush => 0);

## this is a table of significant BLASTP best-hit results for all OrthoMCL cluster member sequences vs UniRef50 DB
## ...see table format below
open (my $clusters_fh, '<:gzip', "$data_dir/all_clusters.uniref50.blastp.txt.gz") || die "Failed to open file: $!";

while (<$clusters_fh>) {
    chomp;
    
    ## cluster_id   = OrthoMCL cluster ID
    ## seq_id       = OrthoMCL cluster member sequence ID
    ## uniref_id    = UniRef50 target sequence ID
    ## func         = Functional annotation text from UniRef50
    ## rank         = Rank of hit
    ## score        = BLAST score
    ## sig          = Significance
    ## ident        = % identity
    ## cov          = % coverage
    #
    my ($cluster_id, $seq_id, $uniref_id, $func, $rank, $score, $sig, $ident, $cov) = split("\t");


    push(@{$clusters->{$cluster_id}}, [
                                        $seq_id,
                                        $uniref_id,
                                        $func,
                                        $score,
                                        $sig,
                                        $ident,
                                        $cov,
                                      ]);
    $cluster_membership->{$seq_id} = $cluster_id;                                
}

## this is a table of functional annotation text for each cluster by cluster ID
open (my $members_fh, '<:gzip', "$data_dir/all_clusters.function.txt.gz") || die "Failed to open file: $!";
while (<$members_fh>) {
    chomp;

    my @t = split("\t");

    $cluster_function->{$t[0]} = $t[1];
}

#use Data::Dumper;
#print Dumper $clusters;
#print Dumper $cluster_function;
#print Dumper $cluster_membership;
