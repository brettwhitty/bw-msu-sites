#!/usr/bin/perl

use strict;
use warnings;

use CGI qw{ :standard };
use CGI::Carp('fatalsToBrowser');
use DBI;

## See '[BW_MSU_CODE]/solcomp/solcomp_mailer.pl' script that handles
## sending out the verification notice emails related to this script

my $dbh = DBI->connect("dbi:Pg:dbname=solcomp_mail;host=pg", $ENV{'DB_USER'}, $ENV{'DB_PASS'});

my $cgi = new CGI;

my $id      = $cgi->param('id');
my $address = $cgi->param('addr');

my $remote_host = $cgi->remote_host();

print $cgi->header();

my $sth;

if ($address) {
    ## if an address is provided, we need to add it to the DB
    $sth = $dbh->prepare('insert into mail (address) values ( ? )');
    $sth->execute($address);
    print "<p>Thanks for your interest in the Solanaceae Genomics Resource. You should receive a confirmation email at '$address' within 24 hours. Please access the link it contains to confirm your subscription.</p>";

} elsif ($id) {
    ## else it's somebody verifying their subscription
    $sth = $dbh->prepare('select * from mail where hash = ?');
    $sth->execute($id);
    my $row = $sth->fetchrow_hashref();
    if ($row) {
        $sth = $dbh->prepare('update mail set verified = true where hash = ?');
        $sth->execute($id);
        print "<p>Successfully confirmed subscription of '".$row->{'address'}."' to the Solanaceae Genomics Resource mailing list.</p>";
    } else {
        print "<p>Could not verify requested email address.</p>";
    }
} else {
    print "Invalid page access.";
    exit(1);
}
