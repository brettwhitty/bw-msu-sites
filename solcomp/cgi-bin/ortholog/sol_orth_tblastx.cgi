#!/usr/bin/perl -w

use strict;
use CGI;
use CGI::Carp qw( fatalsToBrowser );
use GD;
use File::Temp;
#use DBI;
use HTML::Template;
use Cwd qw{ abs_path };
use File::Basename qw{ dirname };


use DB_File;
use MLDBM qw{ DB_File Storable };

my $doc_path = $ENV{"DOCUMENT_ROOT"};

my $script_path = dirname(abs_path($0))."/";
my $db_path = $script_path.'db/';

my $len_db_name         = $db_path.'puts.lengths.db';
my $seq_db_name         = $db_path.'puts.seq.db';
my $paralog_db_name     = $db_path.'puts.paralog.db';
my $ortholog_db_name    = $db_path.'puts.ortholog.db';

tie my %len_db, 'DB_File', $len_db_name, O_RDONLY or die "Failed to tie $len_db_name";
tie my %seq_db, 'DB_File', $seq_db_name, O_RDONLY;
tie my %paralog_db, 'MLDBM', $paralog_db_name, O_RDONLY;
tie my %ortholog_db, 'MLDBM', $ortholog_db_name, O_RDONLY;

my $q = new CGI;
my $ta = $q->param("ta");
my $hit_type = $q->param("hit_type");
my $grp = $q->param('grp');

$ta = lc($ta);

$ta =~ s/^\s*//;
$ta =~ s/\s*$//;

my ($query_taxon, $sci_name_query, $query_length) = ( undef, undef, $len_db{$ta} ); 

#orthologues
if ($hit_type eq 'orth') {

    unless (defined($ortholog_db{$ta})) {
        handle_error();
    }

    my $elem_table = create_elem_table($ta);

    my $fasta = print_html_fasta($ta); 

    my $tmpl;
    if ($grp) {
        $tmpl = HTML::Template->new(filename => "sol_orth_report.grp.tmpl");

        $tmpl->param("elem_table" => $elem_table);
        $tmpl->param("fasta" => $fasta );
    } else {
        $tmpl = HTML::Template->new(filename => "sol_orth_report.tmpl");

        $ta = uc_put_id($ta);

        $tmpl->param("ta" => $ta);
        $tmpl->param("query_length" => $query_length);
        $tmpl->param("elem_table" => $elem_table);
        $tmpl->param("fasta" => $fasta );
    }

    print $q->header;
    print $tmpl->output;

} else {

    ## paralogs
    
    unless (defined($paralog_db{$ta})) {
        handle_error();
    }
    
    my $elem_table = create_elem_table($ta, 1);

    my $fasta = print_html_fasta($ta, 1); 

    my $tmpl;

    if ($grp) {
        $tmpl = HTML::Template->new(filename => "sol_para_report.grp.tmpl");

        $tmpl->param("elem_table" => $elem_table);
        $tmpl->param("fasta" => $fasta );
    } else {
        $tmpl = HTML::Template->new(filename => "sol_para_report.tmpl");

        $ta = uc_put_id($ta);

        $tmpl->param("ta" => $ta);
        $tmpl->param("query_length" => $query_length);
        $tmpl->param("elem_table" => $elem_table);
        $tmpl->param("fasta" => $fasta );
    }
    print $q->header;
    print $tmpl->output;

}

sub uc_put_id {
    my ($id) = @_;

    $id =~ s/put\-(\d+[a-z]\-)([a-z]+)/PUT\-$1\u\L$2/;
    $id =~ s/_x_([a-z]+)(_[a-z]+)/_x_\u\L$1$2/;

    return $id;
}

sub create_elem_table {
    
    my ($ta, $paralog_flag) = @_;
    
    my $table_rows = [];
    
    if ($paralog_flag) {
        $table_rows = $paralog_db{$ta};
    } else {
        $table_rows = $ortholog_db{$ta};
    }
    
    return $table_rows;

}


sub print_html_fasta {

    my ($ta, $paralog_flag) = @_;

    my $table_rows = [];
    if ($paralog_flag) {
        $table_rows = $paralog_db{$ta};
    } else {
        $table_rows = $ortholog_db{$ta};
    }

    my $seq = '';
    foreach my $hit(@{$table_rows}) {
        my $target_id = lc($hit->{'target_ta'}); 
        $seq .= $seq_db{$target_id};
    }
 
    return $seq;   
}


sub handle_error {
    my $tmpl;
    if ($grp) {
        $tmpl = HTML::Template->new(filename => "sol_orth_report_err.grp.tmpl");
     } else {
        $tmpl = HTML::Template->new(filename => "sol_orth_report_err.tmpl");
        $tmpl->param("ta" => $ta);
     }

     print $q->header;
     print $tmpl->output;

     exit(1);
}
