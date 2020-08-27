<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Downloads_template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Solanaceae Genomics Resource - Full Text Search</title>
<!-- InstanceEndEditable -->

<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->

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
</head>

<body class="oneColElsCtrHdr">

<div id="container">
  <div id="header">
    <div id="logo">
        <div id="sol_site_logo"><img src="/images/sol_logo.png" alt="Solanaceae Genomics Resource at Michigan State University" width="500" height="49" /></div>
        <div id="usda_funding_logo"><img src="/images/funded_by_USDA_logo.png" alt="funded by USDA CSREES NSF" width="171" height="40" /></div>
        <div id="google_search">
            <form method="get" action="http://www.google.com/search">
                <input id='search_box' class='ot' name='q' type='text' alt='Site Search...'>
                <input value='' id='go' class='button' name='btnG' type='submit' alt='Go' src='/images/go_button.gif'>
                <input type='hidden' name='ie'>
                <input type='hidden' name='oe'>
                <input type='hidden' name='domains' value='http://solanaceae.plantbiology.msu.edu/'>
                <input type='hidden' name='sitesearch' value='http://solanaceae.plantbiology.msu.edu/' checked>
            </form>
        </div>
    </div>
    <div class="menuContainer" id="topMenu">
        <?php
        require("includes/menu_bar.inc.php");
        ?>
        <div id="menushadow"></div>
    </div>
  <!-- end #header -->
  </div>
  
  <div id="mainContent">
  <!-- InstanceBeginEditable name="BreadCrumbs" -->
    <div id="bread"><ul><li class="first">Search</li></ul></div>
  <!-- InstanceEndEditable -->
  <!-- InstanceBeginEditable name="MainContentArea" -->
     <div class='omni_search' id='omni_search_div'>
        <form id='search_form' action='search.php' method='get'>
        <div>
            Search database by <input type='radio' name='search_type' id='annotation_search_flag' value='annotation' checked> Annotation Keyword
            <input type='radio' name='search_type' id='id_search_flag' value='id'> Accession
        </div>
        <div>
            <input id='search_keyword' class='ot' name='key' type='text' size='40' alt='Select search type and enter key(s)...'>
            <input id='go' class='button' value='' type='submit' alt='Go' src='/images/go_button.gif'>
        </div>
        </form>
    </div>
    <div id='omni_search_results'></div>
    <script type='text/javascript' src='/js/search.js'></script>
    <script type='text/javascript' src='/js/lib/paginating_table.js'></script>
    <!--    <script type='text/javascript' src='/js/CollapseDiv.js'></script> -->
    <script type='text/javascript'>
        var searchHash = new Hash();

        function handleSearch() {
            var resultDiv = 'omni_search_results';
            searchHash.set('key', $('search_keyword').value);
            if (searchHash.get('key').length < 3) {
                window.alert('Please enter a suitable keyword');
                return false;
            }
            if ($('annotation_search_flag').checked) {
                doFunctionSearch(resultDiv, searchHash);
            } else {
                doIdSearch(resultDiv, searchHash);
            }
        }
    /* do search on form submit */
        $('search_form').addEvent('submit', function(e) {
             e = new Event(e); 
             e.stop();

            handleSearch();
        });
    /* reload the search results if the field is already set */
    window.addEvent('domready', function() {
        if ($('search_keyword').value.length > 0) {
            handleSearch();
        }
    });
    </script>

  <!-- InstanceEndEditable -->
  <!-- end #mainContent -->
  </div>

<div id="footershadow"></div>
  
  <div id="footer">
    <div id="footer_logos" style="float:left;">
        <a href="http://plantbiology.msu.edu"><img src="/images/wordmark_pos_wht.gif" width="120" height="40" border="0" /></a>
    </div> 
    <div id="footer_text" style="float:right;">
        <em>Comments or Questions? Send e-mail to <a href="mailto:sgr@plantbiology.msu.edu?subject=Comment on Solanaceae Comparative Genomics Resource site">sgr@plantbiology.msu.edu </a></em>
    </div>
  <!-- end #footer --></div>
<!-- end #container --></div>

</body>
<!-- InstanceEnd --></html>
