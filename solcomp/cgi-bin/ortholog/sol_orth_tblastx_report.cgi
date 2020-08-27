#!/usr/bin/perl -w

use strict;
use CGI;
use CGI::Carp qw( fatalsToBrowser );
use GD;
use File::Temp;
use DBI;
use HTML::Template;

# my $host = $ENV{"SERVER_NAME"} eq "mysql.tigr.org" ? "mysql" : "thunder";

my $doc_path = $ENV{"DOCUMENT_ROOT"};

#open(HTML_INC_HEADER, "<$doc_path/tdb/sol/inc/sol_header.html"); 
#open(HTML_INC_NAVBAR, "<$doc_path/tdb/sol/inc/sol_navbar.html"); 

#my @html_inc_header = <HTML_INC_HEADER>;
#my @html_inc_navbar = <HTML_INC_NAVBAR>;
#my $html_inc_header = join("\n", @html_inc_header);
#my $html_inc_navbar = join("\n", @html_inc_navbar);

#close(HTML_INC_HEADER);
#close(HTML_INC_NAVBAR);


my $dbh1 = DBI->connect("dbi:mysql:plantta:mysql","access","access", {RaiseError => 1});
my $dbh2 = DBI->connect("dbi:mysql:solanaceae_ta:mysql","access","access", {RaiseError => 1});
        
my $q = new CGI;
my $ta = $q->param("ta");
my $hit_type = $q->param("hit_type");

$ta = uc($ta);

$ta =~ s/^\s*//;
$ta =~ s/\s*$//;

# if TA is not found in tblastx_hits table
my ($asm_id) = $dbh2 ->selectrow_array("select query_name from solanaceae_ta.tblastx_hits where query_name = \"$ta\"" );
unless($asm_id){
        
            #die "Handle Error Here\n";
            my $tmpl = HTML::Template->new(filename => "sol_orth_report_err.tmpl");
#                   $tmpl->param("header" => $html_inc_header);
#               $tmpl->param("navbar" => $html_inc_navbar);
            $tmpl->param("ta" => $ta);
            print $q->header;
            print $tmpl->output;
           exit;
}


#Find info on the query:

my ($query_taxon, $sci_name_query, $query_length) = $dbh1->selectrow_array("select distinct r.taxon_id, t.scientific_name, a.sequence_length from assembly a, `release` r, taxon t where a.release_id =r.release_id and r.taxon_id=t.taxon_id and a.assembly_accession = \"$ta\"");

#orthologues
if ($hit_type eq 'orth') {

my $sth_hits = $dbh1->prepare("select distinct a.assembly_accession, t.scientific_name, a.sequence_length, s.percent_identity, s.e_value, s.query_left, s.query_right, a.sequence from taxon t, assembly a, `release` r, solanaceae_ta.tblastx_hits s where  a.release_id =r.release_id and r.taxon_id = t.taxon_id and s.target_name= a.assembly_accession and s.query_name =\"$ta\" and not r.taxon_id =\"$query_taxon\" order by s.e_value") or die;

$sth_hits->execute;
my $hits = $sth_hits->fetchall_arrayref;
$sth_hits->finish;


my $elem_table = create_elem_table($ta,$hits);

my $fasta = print_html_fasta($ta, $hits); 

my $tmpl = HTML::Template->new(filename => "sol_orth_report.tmpl");
#$tmpl->param("header" => $html_inc_header);
#$tmpl->param("navbar" => $html_inc_navbar);
$tmpl->param("ta" => $ta);
$tmpl->param("sci_name_query" => $sci_name_query);
$tmpl->param("query_length" => $query_length);
$tmpl->param("elem_table" => $elem_table);
$tmpl->param("fasta" => $fasta );


print $q->header;
print $tmpl->output;
}

# paralogues
else {

my $sth_hits_para = $dbh1->prepare("select distinct a.assembly_accession, t.scientific_name, a.sequence_length, s.percent_identity, s.e_value, s.query_left, s.query_right, a.sequence from taxon t, assembly a, `release` r, solanaceae_ta.tblastx_hits s where  a.release_id =r.release_id and r.taxon_id = t.taxon_id and s.target_name= a.assembly_accession and s.query_name =\"$ta\" and r.taxon_id =\"$query_taxon\" order by s.e_value") or die;

$sth_hits_para->execute;
my $hits_para = $sth_hits_para->fetchall_arrayref;
$sth_hits_para->finish;

my $elem_table = create_elem_table($ta,$hits_para);

my $fasta = print_html_fasta($ta, $hits_para); 

my $tmpl = HTML::Template->new(filename => "sol_para_report.tmpl");
#$tmpl->param("header" => $html_inc_header);
#$tmpl->param("navbar" => $html_inc_navbar);
$tmpl->param("ta" => $ta);
$tmpl->param("sci_name_query" => $sci_name_query);
$tmpl->param("query_length" => $query_length);
$tmpl->param("elem_table" => $elem_table);
$tmpl->param("fasta" => $fasta );

print $q->header;
print $tmpl->output;

}


sub create_elem_table {
    my $ta = shift;
    my @hit_table = @{$_[0]};
    my $table_rows = [];
    for (@hit_table) {
#       my $sci_name =$_->[1];
        my $row_hash = {target_ta => $_->[0], sci_name => $_->[1], target_length => $_->[2], per_id => sprintf ("%.1f",$_->[3]), per_coverage => sprintf ("%.1f",(abs(($_->[6]) - ($_->[5]))*100/$query_length)), e_value => $_->[4]};
##@$table_rows is the array value of what is in $table_rows (= all previous $row_hash, or all previous reference to hash in $row_hash)
        push(@$table_rows, $row_hash);
        }
    return $table_rows;
    }


sub print_html_fasta {
    my $ta = shift;
    my @hit_table = @{$_[0]};
    my $table_rows = [];
    my $fasta_rows = [];
    for (@hit_table) {
        my $def =$_->[0];
        my $sci_name_target =$_->[1];
        my $seq =$_->[7];
    #line length
        my $len = 60;
        push(@$fasta_rows, { "row" => ">$def $sci_name_target"});
            for (my $pos = 0; $pos < length($seq); $pos+=$len ){
            push(@$fasta_rows, { "row" => substr($seq, $pos, $len) });
            }
    }
    return $fasta_rows;
}










# works:
# select distinct a.assembly_accession, t.scientific_name, a.sequence_length, s.percent_identity, s.e_value, s.query_left,s.query_right,a.sequence from taxon t, assembly a, `release` r, solanaceae_ta.tblastx_hits s where  a.release_id =r.release_id and r.taxon_id = t.taxon_id and s.target_name= a.assembly_accession and s.query_name ="A15447"and r.taxon_id ="4081";

# select distinct a.assembly_accession, t.scientific_name, a.sequence_length, s.percent_identity, s.e_value, s.query_left,s.query_right,a.sequence from taxon t, assembly a, `release` r, solanaceae_ta.tblastx_hits s where  a.release_id =r.release_id and r.taxon_id = t.taxon_id and s.target_name= a.assembly_accession and s.query_name ="CK715441"and r.taxon_id ="4081";
