<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
<?php
    require_once("pathinfo.inc.php");
    $src = path_info_to_src();
    
    $json_url = 'http://'.$_SERVER['HTTP_HOST'].'/cgi-bin/sitemap/sitemap_parse.cgi?src='.$src;
    // fetch the page information as JSON from the sitemap.xml parsing CGI script
    $json = file_get_contents($json_url);
    $crumbs = json_decode($json, true);
    if (isset($crumbs)) {
        //current page should be on the end of the stack
        $current_page = array_pop($crumbs);
        echo $current_page['title'];
    } else {
        echo 'Solanaceae Genomics Resource - Invalid Access';
    }
?>
</title>
<!-- dreamweaver spry menu bar -->    
<script src="/js/lib/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<!-- mootools libraries -->
<script src="/js/lib/mootools/mootools-1.2-core.js" type="text/javascript"></script>
<script src="/js/lib/mootools/mootools-1.2-more.js" type="text/javascript"></script>
<!-- tables on cows sortable and paginating table for mootools -->    
<script src="/js/lib/sorting_table.js" type="text/javascript"></script>
<!-- SGR custom code -->
<script src="/js/solcomp_main.js" type="text/javascript"></script>
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
<!-- SGR custom CSS -->
<link href="/css/solcomp_style.css" rel="stylesheet" type="text/css" />
<!-- dreamweaver spry menu bar styles -->
<link href="/css/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
