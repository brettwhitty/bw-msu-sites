<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Sub_Menu_Template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<?php
        $put_id = '';
        if (isset($_POST['id'])) {
            $put_id = $_POST['id'];
        } else if (isset($_GET['id'])) {
            $put_id = $_GET['id'];
        }
?>

<title>Solanaceae Genomics Resource - Gene Overview - <?php echo $put_id; ?></title>
<!-- InstanceEndEditable -->

<!-- InstanceBeginEditable name="head" -->


<!-- InstanceEndEditable -->

<link href="/css/solcomp_style.css" rel="stylesheet" type="text/css" />

<script src="/js/lib/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="/js/lib/mootools/mootools-1.2-core.js" type="text/javascript"></script>
<script src="/js/lib/mootools/mootools-1.2-more.js" type="text/javascript"></script>
<script src="/js/sol_main.js" type="text/javascript"></script>
<script src="/js/lib/sorting_table.js" type="text/javascript"></script>
<script src="/js/lib/paginating_table.js" type="text/javascript"></script>
<script src="/js/AjaxDiv.js" type="text/javascript"></script>
<script src="/js/CollapseDiv.js" type="text/javascript"></script>
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

  <!-- InstanceBeginEditable name="BreadCrumbs" -->
  <div id="bread"><ul><li class="first"><a href='search.php'>Search</a></li><li>Gene Overview</li></ul></div>
  <!-- InstanceEndEditable -->

<!--
    <div id='test_header'>Header</div>
    <div id='test_container'></div>
