<?php
    function item_to_text($item, $max_level = 2, $head_level = 0) {
        $head_level += 1;

        $href  = $item['src'];
        $name  = ($item['alt']) ? $item['alt'] : $item['name'];
        $title = $item['title'];
        $text  = $item['text'];

        echo "<h$head_level>";
        if ($head_level > 1) {
            echo "<a href='$href' alt='$title'>";
        }
        echo $title;
        if ($head_level > 1) {
            echo "</a>";
        }
        echo "</h$head_level>";
        echo "$text";
        if ($max_level == 0 || $head_level < $max_level) {
            foreach($item['children'] as $child) {
                item_to_text($child, $max_level, $head_level);
            }
        }
    }
?>
