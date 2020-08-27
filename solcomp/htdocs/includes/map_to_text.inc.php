<?php
    require_once("pathinfo.inc.php");
    $src = path_info_to_src();

    $json_url = 'http://'.$_SERVER['HTTP_HOST'].'/cgi-bin/sitemap/sitemap_to_text.cgi?all=1&src='.$src;
    $json = file_get_contents($json_url);
    $menu = json_decode($json, true);

    if (sizeof($menu) > 0) {
        /* item_to_text function */
        require_once('item_to_text.inc.php');
        foreach ($menu as $item) {
            item_to_text($item);
        }
    }
?>
