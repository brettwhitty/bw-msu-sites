<!-- bread crumbs -->
            <ul>
<?php
{
    require_once("pathinfo.inc.php");
    $src = path_info_to_src();
    
    $json_url = 'http://'.$_SERVER['HTTP_HOST'].'/cgi-bin/sitemap/sitemap_parse.cgi?src='.$src;
    $json = file_get_contents($json_url);
    $crumbs = json_decode($json, true);

    $last = sizeof($crumbs) - 1;
    for ($i = 0; $i <= $last; $i++) {
        $url = '';
        $class = ($i == 0) ? ' class="first"' : '';
        echo "<li$class>";
        $label = $crumbs[$i]['name'];
        if ($i != $last) {
            $url   = $crumbs[$i]['src'];
        }
        if ($url != '') {
            echo "<a href='$url'>";
        }
        echo $label;
        if ($url != '') {
            echo "</a>";
        }
        echo "</li>";
    }
}
?>
            </ul>
