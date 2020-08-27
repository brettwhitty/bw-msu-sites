<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Potato Genome Sequencing Consortium Data Release</title>

        <link rel="stylesheet" href="css/content.css" type="text/css" />
        <link rel="stylesheet" href="css/ui.css" type="text/css" />
  
        <script type="text/javascript" src="/js/lib/mootools/mootools-1.2-core.js"></script>
        <script type="text/javascript" src="/js/lib/mootools/mootools-1.2-more.js"></script>
        <!--[if IE]>
            <script type="text/javascript" src="scripts/excanvas-compressed.js"></script>
        <![endif]-->
        <script type="text/javascript" src="/js/lib/mocha/source/Utilities/mocha.js.php"></script>
    </head>
    <body>
        <div id='pgsc_container'>
            <div id='pgsc_header'>
                <?php require_once('includes/header.inc.php'); ?>
            </div>
            <div id='pgsc_contents' style='clear: both'>
                <div id='pgsc_menu' style='position: absolute; top: 150px; left: 0px'>
                    <?php require_once('includes/menu.inc.php'); ?>
                </div>
                <div id='pgsc_page' style='position: absolute; top: 100px; left: 150px; width: 500px'>
                    <?php require_once('includes/menu.inc.php'); ?>
                    <?php
                        if (! isset($_GET['p']) || $_GET['p'] == '') {
                            require_once('includes/download.inc.php');
                        } else if ($_GET['p'] == 'download') {
                            require_once('includes/download.inc.php');
                        } else if ($_GET['p'] == 'blast') {
                            require_once('includes/blast.inc.php');
                        } else if ($_GET['p'] == 'agreement') {
                            require_once('includes/data_release.inc.php');
                        } else {
                            echo "Invalid page access.";
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
