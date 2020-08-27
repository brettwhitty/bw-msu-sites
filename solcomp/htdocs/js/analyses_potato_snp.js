window.addEvent('domready', function() {
    var searchSlide1 = new Fx.Slide($('snp_search_form_div'), {
        duration: 400,
        fps: 50,
        transition: Fx.Transitions.Quad
    });

    $('snp_search_header').addEvent('click',  function(e){
        e = new Event(e);
        if (searchSlide1.open) {
            searchSlide1.slideOut().chain(function() {
                $('snp_search_header').addClass('expand_box_header');
            });
        } else {
            $('snp_search_header').removeClass('expand_box_header');
            searchSlide1.slideIn();
        }
/*        console.log(searchFormDivCollapse);*/
        e.stop();
    });

    $('snp_search_form').addEvent('submit', function(e) {

        new Event(e).stop();
        
        $('snp_search_results').empty().addClass('ajax-loading');
        searchSlide1.slideOut().chain(function() {
            $('snp_search_header').addClass('expand_box_header');
        });
    
        this.set('send', { 
                
            /*
            onRequest: function() {
                $('snp_search_results').empty().addClass('ajax-loading');
                                    },
            */
                        
            onSuccess: function(result) {
                $('snp_search_results').removeClass('ajax-loading');
                $('snp_search_results').set('html', result);
                TableColor.start.delay(1);
                addDivDetach.init();

                /* add scroll links for MSA */
                var putLength     = $('put_seq_len').getProperty('text');
                var scrollerWidth = $('msa_seqs').getScrollSize().x;
                var viewWidth     = $('msa_seqs').getSize().x;
                /* add links to the image map */
                $$('area').each(
                    function(el, i){                        
                        var snpPos = el.getProperty('title');
                        var scrollPos = snpPos / putLength * scrollerWidth - viewWidth / 2;
                        el.addEvent('click',
                            function(e){
                                new Event(e).stop();
                                $('msa_seqs').scrollLeft = scrollPos;
                            }                      
                        );
                    } 
                );
               /* add links to the summary table */
                $$('a.snp_loc_link').each(
                    function(el, i){                        
                        var snpPos = el.getProperty('text');
                        var scrollPos = snpPos / putLength * scrollerWidth - viewWidth / 2;
                        el.addEvent('click',
                            function(e){
                                new Event(e).stop();
                                $('msa_seqs').scrollLeft = scrollPos;
                            }                      
                        );
                        el.setStyle('pointer', 'hand');
                    } 
                );
                /* add NCBI links to legend items */
                $$('div.msa_legend_seq').each(
                    function(el, i){                        
                        var legendText = el.getProperty('text');
                        var textArr = legendText.split(" ");
                        var newText = '<a href="http://ncbi.nlm.nih.gov/nucest/' + textArr[0] + '" target="ncbi">'
                                      + textArr[0] + textArr[1] + '</a>';
                        var legendText = el.setProperty('html', newText);
                    }
                );
                
                                          },
                        
            onFailure: function(result) {
                $('snp_search_results').removeClass('ajax-loading');
                $('snp_search_results').set('html', result.responseText);
                                          }
                          });

        this.send();
        
    });
    
    
    /* intercept the SNP search links */
    $$('a.snp_link').each( function(el,i){                              
        el.addEvent('click',  function(e){
            e.stop();
        
            $('snp_field').value = el.text;

            $('search_button').click();

        });
    });
        
});
