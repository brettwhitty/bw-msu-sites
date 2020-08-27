      <h2>Search the Solanaceae Simple Sequence Repeat (SSR) Database</h2>

        <p>
        This site contains a database with all the solanaceae simple sequence repeats
        (SSRs) of length 10bp or more, with motifs from singlets to hexanucleotide,
        found in the <a href='http://www.plantgdb.org/prj/ESTCluster/index.php'>PlantGDB PUTs</a> sequences. Use the form below to submit queries to the database.  A brief explanation of the query fields:
        </p>

        <ul>
        <li>Motif: selects SSRs made of a particular motif.
        <li>Min Length: selects SSRs that are at least this long.
        <li>Max Length: selects SSRs that are at most this long.
        <li>Annotation: the identified SSR-containing EST sequences were searched against the UniProt UniRef100 sequence database and the annotation of the top hit (E-value cutoff &lt;=1e-5), if any, was transitively applied as the annotation of the SSR sequence. eg: kinase, etc.
        <li>PUT ID or GB accession #: enter a PUT identifier or a Genbank number to see if it contains a putative SSR sequence in the Solanaceae SSR database.
        </ul>

        <div class='download_notice'>
        <p><img class='mini_icon' src='/images/folder.png'>Data from our SSR database is also <a href='ftp://ftp.plantbiology.msu.edu/pub/sgr/other/ssr/'>available for download from our FTP site</a>.<p>
        </div>
        
        <div id="ssr_search_header1" class="collapse_box_header">
        <h3>
        Search By SSR Motif, Species, Minimal Length and Maximal Length
        </h3>
        </div>
        <div id="ssr_search_form1_div">

          <fieldset>
        <form id="ssr_search_form1" action='/cgi-bin/SSR/ssr_db_query.cgi' enctype='multipart/form-data' method='get' target='_blank'>

            Select a SSR Motif
                    &nbsp;&nbsp;
            <select name='motif'>
            <option value=''>All</option>
            <option value='1'>mononucleotide</option>
            <option value='2'>dinucleotide</option>
            <option value='3'>trinucleotide</option>
            <option value='4'>tetranucleotide</option>
            <option value='5'>pentanucleotide</option>
            <option value='6'>hexanucleotide</option>
            </select>
            

                    <br/>
                    <br/>

            Select a species
                    &nbsp;&nbsp;
            <select name='taxon'>
            <?php 
                require_once('php-lib/TaxonList.php');
                $t = new TaxonList(1);
                $species = $t->get_array();
                foreach ($species as $s) {
                    echo "<option value='".$s['taxon_id']."'>".$s['scientific_name']."</option>\n";
                }
            ?>
            </select>

                    <br/>
                    <br/>

            Select an assembly type
                    &nbsp;&nbsp;
            <select name='asm_so_type'>
            <option value=''>All</option>
            <option value='sequence_assembly'>Transcript Assemblies (PUTs)</option>
            <option value='contig'>BACs</option>
            </select>

                    <br/>
                    <br/>
            
            And enter a Min Length
                    &nbsp;&nbsp;
            <input type='input' size='3' name='min_length' value='10'>

                    &nbsp;&nbsp;
                    and Max Length
                    &nbsp;&nbsp;
            <input type='input' size='3' name='max_length' value='300'>

                    <br/>
                    <br/>

            <input type='submit' value='Search'>
                    &nbsp;&nbsp;
            <input type='reset'  value='Clear'>

        </form>
            </fieldset>
        </div>
        <div id="ssr_search_header2" class="collapse_box_header">
        <h3>
        Search by Annotation
        </h3>
        </div>

        <div id="ssr_search_form2_div">
          <fieldset>
        <form id="ssr_search_form2" action='/cgi-bin/SSR/ssr_db_query.cgi' enctype='multipart/form-data' method='get' target='_blank'>
            
        
            Enter putative annotation &nbsp;&nbsp;
            <input id="search_field2" type='input' size='20' name='annot'>

                     (eg: <a href="#" class="demo_link2">kinase</a>)<br/>
                    <br/>

                    Select a species &nbsp;&nbsp;
            <select name='taxon'>
            <?php 
                require_once('php-lib/TaxonList.php');
                $t = new TaxonList(1);
                $species = $t->get_array();
                foreach ($species as $s) {
                    // make potato the default for this
                    if ($s['taxon_id'] == '4113') {
                        echo "<option selected value='".$s['taxon_id']."'>".$s['scientific_name']."</option>\n";
                    } else {
                        echo "<option value='".$s['taxon_id']."'>".$s['scientific_name']."</option>\n";
                    } 
                }
            ?>
            </select>

                    <br/>
                    <br/>

            <input type='submit' value='Search' id="search_button2">
                    &nbsp;&nbsp;
            <input type='reset' value='Clear'>

        </form>
            </fieldset>

        </div>
        <div id="ssr_search_header3" class="collapse_box_header">
        <h3>
        Search by PUT ID or Genbank Accession
        </h3>
        </div>
        <div id="ssr_search_form3_div">
          <fieldset>
        <form id="ssr_search_form3" action='/cgi-bin/SSR/ssr_db_query.cgi' enctype='multipart/form-data' method='get' target='_blank'>

            Enter PUT ID or GenBank BAC or EST accession number (eg: <a href="#" class="demo_link3">PUT-157a-Solanum_tuberosum-1680</a>, <a href="#" class="demo_link3">AX076880</a>, <a href="#" class="demo_link3">BP131549</a>)<br/>
            
                    <br/>
            <input id="search_field3" type='input' size='50' name='id'>
                    <br/>
                    <br/>
            <input type='submit' value='Search' id="search_button3">
                    &nbsp;&nbsp;
            <input type='reset' value='Clear'>

        </form>
            </fieldset>
        </div>
        <div id="ssr_search_results">
        </div>
        <script type="text/javascript" src="/js/analyses_ssr_query.js"></script>
