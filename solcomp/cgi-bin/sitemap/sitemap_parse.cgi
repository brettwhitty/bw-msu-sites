#!/usr/bin/perl

use strict;
use warnings;

use CGI;
use CGI::Carp;
use XML::Twig;
use JSON;

my $sitemap = 'sitemap.xml';

## to store breadcrumbs
my @crumbs;

my $cgi = new CGI;
print $cgi->header('text/plain');

my $req_src = $cgi->param('src') || 'tools_blast.php';

open(my $infh, "xmllint --noent $sitemap |") || confess "Failed to open '$sitemap' for reading: $!";
my $parser = new XML::Twig(
    twig_handlers => {
        'page'  =>  \&page_handler,
    }
);

$parser->parse($infh);

sub page_handler {
    my ($twig, $elt) = @_;

    my $src = $elt->att('src') || '';

    @crumbs = ();

    if ($src eq $req_src) {
        set_crumbs(\@crumbs, $elt);
        while ($elt = $elt->parent(qr/page/)) {
            set_crumbs(\@crumbs, $elt);
        }
        print to_json(\@crumbs);
    }
}

sub set_crumbs {
    my ($crumbs_ref, $elt) = @_;

    my $title = $elt->att('title') || '';
    my $name  = $elt->att('name') || '';
    my $alt   = $elt->att('alt') || '';
    my $src   = $elt->att('src') || '';
    unshift(@crumbs, {
        'title' => $title,
        'name'  => $name,
        'alt'   => $alt,
        'src'   => $src,
        }
    );
}
