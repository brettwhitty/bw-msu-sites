  <h2>Solanaceae Lineage Specific Transcript Assemblies</h2>
  <p>PlantGDB-assembled Unique Transcript (PUT) assembly sets for 11 Solanaceae species were retrieved from the <a href='http://www.plantgdb.org/prj/ESTCluster/'>PlantGDB PUT</a> database.<br />(For build date / PUT version information <a href='projects_solcomp_version.php'>click here</a>.)
<p>The Solanaceae PUTs were then TBLASTX searched against:
        <p>
                    <ul>
                <li><a href='http://www.arabidopsis.org/'><i>Arabidopsis thaliana</i> genome assemblies (TAIR8 release)</a></li>
                <li><a href='http://www.genoscope.cns.fr/spip/Vitis-vinifera-e.html'><i>Vitis vinifera</i> genome assemblies (Genoscope v1 release)</a></li>
                <li><a href='http://genome.jgi-psf.org/Poptr1_1/Poptr1_1.home.html'><i>Populus trichocarpa</i> genome assemblies (JGI v1.1 release)</a></li>

                <li>All non-Solanaceae PUTs from the <a href='http://www.plantgdb.org/prj/ESTCluster/'>PlantGDB PUTs</a> database</li>
                    </ul>
        </p>
        <p>And BLASTX searched against:
        <p>
        <ul>
        <li>All non-Solanaceae sequences from the <a href='http://www.ebi.ac.uk/uniref/'>UniProt UniRef100 Database</a>
        </li>
        </ul>
        </p>

        <p>The PUTs with any significant match (with an E-value cutoff of &lt;=1e<sup>-5</sup>) were removed and the remaining putative Solanaceae-specific transcript assemblies are as listed below.</p>
        <p><a href='http://estscan.sourceforge.net/'>ESTScan 2.1 </a> was run on all putative lineage-specific PUTs to provide polypeptide sequence (for PUTs where translation was possible), and both the untranslated (DNA) and translated (Protein) putative lineage-specific PUT sets are available below.</p>

        
       
        <table class='table_large'>

            <tr align='center'>
                <th>
                    Species
                </th>
                <th>
                    # PUTs
                </th>
                <th>
                    # Translated
                </th>
                <th>
                    Download Accession List 
                </th>
                <th>
                    Download FASTA
                </th>
            </tr>
        <?php 

            $ls_table = file("webserver_tmp/_lineage_specific.counts.txt");

            foreach($ls_table as $line) {
                if (preg_match("/^\#/", $line)) {
                    continue;
                }

                $line = rtrim($line);
                $cols = explode("\t", $line);

                $species = preg_replace("/ /", "_", $cols[0]);
                
                echo "<tr>";
                if ($cols[0] != 'Total') {
                    echo "<td><i>$cols[0]</i></td>";
                } else {
                    $species = 'all';
                    echo "<td>$cols[0]</td>";
                }
                echo "<td class='centered'>$cols[1]</td>";
                echo "<td class='centered'>$cols[2]</td>";
                echo "<td class='centered'><a href='ftp://ftp.plantbiology.msu.edu/pub/sgr/other/lineage_specific_puts/$species.lineage_specific.list'>DNA</a> / <a href='ftp://ftp.plantbiology.msu.edu/pub/sgr//other/lineage_specific_puts/$species.lineage_specific.estscan.list'>Protein</a></td>";
                echo "<td class='centered'><a href='ftp://ftp.plantbiology.msu.edu/pub/sgr/other/lineage_specific_puts/$species.lineage_specific.fsa.bz2'>DNA</a> / <a href='ftp://ftp.plantbiology.msu.edu/pub/sgr/other/lineage_specific_puts/$species.lineage_specific.estscan.fsa.bz2'>Protein</a></td>";
                echo "</tr>";
            }

        ?>
        </table>

        <div class='download_notice'>
        <p><img class='mini_icon' src='/images/folder.png'>Data from our lineage specific transcript assembly databases is <a href='ftp://ftp.plantbiology.msu.edu/pub/sgr/other/lineage_specific_puts/'>available for download from our FTP site</a>.</p>
        </div>
