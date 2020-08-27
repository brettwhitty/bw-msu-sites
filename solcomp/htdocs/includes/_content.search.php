     <div class='omni_search' id='omni_search_div'>
        <form id='search_form' action='search.php' method='get'>
        <div>
            Search database by <input type='radio' name='search_type' id='annotation_search_flag' value='annotation' checked> Annotation Keyword
            <input type='radio' name='search_type' id='id_search_flag' value='id'> Accession
        </div>
        <div>
            <input id='search_keyword' class='ot' name='key' type='text' size='40' alt='Select search type and enter key(s)...'>
            <input id='go' class='button' value='' type='submit' alt='Go' src='/images/go_button.gif'>
        </div>
        </form>
    </div>
    <div id='omni_search_results'></div>
    <script type='text/javascript' src='/js/search.js'></script>
    <script type='text/javascript' src='/js/lib/paginating_table.js'></script>
    <!--    <script type='text/javascript' src='/js/CollapseDiv.js'></script> -->
    <script type='text/javascript'>
        var searchHash = new Hash();

        function handleSearch() {
            var resultDiv = 'omni_search_results';
            searchHash.set('key', $('search_keyword').value);
            if (searchHash.get('key').length < 3) {
                window.alert('Please enter a suitable keyword');
                return false;
            }
            if ($('annotation_search_flag').checked) {
                doFunctionSearch(resultDiv, searchHash);
            } else {
                doIdSearch(resultDiv, searchHash);
            }
        }
    /* do search on form submit */
        $('search_form').addEvent('submit', function(e) {
             e = new Event(e); 
             e.stop();

            handleSearch();
        });
    /* reload the search results if the field is already set */
        window.addEvent('domready', function() {
            if ($('search_keyword').value.length > 0) {
                handleSearch();
            }
        });
    </script>
