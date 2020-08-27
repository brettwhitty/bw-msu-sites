## /cgi-bin/SSR

### ssr\_db\_query.cgi

This CGI script allows searching SSR analysis results data that have been loaded to a Chado database schema.

The data was generated using the script 'ssr.pl' from Gramene:
[ftp://ftp.gramene.org/pub/gramene/archives/software/scripts/ssr.pl](ftp://ftp.gramene.org/pub/gramene/archives/software/scripts/ssr.pl)

...the results of which were converted to GFF3 format using this script:

    /gff/convert_to_gff/convert_ssr_to_gff3.pl
    
...and then loaded to a Chado DB using GMOD scripts (eg: 'gmod\_bulk\_load\_gff3.pl').

Rapid keyword searching in (PUTs) functional annotation text is supported here by a quick hack using DB\_File (updated here to BerkeleyDB::Hash to allow working example with current version of BDB). Simple utility scripts to populate the text DB ('**bin/make\_annotation\_db.pl**') and test that it's working ('**bin/test\_db.pl**') are present.

### ssr\_summary\_table.cgi

This generates a table of summary stats for the SSR analysis data present in the Chado DB.

It requires the creation of the database views 'ssr\_summary' and 'ssr\_seq\_summary' defined in '**db/views.sql**'.
