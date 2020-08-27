#!/usr/bin/perl

## Allows mapping a Solanceae EST sequence's GenBank accession
## to a PlantGDB PUT assembly ID (if it's a member of one)
##
## Used by:
##  
##   '/cgi-bin/SNP/sol_snps[.grp].cgi'
##   '/cgi-bin/SSR/ssr_db_query.cgi'
##
## This is quick dev implementation that uses a DB_File 
## serialized hash to provide function;
## intended to be replaced eventually with a production script
## that queries the real DB backend.
##
## Brett Whitty, 2010

package GBtoPUT;

use strict;
use warnings;

use Cwd qw{ abs_path };
use File::Basename qw{ dirname }; 
use DB_File;

my %db;

sub new {

    my ($proto, %args) = @_;

    my $class = ref($proto) || $proto;
    
    my $self = {};

    my $dir = dirname(abs_path($0));
    
    tie %db, 'DB_File', $args{'db_path'}.'/gb_to_put_mapping.db', O_RDONLY;

    bless $self, $class;

    return $self;
}

sub get {
    my ($self, $id) = @_;

    return $db{uc($id)};
}
1;
