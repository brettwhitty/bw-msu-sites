#!/usr/bin/perl

use warnings;
use strict;

use FindBin qw{ $RealBin };
use lib "$RealBin/../lib/perl5/site_perl/5.8.8";

use CGI;
use CGI::Carp qw( fatalsToBrowser );
use HTML::Template;

use File::Temp;

use Cwd qw{ abs_path };
use File::Basename qw{ basename dirname };

use DB_File;
#use MLDBM qw{ DB_File Storable };

use DBM::Deep;

use DBI;
use XML::Dumper;
my $dumper = new XML::Dumper();
my $db_user = $ENV{'DB_USER'};
my $db_pass = $ENV{'DB_PASS'};
my $dbh = DBI->connect("dbi:Pg:dbname=solcomp_search;host=pg", $db_user, $db_pass);
my $xml_query = 'select s.value as xml from name n, snp s where n.id = s.name_id and n.value = ?';
my $sth = $dbh->prepare($xml_query);

use Bio::Graphics;
use Bio::SeqFeature::Generic;

use GBtoPUT;

use Sol::SimpleAlign::DBIReader;
use Sol::SimpleAlign::Util;

my $doc_path = $ENV{"DOCUMENT_ROOT"};

my $script_path = dirname(abs_path($0))."/";
my $temp_path = "$doc_path/webserver_tmp";
my $rel_temp_path = "/webserver_tmp";

#
#tie my %put_function, 'DB_File', '../put_function.db', 0444 || die;
#
my $gb_to_put = new GBtoPUT('db_path' => $script_path.'db');


my $cgi = new CGI;
my $taxon   = $cgi->param("taxon");
my $id      = $cgi->param("id");
my $grp     = $cgi->param("grp");

print $cgi->header;

#$id = 'PUT-163a-Solanum_habrochaites-3037';
$id = lc($id);

$id =~ s/^\s*//;
$id =~ s/\s*$//;

## lookup PUT by GB id
if ($id !~ /^PUT-/i) {
    $id = lc($gb_to_put->get($id)) || $id;
}

unless ($id) {
    handle_error();
}
    
#my $put_id = $snp_asm->{'put_id'};
$id =~ /put-\d+[a-z]+-([^-]+)/i || handle_error("The provided PUT ID '$id' has an unexpected format.", 1);
my $species_string = $1;

my $put_id = uc_put_id($id);

my $function_query = 'select o.value from name n, note o where n.id = o.name_id and n.value = ? order by o.id limit 1';
my $fsth = $dbh->prepare($function_query);
$fsth->execute($put_id);
my ($function_text) = $fsth->fetchrow_array();

#my $snps_db_name = $script_path.$species_string.'.alignment.with_subseq.snp.db';
#my $snps_db      = new DBM::Deep($snps_db_name);

#my $snps_ref;
my $snp_asm;
$sth->execute($put_id);
my ($xml) = $sth->fetchrow_array();
if ($xml) {
    $snp_asm = $dumper->xml2pl($xml);
} else {
    handle_error();
}

#my $snp_asm = $snps_ref->export();

my @snps;
my @snp_pos;
foreach my $snp(@{$snp_asm->{'snps'}}) {
    my $ref_count = $snp->{lc($snp->{'ref'})};
    my $snp_count = $snp->{lc($snp->{'snp'})};
    push(@snps, {
                    'snp_location'  => $snp->{'loc'},
                    'reference'     => $snp->{'ref'},
                    'ref_count'     => $ref_count,
                    'snp'           => $snp->{'snp'},
                    'snp_count'     => $snp_count,
                });
    push(@snp_pos, $snp->{'loc'});
}


## create the overview image
my ($snp_loc_png, $img_map_html) = generate_snp_location_png($snp_asm, \@snps);

## create the multiple sequence alignment div
   ## create reader object
#my $db = new Sol::SimpleAlign::Reader(
#    db => "$species_string.alignment.with_subseq.db",
#                                     );
my $db = new Sol::SimpleAlign::DBIReader(
    'db'        =>  'dbi:Pg:dbname=solcomp_search;host=pg', 
    'user'      =>  $db_user,
    'password'  =>  $db_pass,
                                     );

                                     
    ## get alignment                                      
my $aln = $db->get_alignment($put_id) || handle_error("No alignment was found for id='$put_id'.", 1);

    ## remove gap positions based on consensus
    ## (otherwise SNP coordinates are going to be wrong)
$aln->splice_by_seq_pos(1);

my $aln_util = new Sol::SimpleAlign::Util();
    
    ## sort alignment members by seq start position
    ## (to make it look a little nicer)
$aln_util->sort_by_start($aln);

#use Data::Dumper;
#print Dumper $aln;
#die();

## get mismatch coordinates
my @coords = $aln_util->get_mismatch_coords($aln);

    ## output the aligment div contents
my $msa = $aln_util->get_alignment_html(
        $aln,
        'each_character'    =>  1,
        'char_class'        =>  {
            'mismatch'  =>  \@coords,
            'snp'       =>  \@snp_pos,
        },
    );

## quick hack because I don't want to change the module right now
## but the PUT names can be too long
$msa =~ s/(PUT-[^<]+)/consensus/;
    
