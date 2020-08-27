#!/usr/bin/perl

## Module for styling Solanaceae Genomics Resource GBrowse installs
## to include site header, footer and menus
##
## Requires 'php-cli' for generating menu bar content (see below)
##
## Brett Whitty, 2008-10

package GbrowseHeader;

use strict;
use warnings;

use FindBin qw{ $RealBin };

my $name = '';

sub new {
    my ($class, $arg_name) = @_;
    
    $name = (defined($arg_name)) ? $arg_name : 'GBrowse';
    
    return bless {}, $class;
}

sub get_string {

    my $out = <<END;
  <div class="oneColElsCtrHdr">
    <div id="container">
    <div id="header">
    <div id="logo">
        <div id="sol_site_logo"><img src="/images/sol_logo.png" alt="Solanaceae Genomics Resource at Michigan State University" width="500" height="49" /></div>
        <div id="usda_funding_logo"><img src="/images/funded_by_USDA_logo.png" alt="funded by USDA CSREES NSF" width="171" height="40" /></div>
        <div id="google_search">
            <form method="get" action="http://www.google.com/search">
                <input id='search_box' name='q' type='text' value='Site Search...'>
                <input value='' id='go' class='button' name='btnG' type='submit' alt='Go' src='/images/go_button.gif'>
                <input type='hidden' name='ie'>
                <input type='hidden' name='oe'>
                <input type='hidden' name='domains' value='http://solanaceae.plantbiology.msu.edu/'>
                <input type='hidden' name='sitesearch' value='http://solanaceae.plantbiology.msu.edu/' checked>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        var logo_images = [
            "/images/logo_image.black_pearl.png",
            "/images/logo_image.chili.png",
            "/images/logo_image.petunia.png",
            "/images/logo_image.tobacco_flower.png",
            "/images/logo_image.tobacco_leaf.png",
            "/images/logo_image.tomato_fruit.png",
            "/images/logo_image.wild_potato.png"
        ];
        var preload = new Image();
        var i;
        for (i = 0; i <= logo_images.length; i++) {
            preload.src = logo_images[i];
        };
        document.getElementById('logo').style.background = "rgb(204,204,204) url(" + logo_images[ Math.floor(Math.random() * logo_images.length) ] + ")  no-repeat 0px 0px";
    </script>
    <div class="menuContainer" id="topMenu">
END
    $out .= `php -q $RealBin/../htdocs/includes/menu_bar.inc.php`;       
    $out .= <<END;
        <div id="menushadow"></div>
    </div>
  </div>
  <div id="mainContent">
  <div id="bread"><ul><li class="first"><a href="/analyses.php">Analyses/Tools</a></li><li><a href="/tools_gbrowse.php">Genome Browers</a></li><li>$name</li></ul></div>
END

    if ($name eq 'Solanaceae') {
    } elsif ($name eq 'Grape') {

    $out .= <<END;        
    <div>
        <img src="/grape_icon.png" border="0" align="absmiddle" style="padding-left: 60px; padding-right: 15px;">
        <b style='font-size: 14pt; font-weight: bold;'>Solanaceae vs. <em>Vitis vinifera</em> Genome Browser</b>
        <img src="/grape_chr.png" border="0" usemap="#grape_chr" align="absmiddle" style="padding-left: 50px;">
        <map id="grape_chr" name="grape_chr">
            <area shape="rectangle" alt="Chr1" title="Chr1" coords="7,25,20,115" href="?name=chr1" target="" />
            <area shape="rectangle" alt="Chr2" title="Chr2" coords="28,32,41,115" href="?name=chr2" target="" />
            <area shape="rectangle" alt="Chr3" title="Chr3" coords="49,45,62,115" href="?name=chr3" target="" />
            <area shape="rectangle" alt="Chr4" title="Chr4" coords="70,16,85,115" href="?name=chr4" target="" />
            <area shape="rectangle" alt="Chr5" title="Chr5" coords="93,21,106,115" href="?name=chr5" target="" />
            <area shape="rectangle" alt="Chr6" title="Chr6" coords="114,22,127,115" href="?name=chr6" target="" />
            <area shape="rectangle" alt="Chr7" title="Chr7" coords="135,8,148,115" href="?name=chr7" target="" />
            <area shape="rectangle" alt="Chr8" title="Chr8" coords="157,3,171,115" href="?name=chr8" target="" />
            <area shape="rectangle" alt="Chr9" title="Chr9" coords="179,8,191,115" href="?name=chr9" target="" />
            <area shape="rectangle" alt="Chr10" title="Chr10" coords="199,20,213,115" href="?name=chr10" target="" />
            <area shape="rectangle" alt="Chr11" title="Chr11" coords="7,166,21,237" href="?name=chr11" target="" />
            <area shape="rectangle" alt="Chr12" title="Chr12" coords="27,156,41,238" href="?name=chr12" target="" />
            <area shape="rectangle" alt="Chr13" title="Chr13" coords="48,142,63,238" href="?name=chr13" target="" />
            <area shape="rectangle" alt="Chr14" title="Chr14" coords="70,149,84,238" href="?name=chr14" target="" />
            <area shape="rectangle" alt="Chr15" title="Chr15" coords="91,189,107,237" href="?name=chr15" target="" />
            <area shape="rectangle" alt="Chr16" title="Chr16" coords="113,149,129,238" href="?name=chr16" target="" />
            <area shape="rectangle" alt="Chr17" title="Chr17" coords="134,182,149,237" href="?name=chr17" target="" />
            <area shape="rectangle" alt="Chr18" title="Chr18" coords="155,119,171,238" href="?name=chr18" target="" />
            <area shape="rectangle" alt="Chr19" title="Chr19" coords="177,158,193,238" href="?name=chr19" target="" />
        </map>
    </div>
END
    } elsif ($name eq 'Poplar') {
        
        $out .= <<END;
        <div align=left>
            <img src="/images/poplar_icon.png" align=absmiddle border="0">
            <b style='font-size: 14pt; font-weight: bold;'>Solanaceae vs. <em>Populus trichocarpa</em> Genome Browser</b>
<!--            <img src="images/poplar_chr.png" border="0" usemap="#poplar_chr"> -->
        </div>
END
        
    } elsif ($name eq 'Arabidopsis') {
        $out .= <<END;
    <div style='clear: both;'>
        <img src="/arabidopsis_icon.png" border="0" align="absmiddle" style="margin-left: 100px;">
        <b style='font-size: 14pt; font-weight: bold;'>Solanaceae vs. <em>Arabidopsis thaliana</em> Genome Browser</b>
        <img src="/arabidopsis_chr.png" border="0" usemap="#ath1_chr" align="absmiddle" style="margin-left: 150px;">
        <map name='ath1_chr'>
            <area shape="Rect" href="?name=chr1" alt="Chr1" title="Chr1" coords="0, 0 17, 104">
            <area shape="Rect" href="?name=chr2" alt="Chr2" title="Chr2" coords="18, 0 34, 104">
            <area shape="Rect" href="?name=chr3" alt="Chr3" title="Chr3" coords="35, 0 51, 104">
            <area shape="Rect" href="?name=chr4" alt="Chr4" title="Chr4" coords="52, 0 68, 104">
            <area shape="Rect" href="?name=chr5" alt="Chr5" title="Chr5" coords="69, 0 85, 104">
       </map>
    </div>
END
      
    }

    return $out;
}

    
1;
