<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Sub_Menu_Template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Solanaceae Genomics Resource</title>
<!-- InstanceEndEditable -->

<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->

<link href="/css/solcomp_style.css" rel="stylesheet" type="text/css" />

<script src="/js/lib/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="/js/lib/mootools/mootools-1.2-core.js" type="text/javascript"></script>
<script src="/js/lib/mootools/mootools-1.2-more.js" type="text/javascript"></script>
<script src="/js/solcomp_main.js" type="text/javascript"></script>
<script src="/js/lib/sorting_table.js" type="text/javascript"></script>
<script src="/js/ajaxDiv.js" type="text/javascript"></script>
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
        <?php
        require("includes/menu_bar.inc.php");
        ?>
        <div id="menushadow"></div>
    </div>
  <!-- end #header -->
  </div>
  
  <div id="mainContent">
<!--
    <div id='test_header'>Header</div>
    <div id='test_container'></div>
-->

    <?php $put_id = 'PUT-157a-Solanum_tuberosum-11244'; ?>
    
    <div class='ajaxdiv_top_menu'>
        <div id='grp_close_all' class='ajaxdiv_top_button'>Collapse All</div>
        <div id='grp_open_all' class='ajaxdiv_top_button'>Expand All</div>
    </div>

    <h2>Gene Overview Page for '<?php echo $put_id; ?>'</h2>
    <h3>Function: unknown</h3>

    <div id='grp_snp'></div>
    <div id='grp_ssr'></div>
    <div id='grp_bestarab'></div>
    <div id='grp_bestgrape'></div>
    <div id='grp_bestpoplar'></div>
    <div id='grp_bestpara'></div>
    <div id='grp_bestortho'></div>
    <div id='grp_orthomcl'></div>

  <script type="text/javascript">
    var putId = '<?php echo $put_id ?>';
    var grpDivs = new Array(
        new ajaxDiv(
            'grp_snp',
            'SNPs Predicted from EST Assembly',
            '/cgi-bin/SNP/sol_snps.cgi?id=' + putId,
            false
        ),
        new ajaxDiv(
            'grp_ssr',
            'Predicted SSRs',
            '/cgi-bin/SSR/ssr_db_query.cgi?id=' + putId,
            false
        ),
        new ajaxDiv(
            'grp_bestarab',
            'Arabidopsis Best Hits',
            '/cgi-bin/mapping/map_search.cgi?org=arabidopsis&id=' + putId,
            false
        ),
        new ajaxDiv(
            'grp_bestgrape',
            'Grape Best Hits',
            '/cgi-bin/mapping/map_search.cgi?org=grape&id=' + putId,
            false
        ),
        new ajaxDiv(
            'grp_bestpoplar',
            'Poplar Best Hits',
            '/cgi-bin/mapping/map_search.cgi?org=poplar&id=' + putId,
            false
        ),
        new ajaxDiv(
            'grp_bestpara',
            'Paralog Predictions by Best Hit',
            '/cgi-bin/ortholog/sol_orth_tblastx.pl?hit_type=paralogs&ta=' + putId,
            false
        ),
        new ajaxDiv(
            'grp_bestortho',
            'Ortholog Predictions by Best Hit',
            '/cgi-bin/ortholog/sol_orth_tblastx.pl?hit_type=orthologs&ta=' + putId,
            false
        ),
        new ajaxDiv(
            'grp_orthomcl',
            'Ortholog Predictions by OrthoMCL Clustering',
            '/cgi-bin/orthomcl/orthomcl_view.cgi?id=' + putId,
            false
        )
    );
    $('grp_open_all').addEvent('click', function() {
            grpDivs.each(
                function(theDiv) {
                    theDiv.open(); 
            });
        }
    );
    $('grp_close_all').addEvent('click', function() {
            grpDivs.each(
                function(theDiv) {
                    theDiv.close();
            });
        }
    );
/*    var divTest2 = new ajaxDiv('test2', 'OrthoMCL Cluster Assignment', '/cgi-bin/orthomcl/orthomcl_view.cgi?id=PUT-157a-Solanum_tuberosum-11244', false);
*/
    /*divTest.open();*/
    /* $(divTest.headerDivId).addEvent('click', function() {
        divTest.toggle();
    }); */
  
  </script>

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
