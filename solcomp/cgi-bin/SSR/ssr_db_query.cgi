#!/usr/bin/perl

use warnings;
use strict;

## script to query SSRs that have been loaded to a Chado DB
## 
## Brett Whitty
## whitty@msu.edu

my $db_name = 'chado_sol_dev';
my $db_user = $ENV{'DB_USER'};
my $db_pass = $ENV{'DB_PASS'};

use CGI qw{ :standard };
use CGI::Carp('fatalsToBrowser');
use Cwd qw{ abs_path };
use DBI;
use HTML::Template;
use BerkeleyDB;
#use FindBin qw{ $RealBin };
use File::Basename;

use lib "./lib";
use GBtoPUT;

my $script_path = dirname(abs_path($0))."/";

my $gb_to_put = new GBtoPUT('db_path' => $script_path.'db');

tie my %annotation_db, 'BerkeleyDB::Hash', -Filename => $script_path.'db/annotation.db', -Flags => DB_RDONLY
    or die $!;

## query to fetch SSRs
my $old_ssr_query = <<QUERY;
select x.accession as taxon_id, f.uniquename as put_id, l.fmin as fmin, l.fmax as fmax, fp.value as note
from feature f, feature_dbxref fd, dbxref x, db d, featureloc l, feature f2,
     featureprop fp, cvterm ct, cvterm c 
where d.name = 'taxon' and d.db_id = x.db_id and fd.dbxref_id = x.dbxref_id
      and fd.feature_id = f.feature_id and l.srcfeature_id = f.feature_id 
      and f2.feature_id = l.feature_id and f2.feature_id = fp.feature_id
      and f2.type_id = ct.cvterm_id and fp.type_id = c.cvterm_id 
      and c.name = 'Note' and ct.name = 'repeat_region'
QUERY
##    search by taxonomy id:
##    and x.accession = 4113
##    search by PUT ID:
##    and f.uniquename = '$put_id'
##
##    ***need GB to PUT mappings file***



## query to fetch SSRs
#my $ssr_query = <<QUERY;
#select d.name as put_db, x.accession as taxon_id, f.uniquename, f2.uniquename, f2.residues,
#       l.fmin, l.fmax, l.residue_info, fp.value, fp.type_id 
#from feature f, feature_dbxref fd, dbxref x, db d, featureloc l, feature f2,
#     featureprop fp, cvterm ct 
#where d.name = 'taxon' and d.db_id = x.db_id and fd.dbxref_id = x.dbxref_id
#      and fd.feature_id = f.feature_id and l.srcfeature_id = f.feature_id 
#      and f2.feature_id = l.feature_id and f2.feature_id = fp.feature_id
#      and f2.type_id = ct.cvterm_id and ct.name = 'repeat_region'
#QUERY

## query to fetch PCR products

## query to fetch PCR products
my $pcr_product_query = <<QUERY;
select f.uniquename as query, t.name as subject, l.fmin as start, l.fmax as end 
from feature f, feature t, featureloc l, cvterm c
where l.srcfeature_id = f.feature_id and l.feature_id = t.feature_id 
and t.type_id = c.cvterm_id and c.name = 'PCR_product'
QUERY

## query to fetch primers
my $primer_query = <<QUERY;
select f.uniquename as query, t.name as subject, t.feature_id, l.fmin as start,
       l.fmax as end, l.strand
from feature f, feature t, featureloc l, cvterm c
where l.srcfeature_id = f.feature_id and l.feature_id = t.feature_id
       and t.type_id = c.cvterm_id and c.name = 'primer';
QUERY

##
## species, SSR motif length, min/max ssr length
## annotation search
## put id/genbank id

my $ssr_query = <<QUERY;
select sf.uniquename as assembly, cv.name as asm_so_type, c.name as feat_so_type, 
       sdbx.accession as taxon_id, o.common_name as organism, f.uniquename as feat_name, f.name as feat_alias,
       l.fmin as fmin, l.fmax as fmax, l.strand as strand, f.residues as seq
