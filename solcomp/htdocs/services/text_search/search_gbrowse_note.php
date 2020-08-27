<?php

    // removed these
    $DB_USER = '';
    $DB_PASS = '';

    // set a maximum number of results to return from a search
    $max_results = 5000;

    // get parameters
    $db     = (isset($_GET['db']))  ? $_GET['db'] : '';
    $key    = (isset($_GET['key'])) ? $_GET['key'] : '';
  
    /****************************************************/

    require_once($_SERVER['DOCUMENT_ROOT'].'/includes/TaxonList.php');
    $t = new TaxonList(0);
    $taxon_hash = $t->get_hash();
   
    // pad start and end positions of linked features by this much
    $link_padding = 1000;
    
    // these are valid searchable DB names
    $valid_dbs = array(
        'solanaceae'    =>  'sol_gbrowse',
        'arabidopsis'   =>  'sol_arabidopsis',
        'grape'         =>  'sol_dev_gbrowse_grape',
        'poplar'        =>  'sol_poplar'
                      );
    
    // define the feature types with attributes to search                      
    $att_types = array(
        'solanaceae'    =>  array(
                                    'Note',
                                    'Alias',
                                 ),
        'arabidopsis'   =>  array(
                                    'Note',
                                    'Alias'
                                 ),
        'grape'         =>  array(
                                    'Note',
                                    'Alias'
                                 ),
        'poplar'        =>  array(
                                    'Note',
                                    'Alias'
                                 )
                       );            

    // define the feature types (and descriptive text) with attributes to search
    $feat_types = array(
        'solanaceae'    =>  array(
         //    /* duplicate */      'gene:uniref100',
             'cDNA_match:uniref100'             => 'protein2genome:UniRef100',
             'match:uniref100'                  => 'AAT:UniRef100',
             'match:blastp_sprot_viridiplantae' => 'BLASTP:SProt(Plants)',
             'match:blastp_arabidopsis'         => 'BLASTP:Arabidopsis',
             'match:blastp_uniref100'           => 'BLASTP:UniRef100',
             'match:blastp_medicago'            => 'BLASTP:Medicago',
             'match:InterProScan'               => 'InterProScan',
             'match:blastp_sprot_sol'           => 'BLASTP:SProt(Solanaceae)',
             'gene:GenBank'                     => 'GenBank',
             'CDS:GenBank'                      => 'GenBank',
             'chromosome:GenBank'               => 'GenBank',
             'contig:GenBank'                   => 'GenBank',
            'gene:Capsicum_annuum'             =>  'SGR',
            'gene:Nicotiana_benthamiana'       =>  'SGR',
            'gene:Nicotiana_langsdorffii_x_Nicotiana_sanderae' =>  'SGR',
            'gene:Nicotiana_sylvestris'        =>  'SGR',
            'gene:Nicotiana_tabacum'           =>  'SGR',
            'gene:Petunia_x_hybrida'           =>  'SGR',
            'gene:Solanum_chacoense'           =>  'SGR',
            'gene:Solanum_habrochaites'        =>  'SGR',
            'gene:Solanum_lycopersicum'        =>  'SGR',
            'gene:Solanum_pennellii'           =>  'SGR',
            'gene:Solanum_tuberosum'           =>  'SGR'

                                 ),
        'arabidopsis'   =>  array(
             'gene:TAIR8'                       => 'TAIR8',
             'mRNA:TAIR8'                       => 'TAIR8',
             'pseudogene:TAIR8'                 => 'TAIR8',
             'transposable_element_gene:TAIR8'  => 'TAIR8',
             'mRNA_TE_gene:TAIR8'               => 'TAIR8',
            'gene:Capsicum_annuum'             =>  'SGR',
            'gene:Nicotiana_benthamiana'       =>  'SGR',
            'gene:Nicotiana_langsdorffii_x_Nicotiana_sanderae' =>  'SGR',
            'gene:Nicotiana_sylvestris'        =>  'SGR',
            'gene:Nicotiana_tabacum'           =>  'SGR',
            'gene:Petunia_x_hybrida'           =>  'SGR',
            'gene:Solanum_chacoense'           =>  'SGR',
            'gene:Solanum_habrochaites'        =>  'SGR',
            'gene:Solanum_lycopersicum'        =>  'SGR',
            'gene:Solanum_pennellii'           =>  'SGR',
            'gene:Solanum_tuberosum'           =>  'SGR'
                                 ),
        'grape'         =>  array(
             'gene:Vitis_vinifera'              => 'Genoscope',
             'mRNA:Vitis_vinifera'              => 'Genoscope',
             'gene:Capsicum_annuum'             =>  'SGR',
             'gene:Nicotiana_benthamiana'       =>  'SGR',
             'gene:Nicotiana_langsdorffii_x_Nicotiana_sanderae' =>  'SGR',
             'gene:Nicotiana_sylvestris'        =>  'SGR',
             'gene:Nicotiana_tabacum'           =>  'SGR',
             'gene:Petunia_x_hybrida'           =>  'SGR',
             'gene:Solanum_chacoense'           =>  'SGR',
             'gene:Solanum_habrochaites'        =>  'SGR',
             'gene:Solanum_lycopersicum'        =>  'SGR',
             'gene:Solanum_pennellii'           =>  'SGR',
             'gene:Solanum_tuberosum'           =>  'SGR'
                                 ),
        'poplar'        =>  array(
            'gene:JGI'  => 'JGI',
            'mRNA:JGI'  => 'JGI',
            'CDS:JGI'   => 'JGI',
            'gene:Capsicum_annuum'             =>  'SGR',
            'gene:Nicotiana_benthamiana'       =>  'SGR',
            'gene:Nicotiana_langsdorffii_x_Nicotiana_sanderae' =>  'SGR',
            'gene:Nicotiana_sylvestris'        =>  'SGR',
            'gene:Nicotiana_tabacum'           =>  'SGR',
            'gene:Petunia_x_hybrida'           =>  'SGR',
            'gene:Solanum_chacoense'           =>  'SGR',
            'gene:Solanum_habrochaites'        =>  'SGR',
            'gene:Solanum_lycopersicum'        =>  'SGR',
            'gene:Solanum_pennellii'           =>  'SGR',
            'gene:Solanum_tuberosum'           =>  'SGR'
                                )
                       );            
  
    // for adding to the query                       
    $atts = "('".implode("','", $att_types[$db])."')";
    $feats = "('".implode("','", array_keys($feat_types[$db]))."')";
                       
    // query all 'Note' attributes in a gbrowse database for a keyword                   
    $query = "select f.id as feat_id, n.name as name, s.seqname as accession, 
        f.start as start, f.end as end, t.tag as feat_type, a.attribute_value as description
        from feature f, name n, typelist t, attribute a, attributelist al, locationlist s
        where f.id=a.id and f.id = n.id and f.seqid=s.id and f.typeid=t.id and a.attribute_id=al.id and n.display_name = 1
        and al.tag in $atts and a.attribute_value like '%$key%' and t.tag in $feats
        group by s.seqname, f.start, f.end, t.tag order by description, accession, start";
   
    // check parameters
    if ($key == '') {
        do_error('No keyword provided for search.');
    }
    if ($db == '') {
        do_error('No database provided for search.');
    }
    if (! array_key_exists($db, $valid_dbs)) {
        do_error('Database provided for search is invalid.');
    }
    
    // connect to db
    $link = mysql_connect('mysql.plantbiology.msu.edu', $DB_USER, $DB_PASS);
    if (! $link) {
        do_error('Could not connect: '.mysql_error());
    }
    
    // prevent injection
    $key = mysql_real_escape_string($key, $link);
    
    if (! mysql_select_db($valid_dbs[$db], $link)) {
        do_error('Could not select database: '.$db);
    }

    if ($db == 'solanaceae') {
    
        //prepare a hash of accession -> species mappings
        $result = mysql_query("select n.name, a.attribute_value from attribute a, attributelist al, name n where n.id = a.id and a.attribute_id = al.id and al.tag = 'Dbxref' and a.attribute_value like 'taxon:%'");
        if (! $result) {
            do_error('Database query failed: '.mysql_error());
        }
        $taxon_lookup = array(); 
        while ($row = mysql_fetch_array($result)) {
            $row[1] = preg_replace("/taxon:/", '', $row[1]);
            $taxon_lookup[$row[0]] = $row[1];
        }
    }
    
    $result = mysql_query($query);
    if (! $result) {
        do_error('Database query failed: '.mysql_error());
    }
    $row_count = mysql_num_rows($result);

    echo "$row_count||";
    echo "<table>\n";
    echo "<caption><ul></ul></caption>\n"; //for pagination
    echo "<thead>\n";
    echo "  <tr>\n";
    if ($db == 'solanaceae') {
        echo "    <th>Species</th>\n";
    }
    echo "    <th>Accession</th>\n";
