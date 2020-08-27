# cgi-bin

## ./grp

CGI scripts related to gene report page; not sure why there's only one script in here (and other 'grp_*' in root), probably an in-progress migration of scripts from the root of 'cgi-bin' into tool-based sub dirs that wasn't completed at the time this SVN checkout was created.

## ./lib

Custom Perl libraries, and other Perl module dependencies excluded from the repo (see README under this dir)

## ./SNP

CGI scripts related to the site's SNP tools.

## ./SSR

CGI scripts related to the sites SSR tools.

## ./contact

Mailing list and feedback form.

## ./gbrowse.conf

Configuration files for the site's GBrowse 2.0 genome browsers.

The various GBrowse executables and required data files were installed in the root of the 'cgi-bin' dir and have been removed from this repository.

All config files and custom modules used for "skinning" GBrowse, etc. have been left in place.

See 'GbrowseHeader.pm' under './lib'.
