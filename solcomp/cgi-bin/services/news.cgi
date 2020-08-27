#!/usr/bin/perl

use strict;
use warnings;

## skeleton of script to generate an RSS feed for news on the SGR site
## backend will be a database, or some other form of storage

use XML::RSS;
use POSIX qw(strftime);
use CGI;
use CGI::Carp;

## generate a pubdate of now
my $now = time();
my $tz = strftime("%z", localtime($now));
$tz =~ s/(\d{2})(\d{2})/$1:$2/;
my $pubdate = strftime("%a, %d %b %Y %H:%M:%S %z", localtime($now));

my $cgi = new CGI;
print $cgi->header('application/rss+xml');

# create an RSS 2.0 file
my $rss = XML::RSS->new (version => '2.0');

## use datetime to generate timestamp and store in news database eventually, then convert to
## proper timestamp when reading in in this script and generating the RSS XML 
#my $now = DateTime->now();
#my $fmt = new DateTime::Format::RSS();
#my $dt  = $fmt->parse_datetime($now);
#my $pubdate = $fmt->format_datetime($dt);

$rss->channel(
               title          => 'Solanaceae Genomics Resource',
               link           => 'http://solanaceae.plantbiology.msu.edu',
               language       => 'en',
               description    => 'Genomics web portal for the Solanaceae community',
               pubDate        => $pubdate,
               managingEditor => 'sgr@plantbiology.msu.edu',
               webMaster      => 'sgr@plantbiology.msu.edu',
);

$rss->image(title       => 'Solanaceae Genomics Resource',
             url         => 'http://solcomp/images/sol_logo.png',
             link        => 'http://solanaceae.plantbiology.msu.edu',
             width       => 500,
             height      => 49,
             description => 'Solanaceae Genomics Resource'
);
 $rss->add_item(title => "Major Site Update",
        # creates a guid field with permaLink=true
        permaLink  => "http://solcomp/home/news#test",
        description => 'Release 4 of the Solanaceae Genomics Resource site. Many new things.',
);
 
$rss->textinput(
    title => "SGR Site Search",
    description => "Use the text input below to search the Solanaceae Genomics Resource",
    name  => "query",
    link  => "http://solanaceae.plantbiology.msu.edu/search",
);

# print the RSS as a string
print $rss->as_string;

# or save it to a file
$rss->save("rss_news.rdf");
