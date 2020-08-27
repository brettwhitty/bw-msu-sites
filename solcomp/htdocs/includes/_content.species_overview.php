<?php
      require_once('php-lib/TaxonList.php');
      $taxonList = new TaxonList(0);
      $taxon_hash = $taxonList->get_hash();
  
      // read taxon id from path_info
      require_once('pathinfo.inc.php');
      $src = path_info_to_src();
      $taxon_id = basename($src);
 
      // set the scientific_name
      $scientific_name = $taxon_hash[$taxon_id]['scientific_name'];

      // set the scientific_name
      $common_name = ($taxon_hash[$taxon_id]['common_name'] == '') ? 'N/A' : $taxon_hash[$taxon_id]['common_name'];
      
      // image URL
      $image_url = "/images/overview_$taxon_id.png";
      if (! file_exists($_SERVER['DOCUMENT_ROOT']."/".$image_url)) {
          $image_url = "/images/overview_null.png";
      }
  ?>

  <?php
  //will take a description string and add in the specified link
  function link_description($desc = '', $link = '') {
    if (! isset($desc) || $desc == '') {
        return 'N/A';
    } 
    if (! isset($link) || $link == '') {
        return $desc;
    }
    
    if (preg_match("/\[\[/", $desc)) {
        if (preg_match("/\]\]/", $desc)) {
            $desc = preg_replace("/\[\[/", "<a href='$link'>", $desc);
            $desc = preg_replace("/\]\]/", "</a>", $desc);
            return $desc;
        } else {
            return "<a href='$link'target='_blank'>$desc</a>";
        }
    } else {
        return "<a href='$link' target='_blank'>$desc</a>";
    }
  }
  
  function kb_to_mb($size_string) {
    if (preg_match("/^([\d\.]+)kb/i", $size_string, $m)) {
        $bps = $m[1] / 1000;
        $bps = number_format($bps, 2);
        if (intval($bps) < 1) {
            return $size_string;
        } else {
            return $bps."Mb";
        }
    } else {
        return $size_string;
    }
  }
  
  function ta_db_link($db_string = 'PlantGDB PUTs') {
    if (preg_match("/plantgdb/i", $db_string)) {
        return "http://www.plantgdb.org/prj/ESTCluster/index.php";
    } else if (preg_match("/TIGR Plant TAs/i", $db_string)) {
        return "http://plantta.tigr.org/";
    } else if (preg_match("/NCBI UniGene/i", $db_string)) {
        return "http://www.ncbi.nlm.nih.gov/sites/entrez?db=unigene";
    } else {
        return '';
    }
  }
  
  ?>

<div style='float:right; padding-left:15px; padding-right: 15px;'>
<img src='<?php echo $image_url; ?>' />
</div>

    
  <h1><em><?php echo $scientific_name; ?></em> Overview Page</h1>
  

  <?php 
  
  $info_rows = '';
  $seq_rows = '';
  
  $table_file = '_data/sol_table.txt';
  
  $fh = fopen($table_file, 'r');
  
  while ($line = fgets($fh)) {
    $line = rtrim($line);
    $cols = explode("\t", $line);
    
    preg_match("/\=(\d+)/", $cols[1], $m);
    
    if ($m[1] == $taxon_id) {
        
        $genome_project_name = ($cols[3] == '--') ? 'N/A' : $cols[3];
        $genome_project_link = ($cols[4] == '--') ? '' : $cols[4];
 //       $common_name = ($cols[2] == '--') ? 'N/A' : $cols[2];
        
        //genomic records
        $gb_total_records = $cols[12] + $cols[18];
        $gb_total_length = (floatval($cols[14]) + floatval($cols[20]))."kb";
        
        //est records
        $dbest_records = $cols[9];
        $dbest_length = $cols[11];
        
        //pubmed
        $pubmed_count = $cols[5];
        $pubmed_link = $cols[6];
    
        break;
    }
  } 
  fclose($fh);
  
  ?>
  <h2>Common Name</h2>
  <p><?php 
        if ($common_name == 'N/A') {
            echo $common_name;
        } else {
            echo "<strong>$common_name</strong>";
        }
     ?></p>
  
  <h2>Genome Data</h2>
  <dt>Genome Sequencing Project:</dt>
  <dd><?php echo link_description($genome_project_name, $genome_project_link); ?></dd>

<?php /*  <p>Description of available data</p> */ ?>
  <dt>Total GenBank Genome Sequence Records:</dt>
  <dd>
      <?php 
                if (intval($gb_total_records) == 0) { 
                    echo "N/A"; 
                } else {
                    echo "<strong>".number_format($gb_total_records)." (".kb_to_mb($gb_total_length).")</strong>"; 
                }
       ?>
  </dd>
    
    <dt>Download Genomic Sequence:</dt>

