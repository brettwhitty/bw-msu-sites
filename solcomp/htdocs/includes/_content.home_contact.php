  <h2>How to Contact Us</h2>
  <h3>Send an Email</h3>
            <p>Comments/Questions can be sent to the Solanaceae Genomics Resource team at <a href='mailto:sgr@plantbiology.msu.edu'>sgr@plantbiology.msu.edu</a>.
            </p>

<div class='recaptcha'>
<p>Please complete the following captcha before subscribing to the mailing list or submitting comments:</p>
<?php
    //require recaptcha for form submissions
    require_once('php-lib/recaptcha-php-1.10/recaptchalib.php');

    $publickey = 'PUBLIC_KEY_REMOVED';

    echo recaptcha_get_html($publickey, '');
?>
</div>

  <h3>Subscribe to the Solanaceae Genomics Resource Mailing List</h3>
        <p>To receive project data release notices from the Solanaceae Genomics Resource, submit your email address using the fields below. You will receive a follow-up email containing an URL to confirm your registration.

        <div id='mailingListFormDiv'>
            <form id='mailingListForm' name='mailing_list_form' action='/cgi-bin/contact/mailing_list.cgi'>
                Email: <input id='ml_email' type='text' name='addr' size='30'>
                Confirm: <input id='ml_email_confirm' type='text' name='addr_match' size='30'>
            <input type='submit' value='Submit'>
            <input type='reset' value='Clear'>
            </form>
        </div>
        <div id='mailingListFormResult'>
        </div>
        
    <h3>Use the Comments Form</h3>
    <p>Comments or questions concerning the Solanaceae Genomics Resource project may be sent using the text box provided below. Be sure to include a valid reply email address so that a response may be delivered.
            </p>
        <div id="feedbackFormDiv" class="feedbackForm">
        <fieldset>
          <form id="feedbackForm" action='/cgi-bin/contact/sol_comments.pl' method='post'>
          Name &nbsp;&nbsp; <input type='text' name='name' size='20'>
          <br/>
          <br/>
          Email &nbsp;&nbsp; <input type='text' name='email' size='20'>
          <br/>
          <br/>
          <textarea name='comments' rows='8' cols='60'></textarea>
          <br/>
          <br/>
          <input type='submit' value='Submit'>&nbsp;&nbsp;
          <input type='reset' value='Clear'>
          </form>
        </fieldset>
        </div>
        <div id="feedbackFormResult">
        </div>
        <script src="/js/info_contact.js" type="text/javascript"></script>
