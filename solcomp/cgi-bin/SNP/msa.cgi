#!/usr/bin/perl

use strict;
use warnings;

use CGI;
use CGI::Carp qw( fatalsToBrowser );

use FindBin qw{ $RealBin };
use lib "$RealBin/../lib/perl5/site_perl/5.8.8";
use Sol::SimpleAlign::Reader;
use Sol::SimpleAlign::Util;

my $cgi = new CGI;

## PUT ID is a required parameter
my $id = $cgi->param("id");
unless ($id) { die "No value provided for 'id'"; }

## allow disabling colorization of each base
my $colorize = 1;
$colorize ||= $cgi->param("colorize");

$id =~ /PUT-\d+[a-z]+-([^-]+)/ || die "Parameter id='$id' has unexpected format";
my $species = $1;
$species = lc($species);

## create reader object
my $db = new Sol::SimpleAlign::Reader(
    db => "$species.alignment.with_subseq.db",
                                       );

## get alignment                                      
my $aln = $db->get_alignment($id) || die "No alignment found for id='$id'";


my $aln_util = new Sol::SimpleAlign::Util();

## get mismatch coordinates
my @coords = $aln_util->get_mismatch_coords($aln);

## output the header
print $cgi->header();

## output the aligment div contents
print $aln_util->get_alignment_html(
        $aln,
        'each_character'    =>  1,
        'char_class'        =>  {
            'mismatch'  =>  \@coords,
        },
    );