from feature f, featureloc l, feature sf, cvterm c, organism o, feature_dbxref fd, db, dbxref dbx,
       feature_dbxref sfd, db sdb, dbxref sdbx,
       cvterm cv
where f.feature_id = l.feature_id and sf.feature_id = l.srcfeature_id and f.type_id = c.cvterm_id 
       and f.organism_id = o.organism_id and f.feature_id = fd.feature_id 
       and fd.dbxref_id = dbx.dbxref_id and db.db_id = dbx.db_id
       and sf.feature_id = sfd.feature_id and sfd.dbxref_id = sdbx.dbxref_id 
       and sf.type_id = cv.cvterm_id
       and sdb.db_id = sdbx.db_id and sdb.name = 'taxon'
       and db.name = 'GFF_source' and dbx.accession in ('SSR_putative', 'primer3')
QUERY
#
#       and sdbx.accession = 4113
#order by sf.uniquename, f.uniquename

my $cgi = new CGI;


my $tmpl;

## support query by id
my $id = $cgi->param("id");
my $min_length_param  = $cgi->param("min_length");
my $max_length_param = $cgi->param("max_length");
my $motif_param = $cgi->param("motif");
my $taxon = $cgi->param("taxon");
my $asm_so_filter = $cgi->param("asm_so_type");
my $annot_text = $cgi->param("annot");
my $grp = $cgi->param("grp");

if (defined($id)) {
    $id =~ s/^\s+|\s+$//g;

    if ($id !~ /^PUT-/i) {
        $id = ($gb_to_put->get($id)) ? $gb_to_put->get($id) : uc($id);
    }
}

my @ids = ();
if ($annot_text) {
    use String::Approx qw{ amatch };

    foreach my $key(keys %annotation_db) {
#        $annotation_db{$key};
        #if (amatch($annot_text, ['i', '2'], ($annotation_db{$key}))) {
        if ($annotation_db{$key} =~ /$annot_text/i) {
#            die $key." ".$annotation_db{$key}." ".$taxon;
            push (@ids, $key);
        }
    }
}

my $dbh = DBI->connect("dbi:Pg:dbname=$db_name;host=pg.plantbiology.msu.edu", $db_user, $db_pass);
my $sth;

if ($id) {
    ## gene report page?
    if ($grp) {
        $tmpl = HTML::Template->new(filename => "ssr_db_query.grp.id.tmpl");
    } else {
            
        $tmpl = HTML::Template->new(filename => "ssr_db_query.id.tmpl");
        ## if the user's provided a sequence id, then we'll skip the other kinds of filtering on the query
        #unless ($id =~ /^(PUT-\d+[a-z]+-[^-]+-\d+|[a-z0-9]+)$/) {
        #    die "Malformed id provided to script. Hopefully this was an accident!";
        #}
    }
        $ssr_query .= "and sf.uniquename = ?";
    
        $sth = $dbh->prepare($ssr_query);
        $sth->execute($id);
} elsif ($annot_text) {
    $tmpl = HTML::Template->new(filename => "ssr_db_query.id.tmpl");
   
    $id = "annotation text search '$annot_text'";
    
    if ($taxon) {
        ## protect from injection attacks
        $taxon = int($taxon);
        $ssr_query .= " and sdbx.accession = '$taxon'";
    }

    $ssr_query .= 'and sf.uniquename in ('.join("\,", (('?') x scalar @ids)).')';
  
    $sth = $dbh->prepare($ssr_query);
    $sth->execute((@ids));
} else {
    $tmpl = HTML::Template->new(filename => "ssr_db_query.size.tmpl");
    if ($taxon) {
        ## protect from injection attacks
        $taxon = int($taxon);
        $ssr_query .= " and sdbx.accession = '$taxon'";
    }

    if ($asm_so_filter) {
        ## protect from injection attacks
        unless ($asm_so_filter eq 'sequence_assembly' || $asm_so_filter eq 'contig') {
            die "Invalid so_type parameter provided. Hopefully this was not intentional!";
        }
        $ssr_query .= " and cv.name ='$asm_so_filter'";
    }
    $ssr_query .= " order by assembly, fmin";
    $sth = $dbh->prepare($ssr_query);
    $sth->execute();
}

