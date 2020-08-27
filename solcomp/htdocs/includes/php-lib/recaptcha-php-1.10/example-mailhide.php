<html><body>
<?
require_once ("recaptchalib.php");

// get a key at http://mailhide.recaptcha.net/apikey
$mailhide_pubkey = '6Lf4-wUAAAAAAIN-RM4Bs7T_arBafgFXJBO4I5mo';
$mailhide_privkey = '6Lf4-wUAAAAAAJbedoQ8-XrOIoCA70_3w4MhVcz1';

?>

The Mailhide version of example@example.com is
<? echo recaptcha_mailhide_html ($mailhide_pubkey, $mailhide_privkey, "sgr@plantbiology.msu.edu"); ?>. <br>

The url for the email is:
<? echo recaptcha_mailhide_url ($mailhide_pubkey, $mailhide_privkey, "sgr@plantbiology.msu.edu"); ?> <br>

</body></html>
