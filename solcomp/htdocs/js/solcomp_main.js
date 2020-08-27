var Site = {
    start: function(){

    /* add OverText to anything that is of class 'ot' */
    $$('.ot').each( 
            function(el,i) { 
            new OverText(el);
        }   
    );

        var imageAsset = new Asset.images(solImages);
        var siteImageAssets = new Asset.images(siteImages);

        /* random logo image*/
        var src = solImages.getRandom();
        if ($('header') != null) {
            $('header').setStyle('background','url(' + src + ') #CCCCCC no-repeat 0px 0px');
        }
    }
};

/* colorize the tables */
var TableColor = {
    start: function() {
        //add table shading 
        //$$('tr:odd').each( function(el,i) { el.addClass('alt'); }    );
        $$('tr:even').each( function(el,i) { el.addClass('alt'); }  );                      
    }                         
};

var addDivDetach = {
    init:   function() {
        $$('.detach_div').each( 
                                function(el, i) {
                                    divDetach(el);
                                }
                              );
    }
}

function divDetach(el) {
    el.getParent().addClass("search_result");
    el.setProperty('title', 'Click here to open results in a new window');
    el.addEvent('click', function() {
        /* var elId = el.get('id'); */
        var parentId = el.getParent().get('id');
        /* alert(parentId); */
        detachDiv(parentId);
        /* el.getParent().getChildren(); */
                                    });
}

/* background images for the page header */
var solImages = [
                    '/images/logo_image.black_pearl.png', 
                    '/images/logo_image.chili.png', 
                    '/images/logo_image.petunia.png', 
                    '/images/logo_image.tobacco_flower.png', 
                    '/images/logo_image.tobacco_leaf.png', 
                    '/images/logo_image.tomato_fruit.png', 
                    '/images/logo_image.wild_potato.png' 
                ];

/* other site images for caching */                
var siteImages = [
'/images/arabidopsis_chr.png',
'/images/arabidopsis_icon.png',
'/images/area.png',
'/images/bubble.png',
'/images/eggplant.png',
'/images/funded_by_USDA_logo.png',
'/images/grape_chr.png',
'/images/grape_icon.png',
'/images/logo_msu.png',
'/images/new_window.png',
'/images/nsf_logo.png',
'/images/overview_164110.png',
'/images/overview_4072.png',
'/images/overview_4081.png',
'/images/overview_4084.png',
'/images/overview_4096.png',
'/images/overview_4097.png',
'/images/overview_4100.png',
'/images/overview_4102.png',
'/images/overview_4108.png',
'/images/overview_4113.png',
'/images/overview_null.png',
'/images/potato.png',
'/images/slider.png',
'/images/sol_logo.png',
'/images/tomato.png',
'/images/usda_mmm_potatoes.gif',
'/images/spinner.gif',
'/images/spinner_small.gif',
'/images/go_button.gif',
'/images/folder.png'
                 ];

/* search box */
window.addEvent('domready', Site.start);

/* color tables */
window.addEvent('domready', TableColor.start);

function detachDiv( divName ) {

    if ( $(divName) == null ) {
        return false;
    }
    
    var windowHeight = $(divName).offsetHeight + 100;

    if (windowHeight > 768) {
        windowHeight = 768;
    } 

    var newWindow = window.open('', '_blank', 'width=1024,height='+windowHeight+',scrollbars=yes,location=no,menubar=yes,toolbar=no,titlebar=no,status=no,resizable=yes');

/*    newWindow.document.write($$('head')[0].get('html'));  */
    
    newWindow.document.write('<html><head>');
    newWindow.document.write('<link href="/css/solcomp_style.css" rel="stylesheet" type="text/css" />');
    newWindow.document.write('</head><body class="oneColElsCtrHdr"><div id="container"><div id="mainContent">');
    
    $(divName).getElement('.detach_div').getParent().removeClass("search_result");
    $(divName).getElement('.detach_div').destroy();

    newWindow.document.write($(divName).get('html'));
    
    newWindow.document.write('</div></div></body></html>');
    newWindow.document.close();
    
    $(divName).set('html','');
}
