window.addEvent('domready', function() {
	var searchSlide1 = new Fx.Slide($('search_form_div'), {
		duration: 400,
	    fps: 50,
    	transition: Fx.Transitions.Quad
	});

	$('search_header').addEvent('click',  function(e){
		e = new Event(e);
    	if (searchSlide1.open) {
			searchSlide1.slideOut();
        	$('search_header').addClass('expand_box_header');
	    } else {
			searchSlide1.slideIn();
    	    $('search_header').removeClass('expand_box_header');
    	}
/*        console.log(searchFormDivCollapse);*/
 		e.stop();
    });

	$('sol_arab_mapping').addEvent('submit', function(e) {

		new Event(e).stop();
    	
		$('formResultContent').empty().addClass('ajax-loading');
		searchSlide1.slideOut();
		$('search_header').addClass('expand_box_header');
	
		this.set('send', { 
                
			/*
    		onRequest: function() {
            	$('snp_search_results').empty().addClass('ajax-loading');
                                    },
		    */
                        
            onSuccess: function(result) {
				$('formResultContent').removeClass('ajax-loading');
                $('formResultContent').set('html', result);
				TableColor.start.delay(1);
                                          },
                        
            onFailure: function(result) {
                $('formResultContent').removeClass('ajax-loading');
                $('formResultContent').set('html', result.responseText);
                                          }
                          });

   		this.send();
		
    });
	
	
	/* intercept the SNP search links */
	$$('a.sol_arab_link').each( function(el,i){ 								
		el.addEvent('click',  function(e){
			e.stop();
		
			$('search_field').value = el.text;

			$('search_button').click();

    	});
	});
		
});


/*
        <script type="text/javascript">
        $('sol_arab_mapping').addEvent('reset', function(e) {
            $('formResult').setStyle('visibility', 'hidden');
        });
        $('sol_arab_mapping').addEvent('submit', function(e) {
            new Event(e).stop();
            $('formResult').setStyle('visibility', 'visible');
            var result = $('formResultContent').empty().addClass('ajax-loading');
            this.send({
                update: result,
                onComplete: function() {
                    result.removeClass('ajax-loading');
                }
            });
        });
        </script>
*/