#!/usr/bin/perl


use CGI::Carp('fatalsToBrowser');
use CGI qw/:standard/;
use Mail::Mailer qw(sendmail);
use HTML::Template;


my $doc_path = $ENV{"DOCUMENT_ROOT"};

#open(HTML_INC_HEADER, "<$doc_path/inc/sol_header.html"); 
#open(HTML_INC_NAVBAR, "<$doc_path/inc/sol_navbar.html"); 

#my @html_inc_header = <HTML_INC_HEADER>;
#my @html_inc_navbar = <HTML_INC_NAVBAR>;
#my $html_inc_header = join("\n", @html_inc_header);
#my $html_inc_navbar = join("\n", @html_inc_navbar);

#close(HTML_INC_HEADER);
#close(HTML_INC_NAVBAR);

my $cgi = new CGI;

my $email = param("email");
my $name = param("name");
my $comments = param("comments");
my $to = "sgr\@plantbiology.msu.edu";
my $subject = "Solanaceae Genomics Resource website comment from $name";
my $timestamp = localtime(time);

chomp $email;
chomp $name;
chomp $comments;

# check incoming form data for validity
if (! isValidForm($email) || ! isValidForm($name) || !isValidText($comments)) {

    my $tmpl = HTML::Template->new(filename => "sol_comments_err.tmpl");
    
    #   $tmpl->param("header" => $html_inc_header);
    #   $tmpl->param("navbar" => $html_inc_navbar);
    
    print $cgi->header;
    print $tmpl->output;
}

# success
else {

    my $mailer = new Mail::Mailer;

    my $subject = "Solanaceae Genomics Resource website comment from $name";
    my $timestamp = localtime(time);

    $mailer->open({
	To => $to,
	From => $email,
	Subject => $subject
    });

    print $mailer "On $timestamp -- $name ($email) from the Solanaceae Genomics Resource project website wrote:\n\n";
    print $mailer "$comments";
    close $mailer;

    my $tmpl = HTML::Template->new(filename => "sol_comments_ok.tmpl");

#    $tmpl->param("header" => $html_inc_header);
#    $tmpl->param("navbar" => $html_inc_navbar);

    print $cgi->header;
    print $tmpl->output;
}

sub isValidForm {

    my $MAX_LEN = 100;    
    my ($val) = @_; 
        
    # form data must be proper length
    if (length($val) == 0 || length($val > $MAX_LEN)) {
    
        return 0;
    }
    
    # form data must not have invalid chars
    elsif ($val =~ m/[\!\#\`\~\%\^\&\|\\\/\<\>\+\=\"\:\;\{\}\[\]\?\t\n]/) {
    
        return 0;
    }
   
    return 1;
}

sub isValidText {

    my $MAX_LEN = 500;    
    my ($val) = @_; 
        
    # form data must be proper length
    if (length($val) == 0 || length($val > $MAX_LEN)) {
    
        return 0;
    }
    
    elsif ($val =~ /<a|<a/) {
        
        return 0;
    }
    
    return 1;
}