-->

    

    <h1><strong><?php echo $put_id; ?></strong> Overview Page</h1>

    <div class='line'><div class='line_shadow'></div></div>

    <!-- the functional overview is not collapsible -->
    <div>
        <div id='grp_function' style='padding-left: 1.5em; width: 700px; float:left;'></div>
        <div id='grp_gbrowse' style='float: left; clear: right;'></div>
        <div class='clear'></div>
        <div id='grp_na_sequence' style='padding: 0 2em; width: 920px; float: left; clear: right;'></div>
        <div class='clear'></div>
        <div id='grp_aa_sequence' style='padding: 0 2em; width: 920px; float: left; clear: right;'></div>
        <div class='clear'></div>
    </div>

    <div class='line'><div class='line_shadow'></div></div>

    <div id='grp_collapse_box_container'>
        <!-- the top menu -->
        <div class='ajaxdiv_top_menu'>
            <button id='grp_close_all' class='ajaxdiv_top_button'>Collapse All</button>
            <button id='grp_open_all' class='ajaxdiv_top_button'>Expand All</button>
        </div>
        <div class='clear'></div>

        <!-- everything else is in a collapsible box -->
        <!--        <div id='grp_gbrowse'></div>     -->
        <div id='grp_uniref'></div>
        <div id='grp_snp'></div>
        <div id='grp_ssr'></div>
        <div id='grp_bestarab'></div>
        <div id='grp_bestgrape'></div>
        <div id='grp_bestpoplar'></div>
        <div id='grp_orthomcl'></div>
        <div id='grp_bestpara'></div>
        <div id='grp_bestortho'></div>
    </div>

  <script type="text/javascript">
    var putId = '<?php echo $put_id ?>';
    var grpFunction = new AjaxDiv({
            parentDiv: 'grp_function',
            headerText: 'PUT Details',
            url: '/cgi-bin/grp/grp_seq_stats.cgi?id=' + putId,
            startOpen: true
    }).hideHeader();

        new AjaxDiv({
            parentDiv:  'grp_gbrowse',
            headerText: 'Genome Browser Links',
            url:        '/cgi-bin/grp/grp_gbrowse_links.cgi?id=' + putId,
            startOpen:  true,
            headerOpenClass:    'collapsediv_open',
            headerClosedClass:  'collapsediv_closed',
            headerTitleClass:   'collapsediv_title',
            headerIconClass:    'collapsediv_header_icon',
            titleClass:         'collapsediv_title',
            contentClass:       'ajaxdiv_content_borderless',
            enableRefresh:      false,
            enableTextDetach:   false,
            enableHTMLDetach:   false
        }).hideHeader();

        new AjaxDiv({
            parentDiv:  'grp_na_sequence',
            headerText: 'Nucleotide FASTA Sequence',
            url:        '/cgi-bin/grp/grp_fasta_sequence.cgi?type=na&id=' + putId,
            startOpen:  true,
            headerOpenClass:    'collapsediv_open',
            headerClosedClass:  'collapsediv_closed',
            headerTitleClass:   'collapsediv_title',
            headerIconClass:    'collapsediv_header_icon',
            titleClass:         'collapsediv_title',
            contentClass:       'ajaxdiv_content_borderless',
            enableRefresh:      false,
            enableTextDetach:   true,
            enableHTMLDetach:   false,
        });

        new AjaxDiv({
            parentDiv:  'grp_aa_sequence',
            headerText: 'ESTScan-Translated Polypeptide FASTA Sequence',
            url:        '/cgi-bin/grp/grp_fasta_sequence.cgi?type=aa&id=' + putId,
            startOpen:  true,
            headerOpenClass:    'collapsediv_open',
            headerClosedClass:  'collapsediv_closed',
            headerTitleClass:   'collapsediv_title',
            headerIconClass:    'collapsediv_header_icon',
            titleClass:         'collapsediv_title',
            contentClass:       'ajaxdiv_content_borderless',
            enableRefresh:      false,
            enableTextDetach:   true,
            enableHTMLDetach:   false
        });


    var grpDivs = new Array(
        new AjaxDiv({
            parentDiv:  'grp_snp',
            headerText: 'Top BLASTX Hits vs. Uniref100',
            url:        '/cgi-bin/grp/grp_uniref100.cgi?id=' + putId,
            enableTextDetach:   false,
            enableHTMLDetach:   false,
            startOpen:  true,
            helpText: 'Top 5 BLASTX hits against Uniref100 with a cutoff of E=1e-5',
            helpURL: 'http://www.ebi.ac.uk/uniref/'
        }),
        new AjaxDiv({
            parentDiv:  'grp_snp',
            headerText: 'EST Assembly and Predicted SNPs',
            url:        '/cgi-bin/SNP/sol_snps.grp.cgi?grp=1&id=' + putId,
            enableTextDetach:   false,
            enableHTMLDetach:   false,
            startOpen:  true,
            helpText: 'Read about analysis methods',
            helpURL:  '/analyses_snp.php'
        }),
        new AjaxDiv({
            parentDiv:  'grp_ssr',
            headerText: 'Predicted SSRs',
            url:        '/cgi-bin/SSR/ssr_db_query.cgi?grp=1&id=' + putId,
            enableTextDetach:   false,
            enableHTMLDetach:   false,
            startOpen:  true,
            helpText: 'Read about analysis methods',
            helpURL:  '/analyses_ssr.php'
        }),
        new AjaxDiv({
            parentDiv:  'grp_bestarab',
            headerText: 'Arabidopsis Best BLAST Hits',
            url:        '/cgi-bin/mapping/map_search.cgi?grp=1&org=arabidopsis&id=' + putId,
            enableTextDetach:   false,
            enableHTMLDetach:   false,
            startOpen:  true,
            helpText: 'Read about analysis methods',
            helpURL:  '/analyses_sol_mapping.php'
        }),
        new AjaxDiv({
            parentDiv:  'grp_bestgrape',
            headerText: 'Grape Best BLAST Hits',
            url:        '/cgi-bin/mapping/map_search.cgi?grp=1&org=grape&id=' + putId,
            enableTextDetach:   false,
            enableHTMLDetach:   false,
            startOpen:  true,
            helpText: 'Read about analysis methods',
            helpURL:  '/analyses_sol_mapping.php'
        }),
        new AjaxDiv({
            parentDiv:  'grp_bestpoplar',
            headerText: 'Poplar Best BLAST Hits',
            url:        '/cgi-bin/mapping/map_search.cgi?grp=1&org=poplar&id=' + putId,
            enableTextDetach:   false,
            enableHTMLDetach:   false,
            startOpen:  true,
            helpText: 'Read about analysis methods',
            helpURL:  '/analyses_sol_mapping.php'
        }),
        new AjaxDiv({
            parentDiv:  'grp_orthomcl',
            headerText: 'OrthoMCL Cluster Membership',
            url:        '/cgi-bin/orthomcl/orthomcl_view.cgi?grp=1&id=' + putId,
            enableTextDetach:   false,
            enableHTMLDetach:   true,
            startOpen:  true,
            helpText: 'Read about analysis methods',
            helpURL:  '/analyses_ortholog_paralog.php'
        }),
        new AjaxDiv({
            parentDiv:  'grp_bestpara',
            headerText: 'Putative Paralogs by Best Hit',
            url:        '/cgi-bin/ortholog/sol_orth_tblastx.cgi?grp=1&hit_type=para&ta=' + putId,
            enableTextDetach:   false,
            enableHTMLDetach:   false,
            startOpen:  true,
            helpText: 'Read about analysis methods',
            helpURL:  '/analyses_ortholog_paralog.php'
        }),
        new AjaxDiv({
            parentDiv:  'grp_bestortho',
            headerText: 'Putative Orthologs by Best Hit',
            url:        '/cgi-bin/ortholog/sol_orth_tblastx.cgi?grp=1&hit_type=orth&ta=' + putId,
            enableTextDetach:   false,
            enableHTMLDetach:   false,
            startOpen: true,
            helpText: 'Read about analysis methods',
            helpURL:  '/analyses_ortholog_paralog.php'
        })
    );
    /* support open all */
    $('grp_open_all').addEvent('click', function() {
            grpDivs.each(
                function(theDiv) {
                    theDiv.open(); 
            });
        }
    );
    /* support close all */
    $('grp_close_all').addEvent('click', function() {
            grpDivs.each(
                function(theDiv) {
                    theDiv.close();
            });
        }
    );
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
