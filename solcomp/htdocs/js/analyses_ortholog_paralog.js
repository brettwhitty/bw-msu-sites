var searchSlide1;
var searchSlide2;
var searchSlide3;

window.addEvent('domready', function() {
    searchSlide1 = new Fx.Slide($('search_form_div_1'), {
        duration: 200,
        fps: 50,
    });
    searchSlide2 = new Fx.Slide($('search_form_div_2'), {
        duration: 200,
        fps: 50,
    });
    searchSlide3 = new Fx.Slide($('search_form_div_3'), {
        duration: 200,
        fps: 50,
    });

    $('search_header_1').addEvent('click',  function(e){
        e = new Event(e);
        if (searchSlide1.open) {
            searchSlide1.slideOut();
            $('search_header_1').addClass('expand_box_header');
        } else {
            searchSlide1.slideIn();
            $('search_header_1').removeClass('expand_box_header');
        }
/*        console.log(searchFormDivCollapse);*/
        e.stop();
    });
    $('search_header_2').addEvent('click',  function(e){
        e = new Event(e);
        if (searchSlide2.open) {
            searchSlide2.slideOut();
            $('search_header_2').addClass('expand_box_header');
        } else {
            searchSlide2.slideIn();
            $('search_header_2').removeClass('expand_box_header');
        }
/*        console.log(searchFormDivCollapse);*/
        e.stop();
    });
    $('search_header_3').addEvent('click',  function(e){
        e = new Event(e);
        if (searchSlide3.open) {
            searchSlide3.slideOut();
            $('search_header_3').addClass('expand_box_header');
        } else {
            searchSlide3.slideIn();
            $('search_header_3').removeClass('expand_box_header');
        }
/*        console.log(searchFormDivCollapse);*/
        e.stop();
    });


    $('search_form_1').addEvent('submit', function(e) {

        new Event(e).stop();
        
        $('search_results').empty().addClass('ajax-loading');
        searchSlide2.slideOut();
        $('search_header_2').addClass('expand_box_header');
        searchSlide3.slideOut();
        $('search_header_3').addClass('expand_box_header');
    
        this.set('send', { 
                
            /*
            onRequest: function() {
                $('snp_search_results').empty().addClass('ajax-loading');
                                    },
            */
                        
            onSuccess: function(result) {
                $('search_results').removeClass('ajax-loading');
                $('search_results').set('html', result);
        
                /* TableColor.start.delay(1); */
        
                new SortingTable('result_table', {zebra: true});
                
                addDivDetach.init();

                searchSlide1.slideOut();
                $('search_header_1').addClass('expand_box_header');
        
                                          },
                        
            onFailure: function(result) {
                $('search_results').removeClass('ajax-loading');
                $('search_results').set('html', result.responseText);
                                          }
                          });

        this.send();
        
    });
 
    $('search_form_2').addEvent('submit', function(e) {

        new Event(e).stop();
        
        $('search_results').empty().addClass('ajax-loading');
        searchSlide1.slideOut();
        $('search_header_1').addClass('expand_box_header');
        searchSlide3.slideOut();
        $('search_header_3').addClass('expand_box_header');
    
        this.set('send', { 
                
            /*
            onRequest: function() {
                $('snp_search_results').empty().addClass('ajax-loading');
                                    },
            */
                        
            onSuccess: function(result) {

                $('search_results').removeClass('ajax-loading');
                $('search_results').set('html', result);
                
                /*TableColor.start.delay(1);*/
               
                new SortingTable('result_table', {zebra: true});
                
                addDivDetach.init();
               
                searchSlide2.slideOut();
                $('search_header_2').addClass('expand_box_header');
                                         },
                        
            onFailure: function(result) {
                $('search_results').removeClass('ajax-loading');
                $('search_results').set('html', result.responseText);
                                          }
                          });

        this.send();
        
    });
    $('search_form_3').addEvent('submit', function(e) {

        new Event(e).stop();
        
        $('search_results').empty().addClass('ajax-loading');
        searchSlide1.slideOut();
        $('search_header_1').addClass('expand_box_header');
        searchSlide2.slideOut();
        $('search_header_2').addClass('expand_box_header');
    
        this.set('send', { 
                
            /*
            onRequest: function() {
                $('snp_search_results').empty().addClass('ajax-loading');
                                    },
            */
                        
            onSuccess: function(result) {
                $('search_results').removeClass('ajax-loading');
                $('search_results').set('html', result);
    
                /*    TableColor.start.delay(1); */

                new SortingTable('result_table', {zebra: true});
                
                addDivDetach.init();
        
                searchSlide3.slideOut();
                $('search_header_3').addClass('expand_box_header');

                                          },
                        
            onFailure: function(result) {
                $('search_results').removeClass('ajax-loading');
                $('search_results').set('html', result.responseText);
                                          }
                          });

        this.send();
        
    });


    /* intercept the SNP search links */
    $$('a.search_link_1').each( function(el,i){                               
        el.addEvent('click',  function(e){
            e.stop();
        
            $('search_field_1').value = el.text;

            $('search_button_1').click();

        });
    });
    /* intercept the search links */
    $$('a.search_link_2').each( function(el,i){                               
        el.addEvent('click',  function(e){
            e.stop();
        
            $('search_field_2').value = el.text;

            $('search_button_2').click();

        });
    });
     /* intercept the search links */
    $$('a.search_link_3').each( function(el,i){                               
        el.addEvent('click',  function(e){
            e.stop();
        
            $('search_field_3').value = el.text;

            $('search_button_3').click();

        });
    });
      

/* 
    var mySlide = new Slider($('slider'), $('knob'), {
        onChange: function(pos){
            $('slider_test').set('html', pos);
            $('approx').value = pos;
        },
        steps: 5
    }).set(0);
 
*/

});
