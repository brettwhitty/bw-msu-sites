            <div id="news_box">
                <h3 class="news_box_h"><a href="home_news.php">SGR News</a></h3>
                <dt><a href="home_news.php#news_060509">June 5, 2009</a></dt>
                <dd>Site resources have been updated, including more annotation in the model genome browsers, annotation-based searching, EST assembly-centric overview page for analysis results, Gbrowse update to 1.69. <a href="home_news.php#news_060509">[more]</a></dd> 
                <dt><a href="home_news.php#news_020309">February 3, 2009</a></dt>
                <dd>Release 3 of the Solanaceae Comparative Genomics project resources. Updated annotation available for 1,810 BACs; annotated set of 29,234 transcript/protein sequences now available for BLASTing, viewing or download. Tobacco Genome Initiative data now available for BLASTing, annotated TGI BAC assemblies annotated and available for BLAST, download. Solanaceae vs. Arabidopsis comparative browser updated. <a href="home_news.php#news_020309">[more]</a></dd>
                <dt><a href="home_news.php#news_010109">January 9, 2009</a></dt>
                <dd>278 new BACs annotated, available in GBrowse. More SNP predictions! Annotation keyword searching now available for SSRs. Solanaceae lineage-specific genes predicted using PUTs. FTP site updated. <a href="home_news.php#news_010109">[more]</a></dd>
                <dt><a href="home_news.php#news_100808">October 8, 2008</a></dt>
                <dd>Release 2 of the Solanaceae Genomics Resource site. See News page for details on updates to tools and datasets.</dd>
                <dt><a href="home_news.php#news_062608">June 26, 2008</a></dt>
                <dd>Launch of the new Solanaceae Genomics Resource web site.</dd>
                <dt><a href="home_news.php#news_010108">January 1, 2008</a></dt>
                <dd>The Solanaceae Genomics Resource project moves to Michigan State University.</dd>
                <dt><a href="home_news.php#news_100107">October 1, 2007</a></dt>
                <dd>Generation of Potato Genome Sequence and Annotation Resources project moves to Michigan State University.</dd>
            </div>
      <?php
            if (isset($_GET['redirect'])) {
                echo "
                <div class='notice_box nb_purple'>
                <h2>You have been redirected from the TIGR site</h2>
                <p>The new URL for the project is:</p>
                <h2><a href='http://solanaceae.plantbiology.msu.edu'>http://solanaceae.plantbiology.msu.edu</a></h2>
                <h2><em>Please update your bookmarks</em></h2>
                </div>";
            }
       ?>
            <p>The Solanaceae Genomics Resource at MSU is a portal to several projects in the 
            <a href="http://buell-lab.plantbiology.msu.edu">Buell Lab</a> on the genomics of
            the Solanaceae.</p>
            
            <p>Current funded projects within our Solanaceae Genomics Resource include the
            NSF-funded <a href="projects_potato_chr6.php">Potato Genome Sequence and
            Annotation Resource</a> and the USDA funded project on 
            <a href="/projects/solcomp">Comparative Genomics Resources for
            the Solanaceae</a>.<p>

            <!-- spuds unearthed announcement -->
            <div id='spuds_unearthed' class='home_project_div_left' style='float: left; border-width: 2px; border-color: #333; background-color: #FFFFFF;'>
                <img style='float: left; padding-right: 10px;' src='images/spuds_native_growers.jpg' />
                <p style='font-size: 1em; padding-top: 10px;'>
                    <h1><a href='http://www.usbg.gov/education/events/Spuds-Unearthed.cfm'>Spuds Unearthed!</a></h1>
                    An exhibit ("<em>Spuds Unearthed!</em>") on potato and its importance in agriculture is <strong>on-going</strong> at the <a href='http://www.usbg.gov/education/events/Spuds-Unearthed.cfm'>United States Botanic Garden</a> <strong>through October 11, 2010</strong>. The <strong>Potato Genome Sequencing Project</strong> is part of the exhibit.</p>
            </div>
            <!-- end announcment -->

            <div class="home_project_div_left">
                <h2><a href="projects_potato_chr6.php">Generation of Potato Genome Sequence
                 and Annotation Resources</a></h2>
                
                <img id="mmm_potatoes" src="images/usda_mmm_potatoes.gif" alt="Potatoes" width="199" height="300" /> 
                
                <p>The potato (<em>Solanum tuberosum</em> L.) is the fourth most important
                crop in the world, behind wheat, rice, and maize. In 2004, worldwide
                production of potatoes exceeded 327 million metric tons. The potato produces
                more food
                energy and food value per unit of land area than any other crop. Compared
                to grain crops, the potato is a superior source of nutrition. However, among
                the major crop plants, the potato is arguably the most intensively managed.
                In addition, tuber quality requirements are complex and must be maintained 
                during harvest and storage.</p>


                <p>To improve our understanding of potato, we are participating in the
                <a href='http://potatogenome.net'>International Potato Genome Sequencing
                Consortium</a> (PGSC). The PGSC is engaged in sequencing two potato species:
                the heterozygous diploid heterozygous <em>S. tuberosum</em> cultivar, 
                RH89-039-16 (RH), and the doubled monoploid <em>S. phureja</em> clone DM1-3
                516R44 (DM). To date, we have contributed to the generation of significant 
                RH genome sequence through 1) end sequencing of the RHPOTKEY library and 2) 
                in sequencing of RH BACs, primarily from chromosome 6. With respect to the
                DM genome, we have generated end sequence from fosmid clones and BAC clones.
                Our DM BAC and fosmid end sequences were combined with whole genome sequences
                from DM generated by other PGSC members via 454 pyrosequencing and Illumina
                sequencing-by-synthesis to generate a high quality draft genome sequence for
                potato. The current potato genome assembly represents 720 Mb and was to the
                public in September 2009 through 
                <a href='http:/potatogenome.net'>potatogenome.net</a>. To aid in the
                annotation of the potato genome, we also initiated a comprehensive whole
                transcriptome sequencing project for the DM clone.</p>

                <p> Participants: </p>
                <ul>
                    <li>Principal Investigator (PI):
                    <a href='http://buell-lab.plantbiology.msu.edu'>C. Robin Buell</a>, 
                    Michigan State University</li>
                    <li>Co-Principal Investigator (coPI): Chris Town, J. Craig Venter
                    Institute</li>
                    <li>Collaborator:
                    <a href='http://www.hort.wisc.edu/jjiang/'>Jiming Jiang</a>, University
                    of Wisconsin-Madison</li>
                    <li>Collaborator: <a href='http://www.usbg.gov/'>Christine Flanagan</a>,
                    U. S. Botanic Garden</li>
                </ul>
                
                <p>This project was initiated at TIGR on October 1, 2006, and as of October 1,
                2007 moved to Michigan State University. Data generated by the project is
                posted on this website as it becomes available.</p>
                
                <p>This material is based upon work supported by the National Science 
                Foundation under Grant No. DBI-0604907 and DBI-0834044. Any opinions, findings
                and conclusions or recomendations expressed in this material are those of the
                author(s) and do not necessarily reflect the views of the National Science
                Foundation (NSF).</p>
            </div>

            <div class="home_project_div_right compsol">
                <h2><a href="/projects/solcomp">Comparative Genomics Resources for the Solanaceae</a></h2>
                <img src="images/potato.png" width="175" height="140" style="float: left; padding-right: 5px;" />
                <p>The Solanaceae Comparative Genomics Resource, funded by USDA-CSREES, will
                provide a robust, rich, and integrated resource allowing broad and deep
                data-mining of Solanaceae sequences. The resource will allow the community
                access to the results of added-value comparative and de novo analyses on the
                partial genomic sequences provided by the Tomato, Potato and Tobacco genome
                sequencing efforts and Solanaceae transcript assemblies, and will link
                Solanaceae sequences to the functional genomics resources of other related
                model dicot species.</p>

                <img src="images/tomato.png" style="float: right; padding-left: 0px;" />
    
                <p><em>A new version of the project's  <a href="/cgi-bin/gbrowse/solanaceae/">Solanaceae comparative genome browser</a> is now online.</em></p>
                <p>Read the <a href="/projects/solcomp">project overview</a> to learn more about the project's resources and objectives.</p>
                <p>This project is supported by the National Research Initiative (NRI) Plant Genome Program of the USDA Cooperative State Research, Education and Extension Service (CSREES) grant to C. Robin Buell (2008-35300-18671).</p>
                <img src="images/eggplant.png" width="200" height="129" style="float: left; padding-right: 5px;" />
            </div>
