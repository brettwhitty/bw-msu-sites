<?php
    require("php-lib/FileCache.php");

    $c = new FileCache();
    $last_modified = $c->cache_include("http://sol-dev.plantbiology.msu.edu/cgi-bin/SSR/ssr_summary_table.cgi");
    if ($last_modified != '') {
        echo "<em class='small_font'>Last modified $last_modified.</em>";
    }
?>
