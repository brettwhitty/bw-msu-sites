    <h2>Solanaceae Genomics Resource FTP Site</h2>
    <p>The project FTP site is publicly accessible via anonymous login at:</p>
    <h3>
    <a href='ftp://ftp.plantbiology.msu.edu/pub/sgr/'>ftp://ftp.plantbiology.msu.edu/pub/sgr/</a>
    </h3>
    <h2>FTP Site Map</h2>

    <?php
     
    $dirs = array(
        'potato/bacs'
            =>  'Potato BAC sequences',
        'potato/bac_ends'
            =>  'Potato BAC end sequences',
        'potato/annotation'
            =>  'Potato gene models predicted on BACs using the MAKER pipeline',
        'potato/puts'
            =>  'Potato PUT sequences (from <a href="http://plantgdb.org">http://plantgdb.org</a>)',
        'tobacco/bacs'
            =>  'Tobacco BAC sequences',
        'tobacco/bac_ends'
            =>  'Tobacco BAC end sequences',
        'tobacco/annotation'
            =>  'Tobacco gene models predicted on BACs and TGI assemblies using the MAKER pipeline',
        'tobacco/puts'
            =>  'Tobacco PUT sequences (from <a href="http://plantgdb.org">http://plantgdb.org</a>)',
        'tomato/bacs'
            =>  'Tomato BAC sequences',
        'tomato/bac_ends'
            =>  'Tomato BAC end sequences',
        'tomato/annotation'
            =>  'Tomato gene models predicted on BACs using the MAKER pipeline',
        'tomato/puts'
            =>  'Tomato PUT sequences (from <a href="http://plantgdb.org">http://plantgdb.org</a>)',
        'other/all_sol_bacs'
            =>  'Solanaceae BAC sequences',
        'other/all_sol_bac_ends'
            =>  'Solanaceae BAC end sequences',
        'other/all_sol_models'
            =>  'Gene models annotated on the Sol BACs using MAKER',
        'other/all_sol_puts'
        =>  'Solanaceae PUT sequences (from <a href="http://plantgdb.org">http://plantgdb.org</a>)',
        'other/snp'
            =>  'SNP analysis data',
        'other/ssr'
            =>  'SSR analysis data',
        'other/lineage_specific_puts'
            =>  'Lineage-specific PUTs data',
        'other/repeats'
        =>  'Plant Repeats Databases Solanaceae repeat libraries (from <a href="http://plantrepeats.plantbiology.msu.edu">http://plantrepeats.plantbiology.msu.edu</a>)',
        'other/ortholog_paralog/bbh/ortholog'
            =>  'Best BLAST hit putative ortholog data',
        'other/ortholog_paralog/bbh/paralog'
            =>  'Best BLAST hit putative paralog data',
        'other/comparative_mapping'
            =>  'Comparative mapping to model genomes'
        );
        foreach (array_keys($dirs) as $dir) {
            echo "<h3>".$dirs[$dir]."</h3>\n";
            echo "<p><img class='icon' src='images/folder.png'><a href='ftp://ftp.plantbiology.msu.edu/pub/sgr/".$dir."'>ftp.plantbiology.msu.edu/pub/sgr/".$dir."</a></p>";
            
        }
    ?>