//    echo "    <th>Start</th>\n";
//    echo "    <th>End</th>\n";
//    echo "    <th>Type</th>\n";
    echo "    <th>Match Accession</th>\n";
    echo "    <th>Annotation Text</th>\n";
    echo "  </tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    $row_count = 0;
    while ($row = mysql_fetch_assoc($result)) {
        // we will only return $max_results results
        if (++$row_count > $max_results) {
            break;
        }
        // link to feature in gbrowse
        $link = "/cgi-bin/gbrowse/$db/?start="
                .($row['start'] - $link_padding)
                .";stop="
                .($row['end'] + $link_padding)
                .';ref='.$row['accession']
                .';h_feat='.$row['name'].'%40yellow';

        if ($db == 'solanaceae') {                
            //do a taxon id lookup
            $taxon_id = (array_key_exists($row['accession'], $taxon_lookup)) ?
                $taxon_lookup[$row['accession']] : 'unknown';

            //do a scientific name lookup
            $scientific_name = (array_key_exists($taxon_id, $taxon_hash)) ?
                $taxon_hash[$taxon_id]['scientific_name'] : 'unknown';        
        }
        
        // feature type description 
        $feat_desc = $feat_types[$db][$row['feat_type']];                
                
        echo "<tr>\n";
        if ($db == 'solanaceae') {
            echo "    <td>$scientific_name</td>\n";
        }
        echo "    <td><a href='$link'>".$row['accession']."</a></td>\n";
//        echo "    <td>".$row['start']."</td>\n";  //add this stuff
//        echo "    <td>".$row['end']."</td>\n";    //back in 
//        echo "    <td>".$feat_desc."</td>\n";     //as a tooltip
        echo "    <td>".$row['name']."</td>\n";
        echo "    <td>".$row['description']."</td>\n";
        echo "</tr>\n";
    }
    echo "</tbody>\n"; 
    if ($row_count > $max_results) {
        echo "<tfoot>\n";
        echo "<p><em>Query returned >$max_results matches, and displayed results have been truncated. Consider modifying your search terms.</em></p>";
        echo "</tfoot>";
    }
    echo "</table>\n";
  
    // output error messages
    function do_error( $error_message = 'An unspecified error occurred.' ) {
        echo "<p>$error_message</p>";
        exit(1);
    }
?>
