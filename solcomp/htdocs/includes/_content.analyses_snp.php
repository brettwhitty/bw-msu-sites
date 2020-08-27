            <h2>Solanaceae Single Nucleotide Polymorphisms (SNPs)</h2>
            <p>
            Using assembled EST sequences from the <a href='http://www.plantgdb.org/prj/ESTCluster/index.php'>PlantGDB PUTs</a> database, we have identified high confidence SNPs within the assemblies.
            <p>Our pipeline takes as input the multiple sequence alignments (MSA) of the members of each assembled PUT. However, our pipeline adds back into the MSAs ESTs that are near-exact substring matches to PUT member ESTs. These sequences have <a href='http://www.plantgdb.org/prj/ESTCluster/PUT_procedure.php#dupes'>previously been excluded</a> from the final assembly in the PlantGDB assembly pipeline.
            <p>The requirement for SNP discovery were:</p>
            <ol>
                <li>high level of sequence coverage of at least four reads per position</li>
                <!--                <li>the availability of quality scores</li> -->
                <li>stringent assembly of sequences</li>
            </ol>
             <p>As false discovery of SNPs can be caused by low quality sequence or the assembly of paralogous
              sequences into a single contig, we have selected SNPs with at least two alternative base reads 
              when compared to consensus<!-- and a quality score of at least 20 and no other SNP within 50
              bases up- or downstream-->.</p>
              <!--
              <p>A total of 125,838 single pass EST sequences for potato (sequenced at
              TIGR) were assembled into 17,498 contigs. In 2,667 contigs, SNPs could be detected
              based on the criteria outlined above. A total of 4,798 SNPs could be detected in these
              contigs.
              -->
            </p>
            <p>Please <a href='projects_solcomp_version.php'>click here</a> for versioning information related to the current data set.
           
        <div class='download_notice'>
        <p><img class='mini_icon' src='/images/folder.png'>Data from our SNP database is also <a href='ftp://ftp.plantbiology.msu.edu/pub/sgr/other/snp/'>available for download from our FTP site</a>.<p>
        </div>

            </p>

            <div id="snp_search_header" class="collapse_box_header">
            <h3>Search for Solanaceae SNPs</h3>
            </div>
            <div id="snp_search_form_div">
            <fieldset>
                    <form id="snp_search_form" action='/cgi-bin/SNP/sol_snps.cgi' method='get' target='_blank'>

                    Enter a valid <strong>PlantGDB PUTs identifier</strong> or <strong>GenBank EST Accession</strong> (eg:
            <a class="snp_link" href='/cgi-bin/SNP/sol_snps.cgi?id=PUT-157a-Solanum_tuberosum-1385' target='_blank'>PUT-157a-Solanum_tuberosum-1385</a>,
            <a class="snp_link" href='/cgi-bin/SNP/sol_snp_report.pl?id=PUT-169a-Nicotiana_tabacum-77195' target='_blank'>PUT-169a-Nicotiana_tabacum-77195</a>,
            <a class="snp_link" href='/cgi-bin/SNP/sol_snps.cgi?id=EB699569' target='_blank'>EB699569</a>) and press 'Search' to retrieve the annotation for this SNP.

                    <br/>

                    <br/>

                    <input id="snp_field" type="text" name="id" size="50">

                    <br/>
                    <br/>

                    <input type="submit" value="Search" id="search_button">
                    &nbsp;&nbsp;
                    <input type="reset" value="Clear">

                    </form>
                </fieldset>
                </div>
                <div id="snp_search_results"></div>
            <script type="text/javascript" src="/js/analyses_potato_snp.js"></script>
