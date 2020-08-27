#!/usr/bin/perl

use strict;
use warnings;

use CGI qw{ :standard };
use CGI::Carp('fatalsToBrowser');
use HTML::Template;

$| = 1;


my $cgi = new CGI;

print $cgi->header();

my $id = $cgi->param('id');

my $gene_link = {
    'solanaceae'    => '/cgi-bin/gbrowse/solanaceae/?name=Sequence:',
    'arabidopsis'   => '/cgi-bin/gbrowse/arabidopsis/?name=Sequence:',
    'grape'         => '/cgi-bin/gbrowse/grape/?name=Sequence:',
    'poplar'        => '/cgi-bin/gbrowse/poplar/?name=Sequence:',
};

print "<div>\n";
print "<div class='field_label'>Genome Browser Links</div>\n";
foreach my $key( qw{ solanaceae arabidopsis grape poplar } ) {
    my $url = $gene_link->{$key}.$id;
    my $db_name = ucfirst($key);
    print "<div class='field_value'><a href='$url'>$db_name</a></div>\n";
}
print "</div>\n";
