#!/usr/bin/perl

use strict;
use warnings;

use CGI;
use CGI::Carp('fatalsToBrowser');
use HTML::Template;

use DBI;

my $db_name = 'solcomp_search';
my $db_user = $ENV{'db_user'};
my $db_pass = $ENV{'db_pass'};

my $dbh = DBI->connect("dbi:Pg:dbname=$db_name;host=pg", $db_user, $db_pass);

my $alias_query = $dbh->prepare("select n.value from name n, db d, alias a where a.name_id = n.id and d.id = 1 and a.value = ?");

my $mapping_query = $dbh->prepare("select n.value as query_id, d.id as db_id, nm.value as subject_id, a.value as subject_alias, m.* from (mapping m left outer join alias a on m.subject_name_id = a.name_id) join name n on m.query_name_id = n.id join name nm on m.subject_name_id = nm.id join db d on nm.db_id = d.id and n.value = ? order by d.id, m.rank");

#my $gene_link = {
#    'arabidopsis' => 'http://www.arabidopsis.org/servlets/Search?type=general&search_action=detail&method=1&sub_type=gene&name=',
#    'grape'     => 'http://www.genoscope.cns.fr/cgi-bin/ggb/vitis/geneView?src=vitis&name=',
#    'medicago'  => 'http://www.medicago.org/genome/show_reports.php?type=Everywhere&search=',
#    'poplar'    => 'http://genome.jgi-psf.org/cgi-bin/dispGeneModel?db=Poptr1_1&tid=',         
#                };

my $gene_link = {
    'arabidopsis' => '/cgi-bin/gbrowse/arabidopsis/?name=',
    'grape'     => '/cgi-bin/gbrowse/grape/?name=',
    'medicago'  => 'http://www.medicago.org/genome/show_reports.php?type=Everywhere&search=',
    'poplar'    => '/cgi-bin/gbrowse/poplar/?name=',
};
my $org_db_id = {
    '3' =>  'arabidopsis',
    '4' =>  'grape',
    '5' =>  'poplar',
};

my $cgi = new CGI;
my $tmpl;

my $id = lc($cgi->param("id")) || '';
my $organism = lc($cgi->param("org")) || '';
my $grp = $cgi->param("grp");

$id =~ s/^\s+|\s+$//g;

print $cgi->header();

if ($id !~ /^PUT-/i) {
    $alias_query->execute(uc($id));
    my @row = $alias_query->fetchrow_array;
    $id = $row[0] || $id;
}

my $table_ref = [];

$mapping_query->execute(uc_put_id($id));

while (my $ref = $mapping_query->fetchrow_hashref()) {

    if ($organism ne $org_db_id->{$ref->{'db_id'}}) {
        next;
    }

    my $link_id = (defined($ref->{'subject_alias'})) ? $ref->{'subject_alias'} : $ref->{'subject_id'};

    push(@{$table_ref},
        {
            'hit_id'        =>  $ref->{'subject_id'},
            'link'          =>  $gene_link->{$org_db_id->{$ref->{'db_id'}}} . $link_id,
            'score'         =>  $ref->{'score'},
            'evalue'        =>  $ref->{'expect'},
            'identity'      =>  sprintf("%d%%", $ref->{'identity'} * 100),
            'similarity'    =>  sprintf("%d%%", $ref->{'similarity'} * 100),
            'coverage'      =>  sprintf("%d%%", $ref->{'coverage'} * 100),
        }
    );
}

if (@{$table_ref}) {

    if ($grp) {
        $tmpl = HTML::Template->new(filename => 'map_search.grp.tmpl');
        $tmpl->param('table_id'     => $organism . "_hits_table");
        $tmpl->param("organism"     => ucfirst($organism));
    #    $tmpl->param("organism_link" => '');
        $tmpl->param("hits_table"   => $table_ref);
    } else {
        $tmpl = HTML::Template->new(filename => 'map_search.result.tmpl');

        $tmpl->param("organism"     => ucfirst($organism));
    #    $tmpl->param("organism_link" => '');
        $tmpl->param("id"           => uc_put_id($id));
        $tmpl->param("e_value"      => '1e-10');
        $tmpl->param("hits_table"   => $table_ref);
    }

    print $tmpl->output;

} else {
    # do error

    if ($grp) {
        print "No data available.";
    } else {
        $tmpl = HTML::Template->new(filename => 'map_search.error.tmpl');

        $tmpl->param("organism"     => ucfirst($organism));
        $tmpl->param("id"           => uc_put_id($id));
        $tmpl->param("e_value"      => '1e-10');

        print $tmpl->output;
    }
}

sub uc_put_id {
    my ($id) = @_;

    $id =~ s/put\-(\d+[a-z]\-)([a-z]+)/PUT\-$1\u\L$2/;
    $id =~ s/_x_([a-z]+)(_[a-z]+)/_x_\u\L$1$2/;

    return $id;
}
