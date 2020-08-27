<?php
    require('left_menu.inc.php');

    require_once('php-lib/TaxonList.php'); 
        
    $t = new TaxonList(1);
    $species = $t->get_array();
    
    // accept a get variable 'g' for genus 
//    $genus = (isset($_GET['g'])) ? $_GET['g'] : null;

    // read genus name from path_info
    require_once('pathinfo.inc.php');
    $src = path_info_to_src();
    $genus = basename($src);

    //check that the genus provided is valid
    $genus_match_count = 0;
    if (isset($genus)) {
        foreach ($species as $s) {
            ## show only the specified genus if asked
            if ($genus != null && ! preg_match("/^$genus/", $s['scientific_name'])) {
                continue; 
            }
            $genus_match_count++;
        }
    }
 
?>
<div id="submenu_content">

    <h1>Species</h1>
    
    <p><?php echo ($genus_match_count > 0) ? $genus : 'Solanaceae' ?> species for which resources are available:</p>
<?php 
    
    foreach ($species as $s) {
        ## show only the specified genus if asked
        if ($genus != null 
            && $genus_match_count > 0 
            && ! preg_match("/^$genus/", $s['scientific_name'])) {
            continue; 
        }
        echo "
      <h2><em><a href='/species/overview/"
        .$s['taxon_id']
        ."'>"
        .$s['scientific_name']
        ."</a></em>";
        if ($s['common_name'] != '') {
          echo " (".$s['common_name'].")";
        }
        echo "</h2>\n";
    }
?>
</div>
