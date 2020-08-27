package SolHTML;

## For use with including GBrowse in the Solanaceae Comparative Genomics Resource with consistent header/footer

sub new {
            my $self = {};
            bless $self;
            return $self;
        }
     
sub head {
print <<END;
    <link href="/css/solcomp_style.css" rel="stylesheet" type="text/css" />
    <script src="/js/lib/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
    <script src="/js/lib/mootools/mootools-1.2-core.js" type="text/javascript"></script>
    <script src="/js/lib/mootools/mootools-1.2-more.js" type="text/javascript"></script>
    <script src="/js/solcomp_main.js" type="text/javascript"></script>
    <script src="/js/lib/sorting_table.js" type="text/javascript"></script>
    <!-- Google analytics code -->
    <script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
        var pageTracker = _gat._getTracker("UA-4869897-1");
        pageTracker._initData();
        pageTracker._trackPageview();
    </script>
    <!-- end of Google code -->
    <link href="/css/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
END

}
        
sub header {
print <<END;
  <div class="oneColElsCtrHdr">
    <div id="container">
    <div id="header">
    <div id="logo">
        <div id="sol_site_logo"><img src="images/sol_logo.png" alt="Solanaceae Genomics Resource at Michigan State University" width="500" height="49" /></div>
        <div id="usda_funding_logo"><img src="images/funded_by_USDA_logo.png" alt="funded by USDA CSREES NSF" width="171" height="40" /></div>
        <div id="google_search">
            <form method="get" action="http://www.google.com/search">
                <input id='search_box' name='q' type='text' value='Site Search...'>
                <input value='' id='go' class='button' name='btnG' type='submit' alt='Go' src='/images/go_button.gif'>
                <input type='hidden' name='ie'>
                <input type='hidden' name='oe'>
                <input type='hidden' name='domains' value='http://solanaceae.plantbiology.msu.edu/'>
                <input type='hidden' name='sitesearch' value='http://solanaceae.plantbiology.msu.edu/' checked>
            </form>
        </div>
    </div>
    <div class="menuContainer" id="topMenu">
        <ul id="MenuBar1" class="MenuBarHorizontal">
        <li><a href="/" class="MenuBarItemSubmenu">Home</a>
          <ul> 
            <li><a href="home_news.php">News</a></li>
            <li><a href="home_faq.php">FAQ</a></li>
            <li><a href="home_links.php">Links</a></li>
            <li><a href="home_contact.php">Contact Us</a></li>
          </ul>
        </li>
    <li><a href="projects.php" class="MenuBarItemSubmenu">Projects</a>
            <ul>
              <li><a href="projects_solcomp_overview.php">Sol Comparative Genomics</a>
                <ul>
                  <li><a href="projects_solcomp_facts.php">Solanaceae Genome Facts</a></li>
                  <li><a href="projects_solcomp_version.php">Data Versioning</a></li>
                </ul>
              </li>
              <li><a href="projects_potato_chr6.php" class="MenuBarItemSubmenu">Potato Chr. 6 Sequencing</a>
                <ul>
                  <li><a href="projects_potato_bacs_summary.php">Potato BACs Summary</a></li>
                </ul>
               </li>
            </ul>
        </li>
        <li><a href="species.php" class="MenuBarItemSubmenu">Species</a>
          <ul>
            <li><a href="species_overview.php?sp=4113">Potato</a></li>
            <li><a href="species_overview.php?sp=4097">Tobacco</a></li>
            <li><a href="species_overview.php?sp=4081">Tomato</a></li>
            <li><a href="species_overview.php?sp=4072">Chili Pepper</a></li>
            <li><a href="species_overview.php?sp=4100">Nicotiana benthamiana</a></li>
            <li><a href="species_overview.php?sp=164110">N. langsdorffii x sanderae</a></li>
            <li><a href="species_overview.php?sp=4096">Nicotiana sylvestris</a></li>
            <li><a href="species_overview.php?sp=4102">Petunia x hybrida</a></li>
            <li><a href="species_overview.php?sp=4108">Solanum chacoense</a></li>
            <li><a href="species_overview.php?sp=62890">Solanum habrochaites</a></li>
            <li><a href="species_overview.php?sp=28526">Solanum pennellii</a></li>
          </ul>
          </li>
      <li><a href="analyses.php" class="MenuBarItemSubmenu">Analyses/Tools</a>
        <ul>
              <li><a href="tools_gbrowse.php" class="MenuBarItemSubmenu">Genome Browsers</a>
                  <ul>
                    <li><a href="/cgi-bin/gbrowse/solanaceae/">Solanaceae</a></li>
                    <li><a href="/cgi-bin/gbrowse/arabidopsis/">Arabidopsis</a></li>
                    <li><a href="/cgi-bin/gbrowse/grape/">Grape</a></li>
                    <li><a href="/cgi-bin/gbrowse/poplar/">Poplar</a></li>
                  </ul>
              </li>
              <li><a href="tools_blast.php">BLAST</a></li>  
              <li><a href="analyses_sol_mapping.php">Comparative Mapping</a> </li>
              <li><a href="analyses_ortholog_paralog.php">Orthologs/Paralogs</a> </li>
              <li><a href="analyses_lineage_specific.php">Lineage-Specific Genes</a></li>
              <li><a href="analyses_snp.php">SNPs</a> </li>
              <li><a href="analyses_ssr.php" class="MenuBarItemSubmenu">SSRs</a>
                  <ul>
                    <li><a href="analyses_ssr_pipeline.php">SSR Pipeline</a></li>
                    <li><a href="analyses_ssr_summary.php">SSR Summary Statistics</a></li>
                    <li><a href="analyses_ssr_query.php">SSR Database Search</a></li>
                  </ul>
              </li>
              <li><a href="analyses_solcomp_repeats.php">Solanaceae Repeat Database</a></li>
              <li><a href="analyses_markers.php">Genetic Markers</a>
                  <ul>
                    <li><a href="analyses_markers_arabidopsis.php">Arabidopsis COSII</a></li>
                    <li><a href="analyses_markers_eggplant.php">Eggplant</a></li>
                    <li><a href="analyses_markers_pepper.php">Pepper</a></li>
                    <li><a href="analyses_markers_potato.php">Potato</a></li>
                    <li><a href="analyses_markers_tomato.php">Tomato</a></li>
                  </ul>
              </li>
              <li><a href="analyses_qtl_papers.php">QTL Papers</a></li>
        </ul>
        </li>
      <li><a href="downloads.php" class="MenuBarItemSubmenu">Downloads</a>
        <ul class="last">
          <li><a href="ftp://ftp.plantbiology.msu.edu/pub/sgr/" class="MenuBarItemSubmenu">FTP Site</a>
            <ul>
              <li><a href="ftp://ftp.plantbiology.msu.edu/pub/sgr/potato/bacs/">Potato Chr. 6 BACs</a></li>
              <li><a href="ftp://ftp.plantbiology.msu.edu/pub/sgr/potato/bac_ends/">Potato BAC Ends</a></li>
              </ul>
          </li>
        </ul>
      </li>
    </ul>
        <div id="menushadow"></div>
    </div>
  </div>
  <div id="mainContent">
  <div id="bread"><ul><li class="first"><a href="/analyses.php">Analyses/Tools</a></li><li><a href="/tools_gbrowse.php">Genome Browers</a></li><li>Arabidopsis</li></ul></div>
END

  
}

1;
