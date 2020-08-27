#!/usr/bin/perl

use strict;
use warnings;

use JSON;
use CGI;
use CGI::Carp qw{fatalsToBrowser};

my $test_data = {
    'ko01010'   =>  {
        'PGSC0003DMG20000123'   =>  [
            '#ff0000',
            '#ffcc00',
            '#ff00ff',
        ],
        'PGSC0003DMG20001234'   =>  [
            '#ffff00',
            '#00FFFF',
            '#00CCCC',
        ],
    },
    'ko01020'   =>  {
        'PGSC0003DMG20000003'   =>  [
            '#3030ff',
            '#CCCCCC',
            '#CC00CC',
        ],
    },
};

my $cgi = new CGI;

print $cgi->header('text/json');
print to_json($test_data);
