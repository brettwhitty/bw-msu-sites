<?php
    $data_root = '/data/potatogenomics_download';

    $url = parse_url($_SERVER['HTTP_REFERER']);
    $url_path = $url['host'].$url['path'];

    echo $url_path;
    //check HTTP_REFERER to prevent crosslinking
    if (
        $url_path != 'potatogenomics-dev.plantbiology.msu.edu/'
        && $url_path != 'potatogenomics-dev.plantbiology.msu.edu/index.php'
        && $url_path != 'potatogenomics-dev.plantbiology.msu.edu/data_release.inc.php'
    ) {
        invalid_access();
    }

    //we must have a file name
    if (! isset($_GET['name']) || $_GET['name'] == '') {
        invalid_access();
    }

    //prevent injection attacks
    $filename = basename($_GET['name']);
    $filepath = $data_root.'/'.$filename;

    //file must exist
    if (! file_exists($filepath)) {
        invalid_access();
    }

    header('Content-type: application/x-gzip');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    readfile($filepath);

    function invalid_access() {
        echo "<h3>File Access Denied</h3><p>If you believe this is an error, please contact <a href='mailto:sgr@plantbiology.msu.edu?subject=PGSC File Download Error'>sgr@plantbiology.msu.edu</a> and report the steps that led you to this page.</p>";
        exit;
    }
?>
