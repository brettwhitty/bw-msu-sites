<?php
    /*
            FileCache Class

            Will create a local cached version of data retrieved with the PHP file() function.
            
            Brett Whitty 2008
            whitty@msu.edu
     */
     
    class FileCache {
        protected $cache_dir, $expire, $ctx;
    
        public function __construct($c_dir = '', $exp = 168) {
            if ($c_dir == '') {
                $c_dir = $_SERVER['DOCUMENT_ROOT']."/webserver_tmp";
            }

            $this->cache_dir    = $c_dir;
            $this->expire       = $exp;
            
        }

        public function cache_include($url) {

            $md5 = md5($url);
           
            $cachefile = $this->cache_dir.'/fileCache_'.$md5;

            $update_failed = FALSE;
           
            if (! file_exists($cachefile) || ((time() - filemtime($cachefile)) / 3600) > $this->expire) {
                /*

                $ctx = stream_context_create(array(
                                                    'http' => array(
                                                                        'timeout' => 1
                                                                   )
                                                  )
                                            );
                file_get_contents("http://example.com/", 0, $ctx); 

                */
                
                //get URL
                if ($data = file_get_contents($url)) {
                    //request succeeded
                    $fh = fopen($cachefile, "w");
                    fwrite($fh, $data); //write contents of url to cache file
                    fclose($fh);

                    chmod($cachefile, 0666);

                    //check if writing the file failed
                    if (! file_exists($cachefile) || filesize($cachefile) == 0) {
                        $update_failed = TRUE;
                    }
                } else {
                    //request failed
                    $update_failed = TRUE;
                }
           }
           
           if ($update_failed && ! file_exists($cachefile)) {
               echo "<h3>Resource temporarily unavailable.</h3>";
               return '';
           } else {
               include($cachefile);
               return date("F d Y H:i:s", filemtime($cachefile));   
           }
           
        }
        
    }
    
?>
