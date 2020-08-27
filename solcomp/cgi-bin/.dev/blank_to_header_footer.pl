#!/usr/bin/perl

$| = 1;

use strict;
use warnings;

my $tmpl = shift @ARGV || exit();
my $conf = shift @ARGV || exit();

my $header_flag = 1;
my $footer_flag = 0;

my $head = '';
my $header = '';
my $footer = '';

open(IN, "$tmpl") || die "Failed to open template '$tmpl': $!";
while (<IN>) { 
        if (/!-- EndOfHeader/) { 
            $header_flag = 0;
        } elsif ($header_flag) {
            chomp;
            $header .= $_;
        } elsif (/!-- StartOfFooter/) { 
            $footer_flag = 1;
        } elsif ($footer_flag) {
            chomp;
            $footer .= $_;
        } elsif (/\<\/body\>/) {
            last;
        }
}
$header =~ /\<head\>(.*)\<\/head\>(.*)/;
$head = $1;
$header = $2;
open (IN, "$conf") || die "Failed to open template '$conf': $!";
while (<IN>) {
    if (/^footer = /) {
        print "footer = $footer\n";
    } elsif (/^head = /) {
        print "head = $head\n";
    } elsif (/^header = /) {
        print "header = $header\n";
    } else {
        print;
    }
}    