my $ssr = {};
use Data::Dumper;
my $rows_returned = $sth->rows();
while (my $row = $sth->fetchrow_hashref) {
    
    ## taxon_id
    ## organism
    ## assembly
    ## asm_so_type
    ## feat_name
    ## feat_so_type
    ## fmin
    ## fmax
    ## strand
    ## seq
   
    #print Dumper $row;
    
    my $asm = $row->{'assembly'};
    
    ## ssr feature
    if ($row->{'feat_so_type'} eq 'repeat_region') {
        $row->{'feat_name'} =~ /\.ssr_(\d+)(-\d+)?$/ || die Dumper $row;
        my $ssr_id = $1 - 1;
        my $motif = '';
        my $repeat_count = -1;
        if ($row->{'feat_alias'} =~ /^\(([^\)]+)\)(\d+)/) {
            $motif = $1;
            $repeat_count = $2;
        }
        ## setting each seperately in case hash has already been initialized by pcr_product or primer
        $ssr->{$asm}->[$ssr_id]->{'organism'} = $row->{'organism'};
        $ssr->{$asm}->[$ssr_id]->{'taxon_id'} = $row->{'taxon_id'};
        $ssr->{$asm}->[$ssr_id]->{'name'} = $row->{'feat_alias'};
        $ssr->{$asm}->[$ssr_id]->{'fmin'} = $row->{'fmin'};
        $ssr->{$asm}->[$ssr_id]->{'fmax'} = $row->{'fmax'};
        $ssr->{$asm}->[$ssr_id]->{'strand'} = $row->{'strand'};
        $ssr->{$asm}->[$ssr_id]->{'flen'} = $row->{'fmax'} - $row->{'fmin'};
        $ssr->{$asm}->[$ssr_id]->{'motif'} = $motif;
        $ssr->{$asm}->[$ssr_id]->{'motif_len'} = length($motif);
        $ssr->{$asm}->[$ssr_id]->{'repeat_count'} = $repeat_count;
        
#        print Dumper $row;
    } elsif ($row->{'feat_so_type'} eq 'PCR_product') {
        $row->{'feat_name'} =~ /\.ssr_(\d+)\.pcr_product_(\d+)$/ || die Dumper $row;
        my $ssr_id = $1 - 1;
        my $pcr_product_id = $2 - 1;
        $ssr->{$asm}->[$ssr_id]->{'pcr_products'}->[$pcr_product_id]->{'strand'} = $row->{'strand'};
        $ssr->{$asm}->[$ssr_id]->{'pcr_products'}->[$pcr_product_id]->{'fmin'} = $row->{'fmin'};
        $ssr->{$asm}->[$ssr_id]->{'pcr_products'}->[$pcr_product_id]->{'fmax'} = $row->{'fmax'};
        $ssr->{$asm}->[$ssr_id]->{'pcr_products'}->[$pcr_product_id]->{'flen'} = $row->{'fmax'} - $row->{'fmin'};
    } elsif ($row->{'feat_so_type'} eq 'primer') {
        $row->{'feat_name'} =~ /\.ssr_(\d+)\.primer_(\d+)([fr])$/ || die Dumper $row;
        my $ssr_id = $1 - 1;
        my $pcr_product_id = $2 - 1;
        my $primer_direction = $3;
        my $primer_id = $primer_direction.'_primer';
        $ssr->{$asm}->[$ssr_id]->{'pcr_products'}->[$pcr_product_id]->{$primer_id}->{'strand'} = $row->{'strand'};
        $ssr->{$asm}->[$ssr_id]->{'pcr_products'}->[$pcr_product_id]->{$primer_id}->{'fmin'} = $row->{'fmin'};
        $ssr->{$asm}->[$ssr_id]->{'pcr_products'}->[$pcr_product_id]->{$primer_id}->{'fmax'} = $row->{'fmax'};
        $ssr->{$asm}->[$ssr_id]->{'pcr_products'}->[$pcr_product_id]->{$primer_id}->{'flen'} = $row->{'fmax'} - $row->{'fmin'};
        $ssr->{$asm}->[$ssr_id]->{'pcr_products'}->[$pcr_product_id]->{$primer_id}->{'seq'} = $row->{'seq'};
    } else {
        print "Unmatched feature type:\n";
        print Dumper $row;
    } 
    
}


