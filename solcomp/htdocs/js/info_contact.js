var feedbackFormEffect = new Fx.Slide($('feedbackFormDiv'), {
    duration: 500,
    fps: 50
});

var feedbackFormResultEffect = new Fx.Slide($('feedbackFormResult'), {
    duration: 500,
    fps: 50
});

var mailingListFormEffect = new Fx.Slide($('mailingListFormDiv'), {
    duration: 500,
    fps: 50
});
var mailingListFormResultEffect = new Fx.Slide($('mailingListFormResult'), {
    duration: 500,
    fps: 50
});

window.addEvent('domready', function() {

    $('mailingListForm').addEvent('submit', function(event) {

        event.stop();

        $('mailingListFormResult').empty().addClass('ajax-loading');

        var thisObj = this;

        if ($('ml_email').get('value') != $('ml_email_confirm').get('value')) {
                    Recaptcha.reload();
                    $('mailingListFormResult').removeClass('ajax-loading');
                    $('mailingListFormResult').addClass('notice_box');
                    $('mailingListFormResult').addClass('nb_green');
                    $('mailingListFormResult').set('html',
                        '<p>You have failed to correctly enter your email address twice in the fields above.</p>'
                    );
                    mailingListFormResultEffect.slideIn();
                    mailingListFormEffect.slideIn.delay(5000, mailingListFormEffect);
                    mailingListFormResultEffect.slideOut.delay(6000, mailingListFormResultEffect);
            return false;
        }
        if (! $('ml_email').get('value').match(/^[^@]+@.+\..+/)) {
                    Recaptcha.reload();
                    $('mailingListFormResult').removeClass('ajax-loading');
                    $('mailingListFormResult').addClass('notice_box');
                    $('mailingListFormResult').addClass('nb_green');
                    $('mailingListFormResult').set('html',
                        '<p>It appears that you have not entered a valid email address.</p>'
                    );
                    mailingListFormResultEffect.slideIn();
                    mailingListFormEffect.slideIn.delay(5000, mailingListFormEffect);
                    mailingListFormResultEffect.slideOut.delay(6000, mailingListFormResultEffect);
            return false;
        }
        this.set('send', {
                        onSuccess: function(req) {
                            $('mailingListFormResult').removeClass('ajax-loading');
                            mailingListFormEffect.slideOut();
                            $('mailingListFormResult').addClass('notice_box');
                            $('mailingListFormResult').addClass('nb_green');
                            $('mailingListFormResult').set('html', req);
                            mailingListFormResultEffect.slideIn();
                            if (req.match('Error')) {
                                Recaptcha.reload();
                                mailingListFormEffect.slideIn.delay(5000, mailingListFormEffect);
                                mailingListFormResultEffect.slideOut.delay(6000, mailingListFormResultEffect);
                            }
                                                   },
                        onFailure: function(req) {
                            Recaptcha.reload();
                            $('mailingListFormResult').removeClass('ajax-loading');
                            $('mailingListFormResult').addClass('notice_box');
                            $('mailingListFormResult').addClass('nb_green');
                            $('mailingListFormResult').set('html', req.responseText);
                            mailingListFormResultEffect.slideIn();
                            mailingListFormEffect.slideIn.delay(5000, mailingListFormEffect);
                            mailingListFormResultEffect.slideOut.delay(6000, mailingListFormResultEffect);
                                                   }
        });

        var captchaCheck = new Request.HTML({
            url:    'includes/recaptcha_check.php',
            onSuccess:  function(responseTree, responseElements, responseHTML, responseJavaScript) {
                if (responseHTML == 'CORRECT') {
                    Recaptcha.reload();
                    thisObj.send();
                } else {
                    Recaptcha.reload();
                    $('mailingListFormResult').removeClass('ajax-loading');
                    $('mailingListFormResult').addClass('notice_box');
                    $('mailingListFormResult').addClass('nb_green');
                    $('mailingListFormResult').set('html', responseHTML);
                    mailingListFormResultEffect.slideIn();
                    mailingListFormEffect.slideIn.delay(5000, mailingListFormEffect);
                    mailingListFormResultEffect.slideOut.delay(6000, mailingListFormResultEffect);
                }
            }
        });
        captchaCheck.post({
            'recaptcha_challenge_field': $('recaptcha_challenge_field').get('value'),
            'recaptcha_response_field':  $('recaptcha_response_field').get('value')
        });
   });


   $('ml_email').addEvent('change', function(event) {
        if ($('ml_email').get('value') == '') {
             $('ml_email_confirm').set('value', '');
             $('ml_email').setStyle('background-color', '');
             $('ml_email_confirm').setStyle('background-color', '');
        } else if ($('ml_email_confirm').get('value') == '') {
             $('ml_email_confirm').setStyle('background-color', '#FFDFDF');
             $('ml_email_confirm').setStyle('background-color', '#FFDFDF');
        } else if ($('ml_email').get('value') != $('ml_email_confirm').get('value')) {
             $('ml_email').setStyle('background-color', '#FFDFDF');
             $('ml_email_confirm').setStyle('background-color', '#FFDFDF');
        } else {
             $('ml_email').setStyle('background-color', '#DFFFDF');
             $('ml_email_confirm').setStyle('background-color', '#DFFFDF');
        }
   });


   $('ml_email_confirm').addEvent('change', function(event) {
        if ($('ml_email').get('value') != $('ml_email_confirm').get('value')) {
             $('ml_email').setStyle('background-color', '#FFDFDF');
             $('ml_email_confirm').setStyle('background-color', '#FFDFDF');
        } else {
             $('ml_email').setStyle('background-color', '#DFFFDF');
             $('ml_email_confirm').setStyle('background-color', '#DFFFDF');
        }
   });
   $('feedbackForm').addEvent('submit', function(event) {

        event.stop();

        $('feedbackFormResult').empty().addClass('ajax-loading');

        var thisObj = this;

        this.set('send', {
                        onSuccess: function(req) {
                            $('feedbackFormResult').removeClass('ajax-loading');
                            feedbackFormEffect.slideOut();
                            $('feedbackFormResult').addClass('notice_box');
                            $('feedbackFormResult').addClass('nb_green');
                            $('feedbackFormResult').set('html', req);
                            feedbackFormResultEffect.slideIn();
                            if (req.match('Error')) {
                                Recaptcha.reload();
                                feedbackFormEffect.slideIn.delay(5000, feedbackFormEffect);
                                feedbackFormResultEffect.slideOut.delay(6000, feedbackFormResultEffect);
                            }
                                                   },
                        onFailure: function(req) {
                            Recaptcha.reload();
                            $('feedbackFormResult').removeClass('ajax-loading');
                            $('feedbackFormResult').addClass('notice_box');
                            $('feedbackFormResult').addClass('nb_green');
                            $('feedbackFormResult').set('html', req.responseText);
                            feedbackFormResultEffect.slideIn();
                            feedbackFormEffect.slideIn.delay(5000, feedbackFormEffect);
                            feedbackFormResultEffect.slideOut.delay(6000, feedbackFormResultEffect);
                                                   }
                          });

        //var captchaCheck = new Request.HTML({url:'includes/recaptcha_check.php'});
        var captchaCheck = new Request.HTML({
            url:    'includes/recaptcha_check.php',
            onSuccess:  function(responseTree, responseElements, responseHTML, responseJavaScript) {
                if (responseHTML == 'CORRECT') {
                    Recaptcha.reload();
                    thisObj.send();
                } else {
                    Recaptcha.reload();
                    $('feedbackFormResult').removeClass('ajax-loading');
                    $('feedbackFormResult').addClass('notice_box');
                    $('feedbackFormResult').addClass('nb_green');
                    $('feedbackFormResult').set('html', responseHTML);
                    feedbackFormResultEffect.slideIn();
                    feedbackFormEffect.slideIn.delay(5000, feedbackFormEffect);
                    feedbackFormResultEffect.slideOut.delay(6000, feedbackFormResultEffect);
                }
            }
        });
        captchaCheck.post({
            'recaptcha_challenge_field': $('recaptcha_challenge_field').get('value'),
            'recaptcha_response_field':  $('recaptcha_response_field').get('value')
        });

    });
});