## populate the template
my $template_name;
my $tmpl;

if ($grp) {
    $template_name = "sol_snps.grp.tmpl";
    $tmpl = HTML::Template->new(filename => $template_name);

    $tmpl->param("asm_len"      => $snp_asm->{'size'});
    $tmpl->param("snp_img"      => $snp_loc_png);
    $tmpl->param("snp_loop"     => \@snps);
    $tmpl->param("msa"          => $msa);

} else {
    $template_name = "sol_snps.report.tmpl";
    $tmpl = HTML::Template->new(filename => $template_name);

    $tmpl->param("id"           => $snp_asm->{'put_id'});
    $tmpl->param("function"     => (defined($function_text))
                                   ? $function_text : 'N/A');
    $tmpl->param("asm_acc"      => $snp_asm->{'put_id'});
    $tmpl->param("asm_len"      => $snp_asm->{'size'});
    $tmpl->param("sci_name"     => $snp_asm->{'species'});
    $tmpl->param("num_elems"    => $snp_asm->{'member_count'});
    $tmpl->param("snp_img"      => $snp_loc_png);
    $tmpl->param("snp_loop"     => \@snps);
    $tmpl->param("msa"          => $msa);
}

print $tmpl->output;

sub handle_error {
    my ($message, $bug) = @_;

    my $tmpl;
    if ($grp) {
            $tmpl = HTML::Template->new(filename => "sol_snps.grp.error.tmpl");
    } else {
            $tmpl = HTML::Template->new(filename => "sol_snps.error.tmpl");
            
            $tmpl->param('bug'  => $bug);
            $tmpl->param('message'  => $message);
            
            $id = uc_put_id($id);            
            $tmpl->param('id' => $id);
            
    }
    print $tmpl->output;

    exit(1);
}

sub uc_put_id {
    my ($id) = @_;

    $id =~ s/put\-(\d+[a-z]\-)([a-z]+)/PUT\-$1\u\L$2/;
    $id =~ s/_x_([a-z]+)(_[a-z]+)/_x_\u\L$1$2/;

    return $id;
}

sub generate_snp_location_png {
    my ($snp_asm, $snps_arr_ref) = @_;

    my $snp_tmp = new File::Temp( 
                                    TEMPLATE    => "temp_sol_snpXXXXX", 
                                    DIR         => $temp_path, 
                                    SUFFIX      => ".png",
                                    UNLINK      => 0,
                                );

    my $snp_features;
    foreach my $snp(@{$snps_arr_ref}) {                                
        my $feature = Bio::Graphics::Feature->new( 
                            -start          => $snp->{'snp_location'},
                            -end            => $snp->{'snp_location'},
                            -display_name   => $snp->{'snp_location'}
                                              .":["
                                              .$snp->{'reference'}
                                              ."/"
                                              .$snp->{'snp'}
                                              ."]",
                                                 );
        push(@$snp_features, $feature);
    }
    
    my $panel = Bio::Graphics::Panel->new( 
                                        -length     =>  $snp_asm->{'size'},
                                        -width      =>  880,
                                        -pad_left   =>  20,
                                        -pad_right  =>  20,
                                         );

    $panel->add_track( $snp_features,
                                        -glyph => 'triangle',
                                        -bgcolor => 'red',
                                        -fgcolor => 'red',
                                        -point => 1,
                                        -height => 8,
                                        -label => sub { my $f = shift; return $f->display_name;}
                     );
                                                
    $panel->add_track( arrow => Bio::SeqFeature::Generic->new(
                                                -start  => 1,
                                                -end    => $snp_asm->{'size'},
                                                -display_name => $snp_asm->{'put_id'},
                                                -strand => 1,
                                                             ),
                    -glyph => 'box',
                    -bgcolor => 'blue',
                    -fgcolor => 'black',
                    -font2color => 'black',
                    -label => 0,
                    -description => sub { my $f = shift; return $f->display_name;}
                    );  
        $panel->add_track(arrow => Bio::Graphics::Feature->new( 
                                                -start => 1,
                                                -end => $snp_asm->{'size'},
                                                              ),
                    -glyph => 'arrow',
                    -tick => 2,
                    -label => 1,
                    );

    print $snp_tmp $panel->png;

    my $image_map = $panel->create_web_map(
                        'snp_map', 
                            \&create_link, 
                            \&create_title, 
                            \&create_target,
                    );
   
    print $image_map;
                    
    my $qual_fn = $snp_tmp->filename;
    my $mode = 0644;

    chmod($mode, $qual_fn) or handle_error("Failed to change permissions on temp file.", 1);

#    $qual_fn =~ /\/(temp_\w+.png)$/;
    my $snp_fn = $rel_temp_path."/".basename($qual_fn);
                               
    return $snp_fn; 
}

sub create_link {
    my ($feature) = @_;

    ## no link on PUT sequence for now
    if (! defined($feature->display_name) || $feature->display_name =~ /^PUT/i) {
        return undef;
    } else {
        return '#';
    }
}
sub create_title {
    my ($feature) = @_;
   
    if ($feature->display_name =~ /^(\d+)/) {
       return $1;
   } else {
       return undef;
   }
}
sub create_target {
    my ($feature) = @_;
    
    return '_self';
}