my $table_ref = [];
foreach my $id(keys(%{$ssr})) {
SSR:    foreach my $ssr_ref(@{$ssr->{$id}}) {
       
            if ($min_length_param && $ssr_ref->{'flen'} < $min_length_param) {
                next SSR;
            }
            if ($max_length_param && $ssr_ref->{'flen'} > $max_length_param) {
                next SSR;
            }
            if ($motif_param && $ssr_ref->{'motif_len'} != $motif_param) {
                next SSR;
            }
       
            my $pcr_product_count = 0;
            foreach my $pcr_product(@{$ssr_ref->{'pcr_products'}}) {
                $pcr_product_count++;
                my $table_row = {
                        id_display      =>  $id,
                        SSR             =>  $ssr_ref->{'name'},
                        size            =>  $ssr_ref->{'flen'},
                        ssr_start       =>  $ssr_ref->{'fmin'},
                        ssr_end         =>  $ssr_ref->{'fmax'},
                        has_primer      =>  1,
                        for_pri         =>  $pcr_product->{'f_primer'}->{'seq'},
                        rev_pri         =>  $pcr_product->{'r_primer'}->{'seq'},
                        product_size    =>  $pcr_product->{'flen'},
                        product_start   =>  $pcr_product->{'fmin'},
                        product_end     =>  $pcr_product->{'fmax'},
                        annotation      =>  $annotation_db{$id} || 'N/A',
                                };
               if ($grp) {
                   delete $table_row->{'id_display'};
                   delete $table_row->{'annotation'};
               }
               push(@{$table_ref}, $table_row);
           }
           if ($pcr_product_count == 0) {
                 my $table_row = {
                        id_display      =>  $id,
                        SSR             =>  $ssr_ref->{'name'},
                        size            =>  $ssr_ref->{'flen'},
                        ssr_start       =>  $ssr_ref->{'fmin'},
                        ssr_end         =>  $ssr_ref->{'fmax'},
                        has_primer      =>  0,
                        for_pri         =>  'N/A',
                        rev_pri         =>  'N/A',
                        product_size    =>  'N/A',
                        product_start   =>  'N/A',
                        product_end     =>  'N/A',
                        annotation      =>  $annotation_db{$id} || 'N/A',
                                };
               if ($grp) {
                   delete $table_row->{'id_display'};
                   delete $table_row->{'annotation'};
               }
               push(@{$table_ref}, $table_row);
           }
           
        }
}
unless (@{$table_ref}) {
    if ($grp) {
        $tmpl = HTML::Template->new(filename => "ssr_db_query.grp.no_results.tmpl");
    } else {
        $tmpl = HTML::Template->new(filename => "ssr_db_query.no_results.tmpl");
    }
    print $cgi->header();
    print $tmpl->output;
    exit();
}

@{$table_ref} = sort{$a->{'id_display'} cmp $b->{'id_display'}} @{$table_ref};

print $cgi->header();
if ($id || @ids) {
    unless ($grp) {
        $tmpl->param("id" => uc_put_id($id));
    }
} else {
    $tmpl->param("min_length_param" => $min_length_param);
    $tmpl->param("max_length_param" => $max_length_param);
    $motif_param = ($motif_param) ? $motif_param."bp" : "any size";
    $tmpl->param("motif_param" => $motif_param);
}
#$species_param=~ s/\_/ /;
#$tmpl->param("new_species_param" => $species_param);
$tmpl->param("hits_table" => $table_ref);

print $tmpl->output;

sub uc_put_id {
    my ($id) = @_;

    $id =~ s/put\-(\d+[a-z]\-)([a-z]+)/PUT\-$1\u\L$2/;
    $id =~ s/_x_([a-z]+)(_[a-z]+)/_x_\u\L$1$2/;

    return $id;
}


