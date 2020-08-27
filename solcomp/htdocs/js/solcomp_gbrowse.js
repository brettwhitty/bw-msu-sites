/* background images for the page header */
var solImages = [
                    '/images/wild_potato_flower.png',
                    '/images/tomato_flower.png', 
                    '/images/tobacco_flower.png', 
                    '/images/tomato_bg.png', 
                    '/images/tobacco_leaf.png',
                    '/images/capsicum_logo.png',
                    '/images/solanum_sp.png',
                    '/images/petunia.png'
                ];       

       /* initialize the observer for the select box */
       Event.observe(window, 'load', init_sol_gbrowse, false);

       function init_sol_gbrowse() {

        /* random logo image
        var src = solImages.getRandom();
        if ($('header') != null) {
            $('header').setStyle('background','url(' + src + ') #CCCCCC no-repeat -40px -100px');
        }
        */

            Event.observe(
                'select_organism', 
                'change',
                function() {
                    /* var select = $('select_organism');
                    var org    = $(select).getValue(); */
                    var org = $('select_organism').getValue();
                    $('select_accession').selectedIndex = 0;
                    var url = '/includes/assembly_select_box.inc.php?org=' + org;
                    var pars = 'org=' + org;
                    var target = 'ajax_select_div';
                    var myAjax = new Ajax.Updater(target, url, {method: 'get', parameters: pars});
                },
                false   
            );
            Event.observe(
                'ajax_select_div', 
                'change',
                function() {
                    var acc = $('select_accession').getValue();
                    if (acc != '') {
                        var forms = $$('form[name=mainform]');
                        var inputs = forms[0].select('input[name=name]');
                        inputs[0].value = acc;
                    }
                    var forms = $$('form[name=mainform]');
                    forms[0].submit();
                },
                false   
            );
      }
