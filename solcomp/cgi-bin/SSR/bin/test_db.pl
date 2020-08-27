#!/usr/bin/perl

use strict;
use warnings;

use BerkeleyDB;

## must mount with DB_RDONLY flag when using via CGI script
## (file doesn't need to be modified after creation, and 'www-data' user won't / shouldn't have write access)
tie (my %annotation_db, 'BerkeleyDB::Hash', -Filename => 'annotation.db'), -Flags => DB_RDONLY
    or die $!;

print $annotation_db{'PUT-157a-Solanum_tuberosum-16944'}."\n";
