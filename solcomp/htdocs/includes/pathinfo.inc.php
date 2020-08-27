<?php

/* maps $_SERVER['PATH_INFO'] to index.php content include name 
 *
 * Requires custom mod_rewrite rules enabled via '.htaccess' to work
 *
 * See: '_htaccess.pathinfo'  
 *
 * */
function path_info_to_content() {

    if (! isset($_SERVER['PATH_INFO'])) {
        return '_content.index.php';
    }

    $path_info = $_SERVER['PATH_INFO'];
    $path_info = preg_replace('/^\/|\/$/', '', $path_info);

    // species/* is handled by the species page
    if (preg_match('/^species\/[^\/]+$/', $path_info)) {
        $path_info = 'species';
    }

    // species/overview/* is handled by the species_overview page
    if (preg_match('/^species\/overview\/[^\/]+$/', $path_info)) {
        $path_info = 'species_overview';
    }

    $path_info = preg_replace('/\//', '_', $path_info);
    
    return "_content.$path_info.php";
}

/* converts PATH_INFO (or if undefined, SCRIPT_NAME) into a lookup key
 * for searching the 'src' attribute of sitemap.xml 
 */
function path_info_to_src() {
    $src = isset($_SERVER['PATH_INFO']) ? 
        $_SERVER['PATH_INFO'] : basename($_SERVER['SCRIPT_NAME']);
   
    $src = preg_replace('/\/$/', '', $src);
    
    if ($src == 'index.php') {
        $src = '/';
    }

    return $src;
}

?>
