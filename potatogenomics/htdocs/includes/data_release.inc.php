<?php
    require_once('data_release.html');
    if (! isset($_GET['name']) || $_GET['name'] == '' || $_GET['name'] == 'undefined') {
        exit;
    }
?>
<br />
<p>
<div style='width: 450px; margin: 0 auto;'>
    <div style='float: left'>
        <form action='file_download.php' method='get'>
            <input type='submit' id='accept' value='Yes, I agree to these terms' />
            <input type='hidden' name='name' value='<?php echo $_GET['name']; ?>' />
        </form>
    </div>
    <div style='float: right'>
        <form action='index.php' method='get'>
            <input type='submit' id='decline' value='No, I do not agree to these terms' />
        </form>
    </div>
</div>
</p>
<script type='text/javascript'>
window.addEvent('domready', function() {
    $('accept').disabled=1;
    new Element('img', {
            'id':       'wait_spin',
            'src':      'images/spinner.gif',
            'style':    'vertical-align: text-top'
     }).inject($('accept'), 'after');

    $('accept').addEvents({
        'enable': function(el, img) {
            el.disabled=0;
            img.destroy();
        }
    });
    $('decline').addEvent('click', function(e) {
        new Event(e).stop();
        MochaUI.closeWindow($('agreement_window'));
    });
    $('accept').fireEvent('enable', [$('accept'), $('wait_spin')], 20000);
});
</script>
