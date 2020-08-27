    <h2>Solanaceae Simple Sequence Repeats (SSR) Summary Statistics</h2>
    <p>

    <div id='ssr_summary_div'>
        Retrieving statistics from the database...<br/>
    </div>
    
    <script type='text/javascript'>
      window.addEvent('domready', function() {
        
            var req = new Request({  
                method: 'get',  
                url: '/includes/analyses_ssr_summary_table.php',  
                onRequest: function() {
                $('ssr_summary_div').addClass('ajax-loading');
                                      },  
                onSuccess: function(result) {
                    $('ssr_summary_div').removeClass('ajax-loading');
                    $('ssr_summary_div').set('html', result);
                    new SortingTable('ssr_summary', {zebra: true});
                                            },
                onFailure: function(result) {
                    $('ssr_summary_div').removeClass('ajax-loading');
                    $('ssr_summary_div').set('html', result.responseText);
                                            }
            }).send();  
            
       });
    </script>
        
  </p>
