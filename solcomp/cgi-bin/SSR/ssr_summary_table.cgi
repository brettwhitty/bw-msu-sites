#!/usr/bin/perl

use warnings;
use strict;

## script to generate summary table of SSRs that have been loaded to a Chado DB
## 
## Brett Whitty
## whitty@msu.edu

## max distance to consider SSRs as in tandem
my $max_tandem_distance = 100;

my $db_name = 'chado_sol_dev';
my $db_user = $ENV{'db_user'};
my $db_pass = $ENV{'db_pass'};

use CGI qw{ :standard };
use CGI::Carp('fatalsToBrowser');
use DBI;
use HTML::Template;


#my $sequence_query = <<QUERY;
#select x.accession as taxon_id, o.common_name as organism, count(f.feature_id),
#       sum(length(f.residues)) as len
#from feature f, cvterm c, feature_dbxref fd, dbxref x, db, organism o
#where f.feature_id = fd.feature_id and f.organism_id = o.organism_id 
#      and fd.dbxref_id = x.dbxref_id and db.db_id = x.db_id
#      and f.type_id = c.cvterm_id and c.name in ('contig', 'sequence_assembly')
#      and db.name = 'taxon' and length(f.residues) > 0 group by taxon_id, organism
#QUERY

##
## species, SSR motif length, min/max ssr length
## annotation search
## put id/genbank id

my $sequence_query = 'select * from ssr_seq_summary';

#my $ssr_query = <<QUERY;
#select sdbx.accession as taxon_id, o.common_name as organism,
#       sf.uniquename as assembly,
#       f.name as ssr_desc, 
#       length(fp.value) as repeat_len,
#       l.fmin as fmin, l.fmax as fmax, l.strand as strand
#from feature f, featureloc l, feature sf, cvterm c, organism o, feature_dbxref fd, db, dbxref dbx,
#       feature_dbxref sfd, db sdb, dbxref sdbx,
#       cvterm cv, 
#       featureprop fp, cvterm cvt
#where f.feature_id = l.feature_id and sf.feature_id = l.srcfeature_id and f.type_id = c.cvterm_id
#       and f.organism_id = o.organism_id and f.feature_id = fd.feature_id
#       and fd.dbxref_id = dbx.dbxref_id and db.db_id = dbx.db_id
#       and sf.feature_id = sfd.feature_id and sfd.dbxref_id = sdbx.dbxref_id
#       and sf.type_id = cv.cvterm_id 
#       and f.feature_id = fp.feature_id and cvt.cvterm_id = fp.type_id
#       and sdb.db_id = sdbx.db_id and sdb.name = 'taxon' and cvt.name = 'motif'
#       and db.name = 'GFF_source' and dbx.accession = 'SSR_putative'
#       order by assembly, fmin
#QUERY

my $ssr_query = 'select * from ssr_summary';

#
#       and sdbx.accession = 4113
#order by sf.uniquename, f.uniquename

my $cgi = new CGI;
my $tmpl;

$tmpl = HTML::Template->new(filename => "ssr_summary_table.tmpl");

my $dbh = DBI->connect("dbi:Pg:dbname=$db_name;host=pg", $db_user, $db_pass);

my $sth;

$sth = $dbh->prepare($sequence_query);
$sth->execute();
my $seq = {};
while (my $row = $sth->fetchrow_hashref) {
    $seq->{$row->{'organism'}} = {
                                    'count' => $row->{'count'},
                                    'len'   => $row->{'len'},
                                 };
}
    
$sth = $dbh->prepare($ssr_query);

$sth->execute();

my $ssr = {};
my $ssr_loc = {};
use Data::Dumper;

while (my $row = $sth->fetchrow_hashref) {

    ## taxon_id
    ## organism
    ## assembly
    ## ssr_desc
    ## repeat_len
    ## fmin
    ## fmax
    ## strand
   
#   print Dumper $row;
   

   ## count SSRs
   $ssr->{$row->{'organism'}}->{'ssr_count'}++;
   $ssr->{$row->{'organism'}}->{'size_count'}->{$row->{'repeat_len'}}++;
   $ssr->{$row->{'organism'}}->{'asm'}->{$row->{'assembly'}}++;
   push(@{$ssr_loc->{$row->{'organism'}}->{$row->{'assembly'}}}, [$row->{'fmin'}, $row->{'fmax'}]);
}

