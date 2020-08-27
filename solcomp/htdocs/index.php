<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php
        require('includes/head.inc.php');
    ?>
</head>
<body class="oneColElsCtrHdr">
    <div id="container">
        <!-- content header including logo -->
        <div id="header">
            <?php
                require('includes/header.inc.php');
            ?>
        </div>
        <!-- top menu bar -->
        <div class="menuContainer" id="topMenu">
            <?php
                require("includes/menu_bar.inc.php");
            ?>
        </div>
        <!-- a drop shadow below the menu div -->
        <div id="menushadow"></div>

        <!-- container div for the page content area -->
        <div id="mainContent">
            <!-- navigation breadcrumbs -->
            <div id="bread">
                <?php
                    require('includes/breadcrumbs.inc.php');
                ?>
            </div>
            <!-- all page content below here -->
            <?php
                /* 
                 * provides function path_info_to_content()
                 * which converts /home/faq => _content.home_faq.php
                 */
                require_once('includes/pathinfo.inc.php');
                $content = 'includes/'.path_info_to_content();

                if (! file_exists($content)) {
                    echo $_SERVER['PATH_INFO'];
                    echo "<h3>Invalid Page Access</h3>";
                } else {
                    require($content);
                }
            ?>
        </div>
        <!-- drop shadow above the footer div -->
        <div id="footershadow"></div>
        <!-- footer containing logos, etc -->
        <div id="footer">
            <?php
                    require('includes/footer.inc.php');
            ?>
        </div>
    </div>
</body>
</html>
