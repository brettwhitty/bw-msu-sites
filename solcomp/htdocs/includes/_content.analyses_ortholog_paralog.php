  <?php
      
      $orthomcl_id = null;

      if (isset($_POST['clid'])) {
          $orthomcl_id = $_POST['clid'];
      } else if (isset($_GET['clid'])) {
          $orthomcl_id = $_GET['clid'];
      }
  ?>
  <script type="text/javascript" src="/js/analyses_ortholog_paralog.js"></script>
        <h2>Solanaceae Ortholog and Paralog Database Search</h2>
        <h3>Best Hits Method</h3>
     <p>
     PlantGDB-assembled Unique Transcript (PUT) assembly sets for 11 Solanaceae species were obtained from the PlantGDB <a href='http://www.plantgdb.org/prj/ESTCluster/'>PUT</a> database. These sets were searched against each other using TBLASTX. A cut-off of 10<sup>-5</sup> was used to identify the best hits across Solanaceae species. Paralogs were required to be at least 45% identical over 225 bp.
     </p>
     <p>
     To search the database, enter a PUT identifier and find matches within the same species (paralogs) or in other Solanaceae species (orthologs).
     </p>
     <p>PUT identifiers are of the form <strong>PUT-<em>version_tag</em>-scientific_name-<em>number</em></strong>, where <strong><em>version_tag</em></strong> is the PUT release number, <em><strong>scientific_name</strong></em> is the species name with spaces replaced with underscores, and <em><strong>number</strong></em> is an unique integer value assigned to each PUT. [<a href='http://www.plantgdb.org/prj/ESTCluster/nomenclature.php'>see details at PlantGDB</a>]
    </p>

        <h3>OrthoMCL Clustering Method</h3>
        <p>The Solanaceae PUT sequences were translated using <a href='http://estscan.sourceforge.net/'>ESTScan 2.1</a> and the resulting polypeptide sequences were clustered using <a href='http://www.orthomcl.org/cgi-bin/OrthoMclWeb.cgi?rm=orthomcl#Software'>OrthoMCL</a> to produce clusters containing putative orthologs/in-paralogs.</p>
        <p>Since each set of Solanaceae translated PUT sequences represents an incomplete proteome, the more complete proteomes of the model genomes Arabidopsis, Poplar, and Grape were included in the analysis to help resolve orthologous relationships in cases where true orthologs were absent from one or more of the Solanaceae translated PUT sequence databases.</p>
        <p>Each cluster member sequence was compared to the UniProt <a href='http://www.ebi.ac.uk/uniref/'>UniRef50</a> database using BLASTP, and hits with an E-value &lt;1e-5 were retained. Functional annotation text associated with the UniRef50 sequences was slightly processed to improve the clarity/information content of the text, and the resulting combined text from all cluster members is associated with each cluster to enable text searching.</p>
        <p>The OrthoMCL cluster results can be searched by PUT identifier (see above), cluster identifier, or by cluster annotation keyword search.
        
        <div class='download_notice'>
        <p><img class='mini_icon' src='/images/folder.png'>Data from our ortholog/paralog databases is also <a href='ftp://ftp.plantbiology.msu.edu/pub/sgr/other/ortholog_paralog/'>available for download from our FTP site</a>.<p>
        </div>
        
    
        <div id="search_header_1" class="collapse_box_header">
            <h3>Search Best Hit Orthologs/Paralogs by Identifier</h3>
        </div>

        <div id="search_form_div_1">
            <fieldset>
                <form id='search_form_1' action='/cgi-bin/ortholog/sol_orth_tblastx.cgi' method='get' name='sol_orth' id='sol_orth' target='_blank'>

                Enter a current Solanaceae PUT Identifier (eg: <a href='/cgi-bin/ortholog/sol_orth_tblastx.cgi?ta=PUT-157a-Solanum_tuberosum-1' class='search_link_1'>PUT-157a-Solanum_tuberosum-1</a>).

                <br/>
                <br/>

                <input name='ta' type='text' id='search_field_1' size='50' maxlength='500'>

                <br/>
                <br/>

                Search for <input class='radio' checked type='radio' name='hit_type' value='paralogs'> Paralogs or <input class='radio' type='radio' name='hit_type' value='orth'> Orthologs

                <br/>
                <br/>

                <input type='submit' name='Submit' value='Search' id='search_button_1'>&nbsp;&nbsp;<input type='reset' name='Reset' value='Clear'>
                </form>
            </fieldset>
        </div>

        <div id="search_header_2" class="collapse_box_header">
            <h3>Search OrthoMCL Clusters by Identifiers</h3>
        </div>

        <div id="search_form_div_2">
            <fieldset>
            <form id='search_form_2' action='/cgi-bin/orthomcl/orthomcl_view.cgi' method='get' name='sol_orthomcl' id='sol_orthmcl' target='_blank'>

                Enter a current Solanaceae PUT Identifier or Cluster Identifier (eg: <a href='/cgi-bin/orthomcl/orthomcl_view.cgi?id=PUT-157a-Solanum_tuberosum-11244' class='search_link_2'>PUT-157a-Solanum_tuberosum-11244</a>, <a href='/cgi-bin/orthomcl/orthomcl_view.cgi?id=ORTHOMCL12345' class='search_link_2'>ORTHOMCL12345</a>).

                 <br/>
                 <br/>

                 <input name='id' type='text' id='search_field_2' size='50' maxlength='500'>

                 <br/>
                 <br/>

                 <input type='submit' name='Submit' value='Search' id='search_button_2'>&nbsp;&nbsp;<input type='reset' name='Reset' value='Clear'>
            </form>
            </fieldset>
    
        </div>
     
        <div id="search_header_3" class="collapse_box_header">
            <h3>Search OrthoMCL Clusters by Annotation Keyword</h3>
        </div>

        <div id="search_form_div_3">
     
            <fieldset>
            <form id='search_form_3' action='/cgi-bin/orthomcl/orthomcl_search.cgi' method='get' name='sol_orthomcl_search' id='sol_orthmcl_search' target='_blank'>

                Or, search cluster annotation by keyword (eg: <a href='/cgi-bin/orthomcl/orthomcl_search.cgi?id=PUT-157a-Solanum_tuberosum-11244' class='search_link_3'>kinase</a>).

                <br/>
                <br/>

                 <input name='key' type='text' id='search_field_3' size='50' maxlength='500'>
        
                 <input class='radio' checked type='radio' name='approx' value=''> Exact or <input class='radio' type='radio' name='approx' value='2'> Approximate
