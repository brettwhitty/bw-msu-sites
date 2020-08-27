#!/usr/bin/perl

use strict;
use warnings;

use CGI;
use CGI::Carp;
use XML::Twig;
use JSON;

my $sitemap = 'sitemap.xml';

## to store menu 
my @menu;

my $cgi = new CGI;

## support selecting a page submenu
my $src = $cgi->param('src') || undef;
my $all = $cgi->param('all') || 0;

print $cgi->header('text/plain');

open(my $infh, "xmllint --noent $sitemap |")
    || confess "Failed to open '$sitemap' for reading: $!";

my $parser = new XML::Twig(
    twig_handlers => {
        'page'  =>  \&page_handler,
    }
);

$parser->parse($infh);

print to_json(\@menu);

sub page_handler {
    my ($twig, $elt) = @_;
    
    if ($elt->att('src') ne $src) {
        return;
    }

    foreach my $child($elt->children('page')) {
        process_page(\@menu, $child);
    }
}

sub process_page {
    my ($arr_ref, $elt) = @_;

    my $item = {
        'name'  =>  $elt->att('name')   || '',
        'alt'   =>  $elt->att('alt')    || '',
        'title' =>  $elt->att('title')  || '',
        'src'   =>  $elt->att('src')    || '',
        'hidden'    =>  $elt->att('hidden')    || '',
        'children'  =>  [],
    };
    foreach my $child($elt->children('page')) {
        process_page($item->{'children'}, $child);
    }
    ## the hidden flag will hide a menu item and all children
    ## all flag overrides it
    if ($all || $item->{'hidden'} eq '') {
        push(@{$arr_ref}, $item);
    }
}
