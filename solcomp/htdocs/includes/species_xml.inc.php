<?php
    header('text/plain');
    $taxon_genus_hash = [];
    try {
        require_once("php-lib/TaxonList.php"); // Class uses sol_seq database
        $tax_list = new TaxonList(1); // get species with display_rank >= 2
        $taxon_genus_hash = $tax_list->get_genus_hash(); // if something is broken with TaxonList this should return 'null'
        if (is_null($taxon_genus_hash)) {
            // for testing purposes, etc. if DB is not available,
            // by default use a fake genus hash with one species (Potato)
            $taxon_genus_hash = [
                'Solanum'   =>  [
                    [
                        'scientific_name'   =>  'Solanum tuberosum',
                        'taxon_id'          =>  '4113'
                    ]
                ]
            ];
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
    foreach(array_keys($taxon_genus_hash) as $genus) {
        echo str_repeat(' ', 8)."<page name='$genus' title='SGR Species in $genus' src='/species/$genus'>\n";
        foreach($taxon_genus_hash[$genus] as $row) {
            $name     = $row['scientific_name'];
            $taxon_id = $row['taxon_id'];
            echo str_repeat(' ', 12)."<page name='&lt;em&gt;$name&lt;/em&gt;' title='SGR Species Overview for $name' src='/species/overview/$taxon_id' />\n";
        }
        echo str_repeat(' ', 8)."</page>\n";
    }
?>