<!--
                <div id='slider_container'>
                    <div id='slider'>
                        <div id="knob"></div>
                    </div>
                    <div style='width:300px'>
                        <div style='float:left;width:100px'>Exact</div>
                        <div style='float:left;text-align:center' id='slider_test'></div>
                        <div style='float:right'>Approximate</div>
                    </div>
                </div>
-->
                
                 <br/>
                 <br/>
    
                 <input type='submit' name='Submit' value='Search' id='search_button_3'>&nbsp;&nbsp;<input type='reset' name='Reset' value='Clear'>

            </form>
            </fieldset> 
     
        </div>

        <div id="search_results">
        </div>
        <?php
            if (isset($orthomcl_id) && $orthomcl_id != '') {
              echo <<<JAVASCRIPT
<script>
window.addEvent('domready', function() {
    var resultDiv = $('search_results');
    resultDiv.addClass('ajax-loading');

    new Request.HTML({
        evalScripts: true,
        evalResponse: true,
        url:        '/cgi-bin/orthomcl/orthomcl_view.cgi?id=$orthomcl_id',
        update:     resultDiv,
        onSuccess:  function(responseTree, responseElements, responseHTML, responseJavaScript) {
                            searchSlide1.hide();
                            $('search_header_1').addClass('expand_box_header');
                            searchSlide2.hide();
                            $('search_header_2').addClass('expand_box_header');
                            searchSlide3.hide();
                            $('search_header_3').addClass('expand_box_header');
                            resultDiv.removeClass('ajax-loading');
                            new SortingTable('result_table', {zebra: true});
                            addDivDetach.init();
                    },
        onFailure:  function(responseTree, responseElements, responseHTML, responseJavaScript) {
                        resultDiv.removeClass('ajax-loading');
                    }
    }).get();
});
</script>
JAVASCRIPT;
            }
        ?>
