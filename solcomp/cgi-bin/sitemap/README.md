# /cgi-bin/sitemap

## Using 'sitemap.xml' for dynamic content and endpoints:

### sitemap.xml
The file **'sitemap.xml'** defines the valid endpoints of site resources, and allows dynamic generation of menus and other content based on its contents.

#### Dynamic Menus, Breadcrumbs, etc.

This design allowed new site resources to be easily created within the existing page hierarchy by modifying 'sitemap.xml' and creating a PHP include file with a name that reflects the new page's endpoint, eg:
    
    <!-- in 'sitemap.xml' -->
    <page name="My New Tool" title="My New Tool" src="/tools/new_tool">
      <![CDATA[
        <p>...HTML description of tool...</p>
      ]]>
    </page>

And the new page's content here:

    htdocs/includes/_content.tools_new_tool.php

Pages can also be hidden from the site's navigation rendering by adding attribute 'hidden=1' on the 'page' element in 'sitemap.xml'.

#### Dynamic Species Pages Based on Database Contents

The 'sitemap.xml' file has an XML external entity dependency on '**includes/species_xml.inc.php**', which creates endpoint mappings for species-specific site resources based on the current database contents.

Having the species endpoint mappings dynamically generated allowed for immediate release of sequence data from newly available Solanaceae species through the taxon ID-specific "Species Overview" page, only requiring that the data be loaded to the site's database. 

See usage in '**htdocs/includes/head.inc.php**'.

