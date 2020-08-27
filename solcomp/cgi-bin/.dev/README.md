## Development scripts

### SolHTML.pm

A Perl module with 'head' and 'header' HTML content for use in skinning GBrowse. (Not actually used.)


### blank\_to\_header\_footer.pl

This script takes as input a PHP/HTML template file from the SGR site (eg: HTML source of the rendered home page) and a GBrowse config file.

It with grab all HTML from the beginning of the file up to an HTML comment: 
    
    <!-- EndOfHeader -->

...which delimits the end of the "header" elements of the page.

It will parse this and use in the GBrowse conf as follows:

    ^<head>(.*)</head>(.*)$
    
    head = $1
    header = $2
    

And for the "footer" it will begin from a comment:

    <!-- StartOfFooter -->

...and continue until it reaches a '/body' tag.

This will be used in the GBrowse conf as follows:

    ^(.*)$

    footer = $1

Example execution:

    ./blank_to_header_footer.pl ./blank.php ../gbrowse.conf/arabidopsis.conf > arabidopsis.updated.conf

