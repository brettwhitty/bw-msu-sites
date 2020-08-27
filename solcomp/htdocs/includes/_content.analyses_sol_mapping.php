  <script src="/js/analyses_sol_mapping.js" type="text/javascript"></script>
        <h2>Solanaceae Transcript Assembly to Model Genome Mapping</h2>
        <p>We mapped the <a href='http://www.plantgdb.org/prj/ESTCluster/index.php'>PlantGDB-generated Unique Transcript</a> (PUTs) assemblies to loci from the Arabidopsis (TAIR8), Grape (v1) and Poplar (v1.1) genome releases using tblastx with a cutoff of E = 1<sup>-10</sup>.</p>
        <p>This page will return the top 3 matches from the selected target genome when a PUT assembly ID, or member GenBank EST accession number is entered from any of the Solanaceae species (<i>Capsicum annuum</i>, <i>Nicotiana benthamiana</i>, <i>Solanum lycopersicum</i>, <i>Solanum tuberosum</i>, etc.).
            </p>

            <div class='download_notice'>
            <p><img class='mini_icon' src='/images/folder.png'>Data from our model genome mapping database is also <a href='ftp://ftp.plantbiology.msu.edu/pub/sgr/other/comparative_mapping/'>available for download from our FTP site</a>.<p>
            </div>
            
            <div id="search_header" class="collapse_box_header">
                <h2>Solanaceae Mapping Search</h2>
            </div>
            <div id="search_form_div">
                <fieldset>
                <form id='sol_arab_mapping' action='/cgi-bin/mapping/map_search.cgi' method='get' target='_blank'>
                  Select a model genome and enter a <strong>PlantGDB PUT Assembly ID</strong> (exact term, case insensitive) or <strong>GenBank EST Accession</strong> to find the mapped locus in the selected model genome at an e-value cutoff of E = 1<sup>-10</sup>.
 (e.g. <a class="sol_arab_link" href='/cgi-bin/map_arabidopsis/sol_arab_mapping.pl?id=PUT-161a-Solanum_lycopersicum-4'>PUT-161a-Solanum_lycopersicum-4</a>, <a class="sol_arab_link" href='/cgi-bin/map_arabidopsis/sol_arab_mapping.pl?id=PUT-163a-Solanum_pennellii-7'>PUT-163a-Solanum_pennellii-7</a>, <a class="sol_arab_link" href='/cgi-bin/map_arabidopsis/sol_arab_mapping.pl?id=DY344679'>DY344679</a>)
                  <br/>
                  <br/>
                  
                  Target Genome: 
                  <select name='org'>
                    <option value='arabidopsis'>Arabidopsis</option>
                    <option value='grape'>Grape</option>
                    <option value='poplar'>Poplar</option>
                  </select>

                  <br/>
                  <br/>
                  <input id="search_field" maxlength='40' name='id' size='50' type='text'>
                  <br/>
                  <br/>
                  <input id="search_button" type='submit' value='Search'>&nbsp;&nbsp;<input type='reset' value='Reset'>
                </form>
              </fieldset>
            </div>
              <div id='formResult'>
                  <div id='formResultContent'>
                  </div>
              </div>
