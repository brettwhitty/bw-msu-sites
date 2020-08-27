<?php

    require_once("Cache_Lite-1.7.4/Lite.php");
    
    /*
        TaxonList Class

        Gets an associative array of all taxa in the sol_seq database

        Brett Whitty 2009
        whitty@msu.edu

        requires PEAR::Cache_Lite

        To install PEAR:

            curl -O http://pear.php.net/go-pear.phar
            sudo php -d detect_unicode=0 go-pear.phar
        
        Test that it's working from the command line:

            php -r "require_once('System.php'); var_dump(class_exists('System'));"

        Should output:

            bool(true)

    */
    
    class TaxonList {

        protected $cache_dir, $expire;
        protected $display_cutoff;
        private $cache;

        public function __construct($disp = 1, $c_dir = '', $exp = '604800') {
            if ($c_dir == '') {
                $c_dir = $_SERVER['DOCUMENT_ROOT']."/webserver_tmp/";
            }

            $this->cache_dir        = $c_dir;
            $this->expire           = $exp;
            $this->display_cutoff   = $disp;

            $options = array( 
                       'cacheDir'  => $this->cache_dir,
                       'lifeTime'  => $this->expire,
                       'automaticSerialization'    => TRUE
                            );
                                    
                            $this->cache = new Cache_Lite($options);
        }

        public function get_array() {
            $id = 'taxonomy_array-'.$this->display_cutoff;

            if ($arr = $this->cache->get($id)) {
                return $arr;
            } else {
                $arr = $this->db_fetch();
                $this->cache->save($arr, $id);
                return $arr;
            }
                
        }
        
        public function get_hash() {
            $id = 'taxonomy_hash-'.$this->display_cutoff;
 
            if ($arr = $this->cache->get($id)) {
                return $arr;
            } else {
                $arr = $this->db_fetch('hash');
                $this->cache->save($arr, $id);
                return $arr;
            }
        }

        public function get_genus_hash() {
            $id = 'taxonomy_genus_hash-'.$this->display_cutoff;
 
            if ($arr = $this->cache->get($id)) {
                // already cached
                return $arr;

            } else {
                //not cached, so fetch
                $arr = $this->db_fetch('genus_hash');

                if (is_null($arr)) {
                    // don't cache null
                    return $arr;
                } else {
                    
                    ksort($arr);

                    // save to cache
                    $this->cache->save($arr, $id);
    
                    return $arr;
                }
            }
        }


        private function db_fetch($type = 'array') {
            $taxa = array();

            $DB_USER = '';
            $DB_PASS = '';

            if (! function_exists('mysql_connect')) {
                error_log("TaxonList ERROR: PHP doesn't have 'mysql_connect' function avaiable!!! TaxonList will return 'null'!!!");
                return null;
            }

            try {
                mysql_connect('mysql.plantbiology.msu.edu', $DB_USER, $DB_PASS);
            } catch (Exception $e) {
                // silently ignore DB error and return null
                return null;
            }
            mysql_select_db('sol_seq');

            $result = mysql_query('select * from taxon where display_rank >= '.$this->display_cutoff.' order by scientific_name');
            while ($row = mysql_fetch_assoc($result)) {
                // support returning results as an array or a hash
                // keyed on taxon_id
                if ($type == 'array') {
                    array_push($taxa, $row);
                } else if ($type == 'hash') {
                    $taxa[$row['taxon_id']] = $row;
                } else if ($type == 'genus_hash') {
                    list($genus, $species) = explode(' ', $row['scientific_name']);
                    //array_push($taxa[$genus], $row);
                    $taxa[$genus][] = $row;
                }
            }
            return $taxa;
        }
    }
    
?>
