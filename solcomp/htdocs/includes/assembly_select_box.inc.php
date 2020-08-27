<?php
    
    $org = (isset($_GET['org'])) ? $_GET['org'] : '';
    $chr = (isset($_GET['chr'])) ? $_GET['chr'] : '';

    $DB_USER = '';
    $DB_PASS = '';

    $link = mysql_connect('mysql.plantbiology.msu.edu', $DB_USER, $DB_PASS);
    if (! $link) {
        die('Could not connect: '.mysql_error());
    }
    if (! mysql_select_db('sol_seq', $link)) {
        die('Could not select database: sol_seq');
    }

    $query = 'select x.taxon_id as taxon_id, x.scientific_name as name, g.replicon as replicon, g.accession as accession from genbank g, type t, taxon x where g.type_id=t.type_id and g.taxon_id = x.taxon_id and t.name="contig" and g.date <= (select max(date) from releases) and g.taxon_id = '.$org.' order by x.taxon_id, g.replicon asc, g.accession';
    
    $result = mysql_query($query);
    if (! $result) {
        die('Query failed: '.mysql_error());
    }
?>
<select name="select_accession" id="select_accession">
   <option value="">--- accession ---</option>
<?php
    while ($row = mysql_fetch_assoc($result)) {
        echo "    <option value=\"".$row['accession']."\">$row[replicon]: $row[accession]</option>\n";
    }
    
    mysql_close($link);
?>
</select>