<?php
    /* for checking FTP site */
    $seq_types = array(
        'BACs'          =>  'bacs',
        'BAC Ends'      =>  'bac_ends',
        'Cosmid Ends'   =>  'cosmid_ends',
        'Fosmid Ends'   =>  'fosmid_ends'
    );
    /* FTP base URL */
    $ftp_base = 'ftp://ftp.plantbiology.msu.edu/pub/sgr/.by_taxon_id';

    $genomic_seq_count = 0;
    foreach (array_keys($seq_types) as $type) {
        $type_dir = $seq_types[$type];
        $ftp_path = $ftp_base.'/'.$taxon_id.'/'.$type_dir;
        if (file_exists($ftp_path)) {
            echo "  <dd><img class='icon' src='/images/folder.png'><a href='$ftp_path/'>$type</a></dd>\n";
            $genomic_seq_count++;
        }
    }
    if ($genomic_seq_count == 0) {
        echo "  <dd>N/A</dd>\n";
    }
?>
    
<?php /*
  <p>Size in Mb:</p>
  <p>Links to projects</p>
  <p>Download data</p>
  */ ?>
    
  <h2>Transcript Data</h2>
  <dt>dbEST Records:</dt>
  <dd>
    <?php
                if (intval($dbest_records) == 0) { 
                    echo "N/A"; 
                } else {
                    echo "<strong>".number_format($dbest_records)." (".kb_to_mb($dbest_length).")</strong>"; 
                }
    
    ?>
  </dd>
  <h3>Transcript Assemblies</h3>

  <?php 
      $table_header = "
  <table id='transcript_assemblies' class='table_medium centered'>
  <thead>
  <tr>
    <th>Database</th><th>Current Version</th><th>Build Date</th><th title='Total count of ESTs, cDNA and mRNA sequences input to assembly pipeline'>Seqs Assembled</th>
    <th title='Total number of contigs and singletons in assembly results set'>Total Assemblies</th>
    <th>Fasta</th>
  </tr>
  </thead>
  <tbody>";
    
  $est_table_file = '_data/transcript_source_table.txt';
  
  $fh = fopen($est_table_file, 'r');
  
  $counter = 0;
  $table_body = '';
  while ($line = fgets($fh)) {
    $line = rtrim($line);
    $cols = explode("\t", $line);
    
    if ($cols[0] == $taxon_id) {
        $counter++;
        array_shift($cols); //discard taxon_id
        $table_body .= "<tr>";
        for ($i = 0; $i < sizeof($cols); $i++) {
            if ($i == 0) {
                $table_body .= "<td>".link_description($cols[$i],ta_db_link($cols[$i]))."</td>";
            } else if ($i == 5) {
                $table_body .= "<td>".link_description('Download', $cols[$i])."</td>";            
            } else { 
                $table_body .= "<td>$cols[$i]</td>";
            }
        }
        $table_body .= "</tr>\n";
    }
  }
  
  fclose($fh);
  
  $table_footer = "  </tbody>\n</table>\n";
  if ($counter > 0) {
    echo $table_header.$table_body.$table_footer;
  } else {
    echo "N/A";
  }
  
  ?>
  
    <script type='text/javascript'>
    <!--
        window.addEvent('domready', function() {
            new SortingTable('transcript_assemblies', {zebra: true});
        });
    //--!>
    </script>
  
<?php
/*
  <p>Download data</p>
 */
 ?>