#print Dumper $ssr_loc;
#die();

## calculate tandem SSRs
foreach my $org(keys %{$ssr_loc}) {
    foreach my $asm(keys %{$ssr_loc->{$org}}) {
        my @ssr_locs = @{$ssr_loc->{$org}->{$asm}};


        ## TEMPORARY CODE TO REMOVE DUPLICATE SSR FEATURES THAT HAVE BEEN LOADED TO THE DATABASE
        ##

        my $loc_hash = {};
        foreach my $loc_ref(@ssr_locs) {
            my $key = join(",", @{$loc_ref});
            $loc_hash->{$key} = $loc_ref;
        }
        @ssr_locs = values(%{$loc_hash});
        
        ##
        ############

        
        @ssr_locs = sort {$a->[0] <=> $b->[0]} @ssr_locs;
        
        if (scalar(@ssr_locs) <= 1) {
            $ssr->{$org}->{$asm}->{'tandem_count'} = 0; 
            next;
        }
        
        @ssr_locs = ([-1, -1], @ssr_locs, [-1, -1]);
        
        my $tandem_count = 0;
        for (my $i = 1; $i < $#ssr_locs; $i++) {
            my $left_tandem = 0;
            my $right_tandem = 0;
            if (    $ssr_locs[$i - 1]->[1] >= 0 
                 && ($ssr_locs[$i]->[0] - $ssr_locs[$i - 1]->[1]) <= $max_tandem_distance ) {
                 $left_tandem = 1;
            }
            if (    $ssr_locs[$i + 1]->[0] >= 0 
                 && ($ssr_locs[$i + 1]->[0] - $ssr_locs[$i]->[1]) <= $max_tandem_distance ) {
                 $right_tandem = 1;
            }
            if ($right_tandem || $left_tandem) {
                $tandem_count++;
            }
        }
        $ssr->{$org}->{'tandem_count'} += $tandem_count; 
    }
}

my $table_ref = [];
foreach my $org(keys(%{$ssr})) {
    $ssr->{$org}->{'asm_count'} = scalar(keys(%{$ssr->{$org}->{'asm'}}));
    
    ## count assemblies with >1 SSR
    foreach my $asm_id(keys(%{$ssr->{$org}->{'asm'}})) {
        if ($ssr->{$org}->{'asm'}->{$asm_id} > 1) {
            $ssr->{$org}->{'multi_ssr_count'}++;
        }
    }

    push(@{$table_ref}, {
                            species         =>  $org,
                            asm_count       =>  $seq->{$org}->{'count'},
                            asm_len_total   =>  $seq->{$org}->{'len'},
                            ssr_total       =>  $ssr->{$org}->{'ssr_count'},
                            ssr_asm_count   =>  $ssr->{$org}->{'asm_count'},
                            multi_ssr_asm_count =>  $ssr->{$org}->{'multi_ssr_count'},
                            ssr_tandem_count    =>  $ssr->{$org}->{'tandem_count'}    || '0',
                            ssr_count_1         =>  $ssr->{$org}->{'size_count'}->{1} || '0',
                            ssr_count_2         =>  $ssr->{$org}->{'size_count'}->{2} || '0',
                            ssr_count_3         =>  $ssr->{$org}->{'size_count'}->{3} || '0',
                            ssr_count_4         =>  $ssr->{$org}->{'size_count'}->{4} || '0',
                            ssr_count_5         =>  $ssr->{$org}->{'size_count'}->{5} || '0',
                            ssr_count_6         =>  $ssr->{$org}->{'size_count'}->{6} || '0',
                        });
}

@{$table_ref} = sort{ $a->{'species'} cmp $b->{'species'}} @{$table_ref};

print $cgi->header();

$tmpl->param("summary_table" => $table_ref);

print $tmpl->output;

