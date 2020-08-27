#!/usr/bin/perl

use strict;
use warnings;

use BerkeleyDB;

tie my %db, 'BerkeleyDB::Hash', -Filename => 'annotation.db';

while (<>) { 
    chomp;

    my @t = split("\t");
   
    $db{$t[0]} = $t[1];
}

untie %db;