<p>Genomic data was retrieved from NCBI on <?php echo date ("F d Y", filemtime($table_file)); ?>,
 transcript assemblies data current as of <?php echo date ("F d Y", filemtime($est_table_file)); ?>.</p>

  <h2>Expression Data</h2>
  <dt>NCBI GEO:</dt>
  <?php 
 
   $table_file = '_data/sol_ncbi_geo.txt';
  
   $fh = fopen($table_file, 'r');
  
  $count = 0; 
  while ($line = fgets($fh)) {
    $line = rtrim($line);
    $cols = explode("\t", $line);
    
    if ($cols[0] == $taxon_id) {
        if ($cols[1] != '--') {
            echo "  <dd><a href='$cols[2]'>$cols[1] Profiles</a></dd>\n";
            $count++;
        }
        if ($cols[3] != '--') {
            echo "  <dd><a href='$cols[4]'>$cols[3] Datasets</a></dd>\n";
            $count++;
        }
    }
  }
  fclose($fh);
  if ($count == 0) {
    echo "  <dd>N/A</dd>\n";
  }
  ?>  

  
  <h2>Papers</h2>
  <dt>PubMed Records:</dt>
  <dd><?php
      if ($pubmed_count > 0) { 
        echo link_description("$pubmed_count records", $pubmed_link); 
      } else {
        echo 'N/A';
      }
    ?></dd>

  
  <?php
      /*
    $pubmed_links = array();  
    $pubmed_table_file = '_data/sol_pub_med_links.txt';
  
    $fh = fopen($pubmed_table_file, 'r');
  
    while ($line = fgets($fh)) {
        $line = rtrim($line);
        $cols = explode("\t", $line);
    
        $pubmed_links = $cols;
        break;
    }
    fclose($fh);
    */
  ?>

  <p>See all <i><?php echo $scientific_name; ?></i> papers within the last

  <?php 
      $today      = date("Y\/m\/d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
      $last_week  = date("Y\/m\/d", mktime(0, 0, 0, date("m"), date("d") - 7, date("Y")));
      $last_month = date("Y\/m\/d", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
      $last_year  = date("Y\/m\/d", mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1));

      $q_week = 'http://www.ncbi.nlm.nih.gov/sites/entrez?cmd=Search&db=Pubmed&term='
                .$scientific_name.'[TIAB] AND '.$last_week.'[PDAT]:'.$today.'[PDAT]';
      $q_month = 'http://www.ncbi.nlm.nih.gov/sites/entrez?cmd=Search&db=Pubmed&term='
                .$scientific_name.'[TIAB] AND '.$last_month.'[PDAT]:'.$today.'[PDAT]';
      $q_year = 'http://www.ncbi.nlm.nih.gov/sites/entrez?cmd=Search&db=Pubmed&term='
                .$scientific_name.'[TIAB] AND '.$last_year.'[PDAT]:'.$today.'[PDAT]';
  ?>
  <a href='<?php echo $q_week; ?>' target='_blank'>Week</a>,
  <a href='<?php echo $q_month; ?>' target='_blank'>Month</a>, or
  <a href='<?php echo $q_year; ?>' target='_blank'>Year</a>
  </p>

  <h2>Analyses/Tools</h2>
  <ul>
  <?php
  
  $list =
    array(
    '<li><a href="/cgi-bin/gbrowse/solanaceae/?name='.$taxon_id.'">Solanaceae comparative genome browser</a></li>',
    '<li><a href="/analyses/sol_mapping">Comparative mapping</a></li>',
    '<li><a href="/analyses/lineage_specific">Lineage-specific transcripts</a></li>',
    '<li><a href="/analyses/ortholog_paralog">Ortholog/paralog predictions</a></li>',
    '<li><a href="/analyses/sol_repeat">Solanaceae repeats database</a></li>',
    '<li><a href="/analyses/snp">SNPs</a></li>',
    '<li><a href="/analyses/markers">Genetic Markers</a></li>',
    '<li><a href="/analyses/ssr">SSRs</a></li>',
    '<li><a href="/analyses/qtl_papers">QTL Papers</a></li>',
    '<li><a href="/tools/blast">BLAST</a></li>'
    );
    
  /*    
        Analysis flags:      
  
        1111111111
        Genome browser
         Comparative mapping
          Lineage-specific transcripts
           Ortholog/Paralog
            Sol repeats DB
             SNPs
              Genetic Markers
               SSRs
                QTL Papers
                 BLAST
         
  */
   
  $opts = array(
                4072    =>  '1111111111', //Capsicum annuum
                4073    =>  '1000100101', //Capsicum frutescens
                4081    =>  '1111111111', //Solanum lycopersicum
                4084    =>  '1000100101', //Solanum pimpinellifolium
                4096    =>  '1111110101', //Nicotiana sylvestris
                4097    =>  '1111110101', //Nicotiana tabacum
                4098    =>  '1000100101', //Nicotiana tomentosiformis
                4100    =>  '1111110101', //Nicotiana benthamiana
                4102    =>  '1111110101', //Petunia x hybrida
                4108    =>  '1111110111', //Solanum chacoense
                4111    =>  '1000100101', //Solanum melongena
                4113    =>  '1111111111', //Solanum tuberosum
                28526   =>  '1111110111', //Solanum pennellii
                33113   =>  '1000100101', //Atropa belladonna
                50514   =>  '1000100101', //Solanum demissum
                62890   =>  '1111110111', //Solanum habrochaites
                73101   =>  '1000100101', //Solanum sp. VFNT
                142759  =>  '1000100101', //Solanum cheesmaniae
                147425  =>  '1000100101', //Solanum bulbocastanum
                164110  =>  '1111110101', //Nicotiana langsdorffii x Nicotiana sanderae
                172790  =>  '0000000000', //Solanum phureja
                212142  =>  '1000100101', //Petunia integrifolia subsp. inflata
               );
  
  
    $list_flags = str_split($opts[$taxon_id]);
        
    for ($i = 0; $i < sizeof($list_flags); $i++) {
        if ($list_flags[$i] == 1) {
            echo $list[$i];
        }
    }
  
  ?>
  </ul>

<?php
 /*
  <h2>Search</h2>
  */
 ?>

  <h2>Links</h2>
  <?php 
 
   $table_file = '_data/sol_external_links.txt';
  
  $fh = fopen($table_file, 'r');
  
  echo "<ul>";
  $counter = 0;
  while ($line = fgets($fh)) {
    $line = rtrim($line);
    $cols = explode("\t", $line);
    
    if ($cols[0] == $taxon_id) {
        echo "<li>".link_description($cols[1], $cols[2])."</li>\n"; 
        $counter++;
    }
  }
  if ($counter == 0) {
    echo "<li>N/A</li>\n";
  }
  echo "</ul>";
  fclose($fh);
  ?>  
