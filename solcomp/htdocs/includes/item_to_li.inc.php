<?php
    function item_to_li($item) {
        $href  = $item['src'];
        $name  = ($item['alt']) ? $item['alt'] : $item['name'];
        $title = $item['title'];
        if (sizeof($item['children']) > 0) {
            echo "<li><a href='$href' alt='$title' class='MenuBarItemSubmenu'>$name</a>";
            echo "<ul>";
            foreach($item['children'] as $child) {
                item_to_li($child);
            }
            echo "</ul>";
        } else {
            echo "<li><a href='$href' alt='$title'>$name</a>";
        }
        echo "</li>";
    }
?>
