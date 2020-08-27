<?php

$data_file = '_data/potato_bacs.status.txt';

if ($mode == 'summary') {
    do_summary($data_file);
} else {
    do_table($data_file);
}

function do_summary($data_file) {

    $done_count = 0;
    $sequencing_count = 0;
    $annotated_count = 0;

    $timestamp = date("F d Y", filemtime($data_file));

    $handle = @fopen($data_file, 'r');
    if ($handle) {
        while ($line = fgets($handle)) {
            $line = rtrim($line);
            $cols = explode("\t", $line);

            if ($cols[3] == 'Done') {
                $done_count++;
            } else if ($cols[3] == 'Sequencing') {
                $sequencing_count++;
            }
            if ($cols[6] == '1') {
                $annotated_count++;
            }
        }
        fclose($handle);
    }

    echo <<<BOTTOM
    <table id='potato_bac_status_summary' class='table_large'>
        <thead>
            <tr>
                <th>Total Target No. BACs</th>
                <th>BACs in Genbank</th>
                <th>BACs Annotated</th>
                <th>BACs in Sequencing</th>
            </tr>
        </thead>
        <tr>
            <td><center>575</center></td>
            <td><center>$done_count</center></td>
            <td><center>$annotated_count</center></td>
            <td><center>$sequencing_count</center></td>
        </tr>
    </table>
    <p class='timestamp'>Status updated $timestamp</p>
BOTTOM;
    //$table .= "<p class='timestamp'>Status updated ".date('l jS \of F Y h:i:s A')."</p>";
}

function do_table($data_file) {

    $timestamp = date("F d Y", filemtime($data_file));
    $lens = get_len();

    echo <<<BOTTOM
<table id='potato_bac_status' class='table_large'>
    <thead>
        <tr>
            <th>Clone Name</th>
            <th>Size</th>
            <th>GB Accession</th>
            <th>Status</th>
            <th>Position (in cm)</th>
            <th>Chr</th>
            <th>Annotation</th>
        </tr>
    </thead>
    <tbody>
BOTTOM;

    $handle = @fopen($data_file, 'r');
    if ($handle) {
        while ($line = fgets($handle)) {
            $line = rtrim($line);
            $cols = explode("\t", $line);

            $bac_len = (isset($lens[$cols[0]])) ? $lens[$cols[0]] : $cols[1];

            $gb_link = ($cols[2] != '') ?
                '<a href="http://www.ncbi.nlm.nih.gov/entrez/viewer.fcgi?db=nuccore&id='.$cols[2].'">'.$cols[2].'</a>'
                :
                $cols[2];
            $annot_link = ($cols[6] == '1') ?
                '<a href="/cgi-bin/gbrowse/solanaceae/?start=0;stop=1e8;ref='.$cols[2].'">Available</a>'
                :
                'N/A';
 
            echo <<<BOTTOM
<tr>
    <td>$cols[0]</td>
    <td>$bac_len</td>
    <td>$gb_link</td>
    <td>$cols[3]</td>
    <td>$cols[4]</td>
    <td>$cols[5]</td>
    <td>$annot_link</td>
BOTTOM;

        }
        fclose($handle);
    }

    echo <<<BOTTOM
    </tbody>
</table>
<p class='timestamp'>Status updated $timestamp</p>
BOTTOM;

}

function get_len() {
    $lengths = array();

    $DB_USER = '';
    $DB_PASS = '';

    mysql_connect('mysql', $DB_USER, $DB_PASS);
    mysql_select_db('sol_seq');
    
    $query = "select g.accession as id, g.seqlen as len from genbank g, type t where g.type_id = t.type_id and t.name = 'contig' and g.is_obsolete = 0";
    
    $result = mysql_query($query);
    
    if (! $result) {
        die('Query failed: '.mysql_error());
    }
    
    while ($row = mysql_fetch_assoc($result)) {
        $lengths[$row['id']] = $row['len'];
    }
    
    return $lengths;
}

?>
