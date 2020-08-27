<?php 
  $info_rows = '';
  $seq_rows = '';
  
  $table_file = '_data/sol_table.txt';
  
  $fh = fopen($table_file, 'r');
  
  while ($line = fgets($fh)) {
    $line = rtrim($line);
    $cols = explode("\t", $line);
    
    //info table
    
    $info_rows .= "<tr>";
    //scientific name
    $info_rows .= '<td class="centered"><a href="'.$cols[1].'"><i>'.$cols[0].'</i></a></td>';
    //common name
    $info_rows .= '<td class="centered">'.$cols[2].'</td>';
    //genome projects
    if ($cols[3] == '--') {
            $info_rows .= '<td class="centered">'.$cols[3].'</td>';
    } else {
        $info_rows .= '<td class="centered"><a href="'.$cols[4].'">'.$cols[3].'</a></td>';
    }
    //pubmed
    $info_rows .= '<td class="centered"><a href="'.$cols[6].'">'.$cols[5].'</a></td>';
    $info_rows .= "</tr>\n";
    
    //sequence table
    
    $seq_rows .= "<tr>";
    //scientific name
    $seq_rows .= '<td class="centered"><i>'.$cols[0].'</i></td>';
    //Total Entries
    $seq_rows .= '<td class="centered">'.$cols[7].'<br />('.$cols[8].')</td>';
    //dbEST
    $seq_rows .= '<td class="centered"><a href="'.$cols[10].'">'.$cols[9].'</a><br />('.$cols[11].')</td>';
    //dbGSS
    $seq_rows .= '<td class="centered"><a href="'.$cols[13].'">'.$cols[12].'</a><br />('.$cols[14].')</td>';
    //dbPLN
    $seq_rows .= '<td class="centered"><a href="'.$cols[16].'">'.$cols[15].'</a><br />('.$cols[17].')</td>';
    //dbHTG
    $seq_rows .= '<td class="centered"><a href="'.$cols[19].'">'.$cols[18].'</a><br />('.$cols[20].')</td>';
    $seq_rows .= "</tr>\n";
    
  } 
  fclose($fh);
  
?>
  <h2>Solanaceae Genome Facts</h2>
      <h3>Solanaceae Information</h3>
    
    <table id='sol_facts'>
        <thead>
            <tr align="CENTER" valign="TOP">
                <th>Scientific Name</th> 
                <th>Common Name</th>
                <th>Genome Projects</th> 
                <th>PubMed Records</th>
           </tr>
        </thead>
        <tbody>
    <?php echo $info_rows; ?>
        </tbody>
    </table>
    
    <script type="text/javascript">
    <!--
    window.addEvent('domready', function() {
        new SortingTable('sol_facts', {zebra: true});
    });
    //--!>
    </script>

<h3>Solanaceae Nucleotide Sequences in GenBank<SUP>a</SUP></h3>

<table id="sol_sequences">
    <thead>
        <tr align="CENTER" valign="TOP">
            <th>Scientific Name</th>
            <th>Total Entries<SUP>a</SUP>/<br/>(Kb)</th>
            <th>dbEST/<br/>(Kb)</th>
            <th>dbGSS/<br/>(Kb)</th>
            <th>dbPLN/<br/>(Kb)</th>
            <th>dbHTG/<br/>(Kb)</th>
        </tr>
    </thead>
    <tbody>
    <?php echo $seq_rows; ?>
    </tbody>
</table>
    
    <script type="text/javascript">
    <!--
    window.addEvent('domready', function() {
        new SortingTable('sol_sequences', {zebra: true});
    });
    //--!>
    </script>

  <p><SUP>a</SUP>The Total Entries column is the sum of the entries from the dbEST, dbGSS, dbPLN, and dbHTG  columns.</p>

  <p>Data updated on <?php echo date("F d Y H:i:s.", filemtime($table_file)); ?></p>
