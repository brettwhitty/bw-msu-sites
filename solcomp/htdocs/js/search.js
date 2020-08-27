/* 

    Functions used for Solanaceae Comparative Genomics Resource site search form

    Requires

        sorting_table.js
        paginating_table.js

    Brett Whitty
    whitty@msu.edu

*/

function doIdSearch( resultDiv, opts ) {

        /* create a new option hash */
        var optHash = new Hash(opts);

        /* add json flag to option hash */
        optHash.set('json', '1');

        /* wipe out the contents of the results div */
        $(resultDiv).set('html', '');
        /* add the loading style */
        $(resultDiv).addClass('ajax-loading');
    
    new Request.HTML({
        evalScripts:    false,
        evalResponse:   false,
        url:            '/cgi-bin/search/id.cgi?' + optHash.toQueryString(),
        onSuccess:      function (responseTree, responseElements, responseHTML, responseJavaScript) {
            $(resultDiv).removeClass('ajax-loading');
            var results = JSON.decode(responseHTML);
            createIdTable(resultDiv, results);
        },
        onFailure:      function(responseTree, responseElements, responseHTML, responseJavaScript) {
            $(resultDiv).removeClass('ajax-loading');
            new Element('p', { html: 'An error occurred while searching.' }).inject(resultDiv);
        }
/*      update:     thisDiv.contentDiv */
    }).get();
}

function doFunctionSearch( resultDiv, opts ) {

    /* create a new option hash */
    var optHash = new Hash(opts);

    /* add json flag to option hash */
    optHash.set('json', '1');

    /* wipe out the contents of the results div */
    $(resultDiv).set('html', '');
    /* add the loading style */
    $(resultDiv).addClass('ajax-loading');

    /* do the search */
    new Request.HTML({
        evalScripts:    false,
        evalResponse:   false,
        url:            '/cgi-bin/search/annotation.cgi?' + optHash.toQueryString(),
        onSuccess:      function (responseTree, responseElements, responseHTML, responseJavaScript) {
            $(resultDiv).removeClass('ajax-loading');
            var results = JSON.decode(responseHTML);
            createFunctionTable( resultDiv, results);
        },
        onFailure:      function(responseTree, responseElements, responseHTML, responseJavaScript) {
            $(resultDiv).removeClass('ajax-loading');
            new Element('p', { html: 'An error occurred while searching.' }).inject(resultDiv);
        }
/*      update:     thisDiv.contentDiv */
    }).get();
}

/* creates a table populated with the results of an ID search */
function createIdTable(containerDiv, results) {

        /* check if any results were returned by the search */
        if (results === null) {
            new Element('p', { html: 'Search returned no result.' }).inject(containerDiv);
            return false;
        }

        var maxResults = 1000; /* display a message about limited results */
        var resultCount = results.length;

        /* create a new table to contain results */
        var newTable = new Element('table', {
            'id':       'result_table',
            'html':     '',
            'class':    '',
            'title':    ''
        });

        /* add the table to the container div */
        newTable.inject($(containerDiv));

        /* create a THEAD element and add to the table */
        var newTHead = new Element('thead', {});
        newTHead.inject(newTable);

        /* add a header row */
        var newHead = new Element('tr', {
            'id':       '',
            'html':     '',
            'class':    '',
            'title':    ''
        });
        newHead.inject(newTHead);

        /* add headings */
        new Element( 'th',
            {
                'html':     'Source'
            }
        ).inject(newHead);
        new Element( 'th',
            {
                'html':     'Accession'
            }
        ).inject(newHead);

        /* create and add TBODY element */
        var newTBody = new Element('tbody', {});
        newTBody.inject(newTable);

        /* iterate through results adding rows for each */
        $each( results,
            function (r, i) {
                /* create and add a row */
                var newRow = new Element('tr',
                    {
                        'id':       '',
                        'html':     '',
                        'class':    '',
                        'title':    ''
                    }
                );
                newRow.inject(newTBody);

                /* create and add cells to the row */
                new Element( 'td',
                    {
                        'html':     r['db_name'] /* source database of search result */
                    }
                ).inject(newRow);

                new Element( 'td',
                    {
                        'html':     r['id']     /* accession of search result */
                    }
                ).inject(newRow);
            }
        );

        /* results have been capped at the database query level so if search hit the max let the user know */
        if (resultCount >= maxResults) {
            new Element('p',
                {
                    html:   'Your search returned the maximum of <strong>' + maxResults + '</strong> results. You may wish to search again using more specific search terms.'
                }
            ).inject(newTable, 'after');
        }

        return true;
    }


/* creates a table populated with the results of a function keyword search */
function createFunctionTable(containerDiv, results) {
        
    /* check if any results were returned by the search */
    if (results === null) {
        new Element('p', { html: 'Search returned no result.' }).inject(containerDiv);
        return false;
    }

    var maxResults = 1000; /* display a message about limited results */
    var resultCount = results.length;

    var newTable = new Element('table', {
        'id':       'result_table',
        'html':     '',
        'class':    'table_medium',
        'title':    ''
    });
    
    newTable.inject($(containerDiv));

    var newTHead = new Element('thead', {});
    newTHead.inject(newTable);

    var newHead = new Element('tr', {
        'id':       '',
        'html':     '',
        'class':    '',
        'title':    ''
    });
    newHead.inject(newTHead);

    new Element( 'th', {
        'html':     'Source'
    }).inject(newHead);

    new Element( 'th', {
         'html':     'Accession'
    }).inject(newHead);
     
    new Element( 'th', {
        'html':     'Annotation Text'
    }).inject(newHead);

    var newTBody = new Element('tbody', {});
    newTBody.inject(newTable);

    $each( results, function (r, i) {

        var newRow = new Element('tr', {
            'id':       '',
            'html':     '',
            'class':    '',
            'title':    ''
        });
        newRow.inject(newTBody);

        new Element( 'td', {
            'html':     r['db_name']
        }).inject(newRow);
        new Element( 'td', {
            'html':     r['id']
        }).inject(newRow);
        new Element( 'td', {
            'html':     r['html']
        }).inject(newRow);
    });
     
    var newTCaption = new Element('caption', {
        align: 'top'
    });
    
    var newUl = new Element('ul', {
        'id':     'result_table_pagination',
        'class':  'pagination',
        'align':  'top'
    });
    newUl.inject(newTCaption);
    newTCaption.inject(newTable, 'top');

    new SortingTable( newTable, {
        paginator: new PaginatingTable( newTable, newUl, { per_page: 25 } )
    });

    if (resultCount >= maxResults) {
        new Element('p', {
                    html:   'Your search returned the maximum of <strong>' 
                            + maxResults
                            + '</strong> results. You may wish to search again using more specific search terms.'
        }).inject(newTable, 'after');
    }

    newTable.setStyle('width', '100%');

    return true;
}
