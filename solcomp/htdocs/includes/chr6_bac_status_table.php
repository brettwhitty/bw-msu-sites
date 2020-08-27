<?php

// one week
$cacheminutes = 10800;

get_table_cached();

function get_table_cached($cacheminutes = 10800, $cacheprefix = 'includes/chr6_bac_status_table') {
        
    $csummary = $cacheprefix.".detail.html";
    $cdetail = $cacheprefix.".summary.html";
    
    if (! file_exists($cacheprefix.".detail.html")){ //if cache file doesn't exist
        touch($csummary); //create it
        touch($cdetail); //create it
        chmod($csummary, 0666);
        chmod($cdetail, 0666);
        cache_table($cacheprefix); //then populate cache file with contents of RSS feed
    } else if (((time() - filemtime($csummary)) / 60) > $cacheminutes) { 
        //if age of cache file great than cache minutes setting
        cache_table($cacheprefix);
    }
    
    global $mode;
    if ($mode == 'detail') {
        readfile($cdetail); 
    } else {
        readfile($csummary);
    }
}
    
function cache_table($cacheprefix) {
        
    $csummary = $cacheprefix.".detail.html";
    $cdetail = $cacheprefix.".summary.html";

    #    $bac_list = file("includes/potato_bacs.list");
    #foreach ($bac_list as $bac) {
    #    $bac = rtrim($bac);
    #    $bacs[$bac] = 1;    
    #}

    // fetch BAC lengths
    $bacs = get_len();
    
    $status_html = file("http://www.tigr.org/tigr-scripts/tdb/sol/sol_bacs_detailed.pl?sort=status&order=asc");

    $table = '';
    
    $flag = 0;
    $done_count = 0;
    $sequencing_count = 0;
    $annotated_count = 0;
    foreach ($status_html as $line) {
        $last_bac = '';
        $line = ltrim(rtrim($line));
        if (preg_match("/<table>/", $line)) {
            $line = preg_replace("/<table>/", "<table id='potato_bac_status'><thead>", $line);
            $flag = 1;
        }
        if (preg_match("/^<\/tr>\$/", $line)) {
            $line = preg_replace("/<\/tr>/", "</tr></thead><tbody>", $line);
        }
        if ($flag) {
            if (preg_match("/Clone_name/", $line)) {
                $line = preg_replace("/Clone_name/", "Clone Name", $line);
            }
            $line = preg_replace("/<a href='\/tigr-scr[^>]+>([^<]+)<\/a>/", "$1", $line);
            if (preg_match("/Done/", $line)) {
                $done_count++;
                preg_match("/(AC\d+)/", $line, $m);
                $last_bac = $m[1];
                $line = preg_replace("/http:\/\/www\.tigr\.org\/tigr-scripts\/gbrowse\/gbrowse\/potato/", "/cgi-bin/gbrowse/solanaceae", $line);
                if (isset($bacs[$last_bac])) {
                    $line = preg_replace("/N\/A/", "<a href='/cgi-bin/gbrowse/solanaceae/?start=0;stop=1e8;ref=".$m[1]."'>Available</a>", $line);
                }
            }
            $line = preg_replace("/\?ref=/", "?start=0;stop=1e8;ref=", $line);
            if (preg_match("/Sequencing/", $line)) {
                $sequencing_count++;
            }
            
            if (preg_match("/Available/", $line)) {
                $annotated_count++;
            }
            if (preg_match("/<\/table>/", $line)) {
                $line = preg_replace("/<\/table>/", "</tbody></table>", $line);
                $flag = 0;
            }
            if (preg_match("/<td>0<\/td>/", $line)) {
                if ($bacs[$last_bac]) {
                    $line = preg_replace("/<td>0<\/td>/", "<td>$bacs[$last_bac]</td>", $line);
                } else {
                    $line = preg_replace("/<td>0<\/td>/", "<td>?</td>", $line);
                    $line = preg_replace("/<td>N\/A<\/td>/", "<td>Pending</td>", $line);
                }
            }
            $table .= $line."\n";
        }
    }

    $stable = "<table id='potato_bac_status_summary'>
                <thead><tr>
                <th>Total Target No. BACs</th><th>BACs in Genbank</th><th>BACs Annotated</th><th>BACs in Sequencing</th></tr></thead>
                <tr><td><center>575</center></td><td><center>$done_count</center></td><td><center>$annotated_count</center></td><td><center>$sequencing_count</center></td></tr>
               </table>";
               
    $stable .= "<p class='timestamp'>Status updated ".date('l jS \of F Y h:i:s A')."</p>";
    $table .= "<p class='timestamp'>Status updated ".date('l jS \of F Y h:i:s A')."</p>";
    
    
    $fh = fopen($cdetail, "w");
    fwrite($fh, $table); //write contents of feed to cache file
    fclose($fh);
    
    $fh = fopen($csummary, "w");
    fwrite($fh, $stable); //write contents of feed to cache file
    fclose($fh);
    
    return $table;
}

function get_len() {
    $lengths = array();

    $DB_USER = '';
    $DB_PASS = '';

    mysql_connect('mysql', $DB_USER, $DB_PASS);
    mysql_select_db('sol_gbrowse');
    
    $query = "select n.name as id, (f.end - f.start + 1) as len from feature f, name n, typelist t where f.typeid = t.id and n.id = f.id and n.display_name=1 and t.tag = 'contig:'";
    
    $result = mysql_query($query);
    
    if (! $result) {
        die('Query failed: '.mysql_error());
    }
    
    while ($row = mysql_fetch_assoc($result)) {
        $lengths[$row['id']] = $row['len'];
    }
    
    return $lengths;
}

?>
