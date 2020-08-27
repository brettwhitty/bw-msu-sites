#!/usr/bin/perl

use strict;
use warnings;

#use DB_File;
use DBM::Deep;

#tie my %clusters, 'DB_File', 'orthomcl_clusters.db';
#tie my %cluster_function, 'DB_File', 'orthomcl_clusters.function.db';
#tie my %cluster_membership, 'DB_File', 'orthomcl_clusters.membership.db';

my $clusters = new DBM::Deep('../db/orthomcl_clusters.db');
my $cluster_function = new DBM::Deep('../db/orthomcl_clusters.function.db');
my $cluster_membership = new DBM::Deep('../db/orthomcl_clusters.membership.db');

use Data::Dumper;
print Dumper $clusters->{'ORTHOMCL0'};
