<?php
    require_once("pathinfo.inc.php");
    $src = path_info_to_src();

    $json_url = 'http://'.$_SERVER['HTTP_HOST'].'/cgi-bin/sitemap/sitemap_to_submenu.cgi?all=1&src='.$src;
    $json = file_get_contents($json_url);
    $menu = json_decode($json, true);

    if (sizeof($menu) > 0) {
        echo "  <div id='submenu_left'>\n";
        echo "      <ul>\n";

        /* item_to_li function */
        require_once('item_to_li.inc.php');
        foreach ($menu as $item) {
            item_to_li($item);
        }
        echo "      </ul>\n";
        echo "  </div>\n";
    }
?>
