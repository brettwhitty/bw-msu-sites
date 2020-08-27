<html>
<head>
<link href="/css/solcomp_style.css" rel="stylesheet" type="text/css" />

<script src="/js/lib/mootools/mootools-1.2-core.js" type="text/javascript"></script>
<script src="/js/lib/mootools/mootools-1.2-more.js" type="text/javascript"></script>
<script src="/js/lib/sorting_table.js" type="text/javascript"></script>
<script src="/js/lib/paginating_table.js" type="text/javascript"></script>
<script src="/js/solcomp_main.js" type="text/javascript"></script>
</head>
<body>
<div id='text_search_forms'>
    <form id='text_search' method="get" action="">
        <input name='key' type='text'></input>
        <input value='' id='go' class='button' name='btnG' type='submit' alt='Go' src='images/go_button.gif'></input>
    </form>
    <form class='text_search_form' id='gbrowse_sol_' method="get" action="/services/text_search/search_gbrowse_note.php">
        <input type='hidden' name='key' value=''></input>
        <input type='hidden' name='db' value='solanaceae'></input>
    </form>
    <form class='text_search_form' id='gbrowse_arabidopsis_' method="get" action="/services/text_search/search_gbrowse_note.php">
        <input type='hidden' name='key' value=''></input>
        <input type='hidden' name='db' value='arabidopsis'></input>
    </form>
    <form class='text_search_form' id='gbrowse_grape_' method="get" action="/services/text_search/search_gbrowse_note.php">
        <input type='hidden' name='key' value=''></input>
        <input type='hidden' name='db' value='grape'></input>
    </form>
    <form class='text_search_form' id='gbrowse_poplar_' method="get" action="/services/text_search/search_gbrowse_note.php">
        <input type='hidden' name='key' value=''></input>
        <input type='hidden' name='db' value='poplar'></input>
    </form>
</div>
<div id='gbrowse_container' style='width: 90%;'>
    <div id='gbrowse_sol_result_counter_div'>
        <span id='gbrowse_sol_result_counter'>Search</span> in Solanaceae GBrowse database annotation text.
    </div>
    <div id='gbrowse_sol_result_div'>
    </div>
    <div id='gbrowse_arabidopsis_result_counter_div'>
        <span id='gbrowse_arabidopsis_result_counter'>Search</span> in Arabidopsis GBrowse database annotation text.
    </div>
    <div id='gbrowse_arabidopsis_result_div'>
    </div>
    <div id='gbrowse_grape_result_counter_div'>
        <span id='gbrowse_grape_result_counter'>Search</span> in Grape GBrowse database annotation text.
    </div>
    <div id='gbrowse_grape_result_div'>
    </div>
    <div id='gbrowse_poplar_result_counter_div'>
        <span id='gbrowse_poplar_result_counter'>Search</span> in Poplar GBrowse database annotation text.
    </div>
    <div id='gbrowse_poplar_result_div'>
    </div>
</div>
<script type='text/javascript'>

    // adds click and slide reveal to div containing results
    function addSlide(clickDiv, slideDiv) {
   
        var divSlide = new Fx.Slide(slideDiv, {
            duration: 400,
            fps: 50,
            transition: Fx.Transitions.Quad
        });

        divSlide.hide();
        
        clickDiv.addEvent('click',  function(e){
            e = new Event(e);
            if (divSlide.open) {
                divSlide.slideOut();
/*                clickDiv.removeClass('collapse_box_header');
                clickDiv.addClass('expand_box_header'); */
            } else {
                divSlide.slideIn();
/*                clickDiv.removeClass('expand_box_header');
                  clickDiv.addClass('collapse_box_header'); */
            }
/*        console.log(searchFormDivCollapse);*/
            e.stop();
        });
    }
    
    /* does an ajax form submit on a text search form */
    function searchFormSubmit(theForm) {
        var prefix = theForm.get('id');
        
        var counterName   = prefix + 'result_counter';
        var counterDiv    = counterName + '_div';
        var containerName = prefix + 'result_div';
       
        $(counterName).set('html', 'Searching');
        $(counterName).addClass('ajax-loading-span');
 
        theForm.set('send', {          
            
            onRequest: function() {
                                  },
                                    
            onSuccess: function(result) {
                var resultbox = $(counterName).removeClass('ajax-loading-span');
                
                // split result
                addSlide($(counterDiv), $(containerName));
                
                var results = result.split("||", 2);

                $(counterName).set('html', results[0] + ' results');
                $(containerName).set('html', '<div class="detach_div"></div><div>'+results[1]+'</div>');
//                divDetach($(containerName).getFirst('div'));

                $(containerName).getElements('table')[0].addClass('table_medium');
                $(containerName).getElements('ul')[0].addClass('pagination'); 
                new SortingTable($(containerName).getElements('table')[0], {
                    zebra: true,
                    paginator: new PaginatingTable( 
                        $(containerName).getElements('table')[0], 
                        $(containerName).getElements('ul')[0], 
                        {
                            per_page: 100 
                        }
                                                  )
                }); 
                $(containerName).getElements('ul')[0].addClass('pagination'); 
                                          },

            onFailure: function(result) {
                var resultbox = $(counterName).removeClass('ajax-loading-span');
                $(containerName).set('html', result.responseText);
                                          }
                          });

        theForm.send();
    }

    $('text_search').addEvent('submit', function(e) {
        /* stop the bogus form submission */
        new Event(e).stop();
       
        var keyValue = this.getChildren('input[name=key]').get('value'); 
        
        /* iterate through sibling forms */
        this.getAllNext('form').each(
            function(aForm, i) {
                aForm.getChildren('input[name=key]').set('value', keyValue);
                searchFormSubmit(aForm);
            }
        );
        
/*        $('result_count').set('html', 'Searching');
          $('result_count').addClass('ajax-loading-span');
                                                                              
          this.set('send', {          
            
            onRequest: function() {
                                  },
                                    
            onSuccess: function(result) {
                var resultbox = $('result_count').removeClass('ajax-loading-span');
                
                // split result
                addSlide($('result_counter_div'), $('result_container'));
                
                var results = result.split("||", 2);

                $('result_count').set('html', results[0] + ' results');
                $('result_container').set('html', results[1]);

                $('result_container').getElements('table')[0].addClass('table_medium');
                $('result_container').getElements('ul')[0].addClass('pagination'); 
                new SortingTable($('result_container').getElements('table')[0], {
                    zebra: true,
                    paginator: new PaginatingTable( 
                        $('result_container').getElements('table')[0], 
                        $('result_container').getElements('ul')[0], 
                        {
                            per_page: 10 
                        }
                                                  )
                }); 
                $('result_container').getElements('ul')[0].addClass('pagination'); 
                                          },

            onFailure: function(result) {
                var resultbox = $('result_count').removeClass('ajax-loading-span');
                $('result_container').set('html', result.responseText);
                                          }
                          });

        this.send();
        */

    });



   
</script>
</body>
</html>
