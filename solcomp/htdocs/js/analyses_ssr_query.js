window.addEvent('domready', function() {
    var searchSlide1 = new Fx.Slide($('ssr_search_form1_div'), {
        duration: 400,
        fps: 50,
        transition: Fx.Transitions.Quad
    });
    var searchSlide2 = new Fx.Slide($('ssr_search_form2_div'), {
        duration: 400,
        fps: 50,
        transition: Fx.Transitions.Quad
    });
    var searchSlide3 = new Fx.Slide($('ssr_search_form3_div'), {
        duration: 400,
        fps: 50,
        transition: Fx.Transitions.Quad
    });

    $('ssr_search_header1').addEvent('click',  function(e){
        e = new Event(e);
        if (searchSlide1.open) {
            searchSlide1.slideOut();
            $('ssr_search_header1').addClass('expand_box_header');
        } else {
            searchSlide1.slideIn();
            $('ssr_search_header1').removeClass('expand_box_header');
        }
/*        console.log(searchFormDivCollapse);*/
        e.stop();
    });

    $('ssr_search_header2').addEvent('click',  function(e){
        e = new Event(e);
        if (searchSlide2.open) {
            searchSlide2.slideOut();
            $('ssr_search_header2').addClass('expand_box_header');
        } else {
            searchSlide2.slideIn();
            $('ssr_search_header2').removeClass('expand_box_header');
        }
/*        console.log(searchFormDivCollapse);*/
        e.stop();
    });

    $('ssr_search_header3').addEvent('click',  function(e){
        e = new Event(e);
        if (searchSlide3.open) {
            searchSlide3.slideOut();
            $('ssr_search_header3').addClass('expand_box_header');
        } else {
            searchSlide3.slideIn();
            $('ssr_search_header3').removeClass('expand_box_header');
        }
/*        console.log(searchFormDivCollapse);*/
        e.stop();
    });

    $('ssr_search_form1').addEvent('submit', function(e) {
        new Event(e).stop();
        var result = $('ssr_search_results').empty().addClass('ajax-loading');
        searchSlide1.slideOut();
        $('ssr_search_header1').addClass('expand_box_header');
        searchSlide2.slideOut();
        $('ssr_search_header2').addClass('expand_box_header');
        searchSlide3.slideOut();
        $('ssr_search_header3').addClass('expand_box_header');
    
        this.set('send', { 
                /*
            onRequest: function() {
                var resultbox = $('ssr_search_results').empty().addClass('ajax-loading');
                                    },
                  */
                  
            onSuccess: function(result) {
                $('ssr_search_results').removeClass('ajax-loading');
                $('ssr_search_results').set('html', result);
                if ($('result_table') != null) {
                    new SortingTable('result_table', {zebra: true});
                }
                addDivDetach.init();
                                          },
                        
            onFailure: function(result) {
                $('ssr_search_results').removeClass('ajax-loading');
                $('ssr_search_results').set('html', result.responseText);
                                          }
                          });

        this.send();
        
    });
    
    
    $('ssr_search_form2').addEvent('submit', function(e) {
        new Event(e).stop();
        var result = $('ssr_search_results').empty().addClass('ajax-loading');
        searchSlide1.slideOut();
        $('ssr_search_header1').addClass('expand_box_header');
        searchSlide2.slideOut();
        $('ssr_search_header2').addClass('expand_box_header');
        searchSlide3.slideOut();
        $('ssr_search_header3').addClass('expand_box_header');
        this.set('send', { 
                /*
            onRequest: function() {
                var resultbox = $('ssr_search_results').empty().addClass('ajax-loading');
                                    },
                  
                  */
            onSuccess: function(result) {
                $('ssr_search_results').removeClass('ajax-loading');
                $('ssr_search_results').set('html', result);
                if ($('result_table') != null) {
                    new SortingTable('result_table', {zebra: true});
                }
                addDivDetach.init();
                                          },
                        
            onFailure: function(result) {
                $('ssr_search_results').removeClass('ajax-loading');
                $('ssr_search_results').set('html', result.responseText);
                                          }
                          });

        this.send();
            
    });
    
    $('ssr_search_form3').addEvent('submit', function(e) {
        new Event(e).stop();
        var result = $('ssr_search_results').empty().addClass('ajax-loading');
        searchSlide1.slideOut();
        $('ssr_search_header1').addClass('expand_box_header');
        searchSlide2.slideOut();
        $('ssr_search_header2').addClass('expand_box_header');
        searchSlide3.slideOut();
        $('ssr_search_header3').addClass('expand_box_header');
        this.set('send', { 
                /*
            onRequest: function() {
                var resultbox = $('ssr_search_results').empty().addClass('ajax-loading');
                                    },
                  
                  */
                  
            onSuccess: function(result) {
                $('ssr_search_results').removeClass('ajax-loading');
                $('ssr_search_results').set('html', result);
                if ($('result_table') != null) {
                    new SortingTable('result_table', {zebra: true});
                }
                addDivDetach.init();

                                          },
                        
            onFailure: function(result) {
                $('ssr_search_results').removeClass('ajax-loading');
                $('ssr_search_results').set('html', result.responseText);
                                          }
                          });

        this.send();
    });
    
    
        /* intercept the SNP search links */
    $$('a.demo_link2').each( function(el,i){                                
        el.addEvent('click',  function(e){
            e.stop();
        
            $('search_field2').value = el.text;

            $('search_button2').click();

        });
    });

        /* intercept the SNP search links */
    $$('a.demo_link3').each( function(el,i){                                
        el.addEvent('click',  function(e){
            e.stop();
        
            $('search_field3').value = el.text;

            $('search_button3').click();

        });
    });


    
});
