<ul id="MenuBar1" class="MenuBarHorizontal">
<?php
    $json_url = 'http://'.$_SERVER['HTTP_HOST'].'/cgi-bin/sitemap/sitemap_to_menu.cgi';
    $json = file_get_contents($json_url);
    $menu = json_decode($json, true);

    /* item_to_li function */
    require_once('item_to_li.inc.php');
    foreach ($menu as $item) {
        item_to_li($item);
    }
?>
</ul>
<script type="text/javascript">
    <!--
        var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {
            imgDown:    "/css/SpryAssets/SpryMenuBarDownHover.gif", 
            imgRight:   "/css/SpryAssets/SpryMenuBarRightHover.gif"
        });
    //-->
</script>
