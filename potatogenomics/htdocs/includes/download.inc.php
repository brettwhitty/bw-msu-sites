        <script type="text/javascript">
            MochaUI.agreementWindow = function(fname){
                new MochaUI.Window({
                    id: 'agreement_window',
                    title: 'Potato Whole Genome Sequence Data Access Agreement',
                    loadMethod: 'xhr',
                    evalScripts: true,
                    contentURL: 'data_release.inc.php?name=' + fname,
                    type: 'modal',
                    width: 700,
                    height: 400,
                    contentBgColor: '#ffffff',
                    padding: { top: 10, right: 10, bottom: 10, left: 10 },
                    scrollbars:  false
                });
            };
            window.addEvent('domready', function(){
                MochaUI.Modal = new MochaUI.Modal();

                $('fileLink').addEvent('click', function(e){
                    new Event(e).stop();
                    MochaUI.agreementWindow($('fileLink').get('text'));
                });
                $('agreementLink').addEvent('click', function(e){
                    new Event(e).stop();
                    MochaUI.agreementWindow();
                });

            });
        </script>
    <h3>Public Data</h3>
    <p>The following datasets represent project data that has been released to public databases, and are freely available
    for public use without restrictions.
    <ul class='files'>
    <?php
        $public_files = array(
            'Solanum_tuberosum.RHPOTKEY.bacs.fsa.bz2',
            'Solanum_tuberosum.RHPOTKEY.bac_ends.fsa.bz2',
            'Solanum_phureja.DM.bac_ends.fsa.bz2',
            'Solanum_phureja.DM.fosmid_ends.fsa.bz2'
        );
        foreach ($public_files as $file) {
            echo "<li><a href='file_download.php?name=$file'>$file</a></li>";
        }
    ?>
    </ul>
    <h3>Restricted Data</h3>
    <p>The following datasets have not yet been released to public databases, and are being made available to end users
    under the terms of the <a href='index.php?p=agreement' id='agreementLink'>Potato Whole Genome Sequence Data Access agreement</a>.</p>
    <ul class='files'>
     <?php
        $private_files = array(
            'Solanum_phureja.DM.scaffolds.tar.bz2'
        );
        foreach ($private_files as $file) {
            echo "<li><a id='fileLink' class='private' href='index.php?p=agreement&name=$file'>$file</a></li>";
        }
    ?>
    </ul>
    <p style='margin-top: 5px'>Please report all problems downloading files to <a href='mailto:sgr@plantbiology.msu.edu?subject=PGSC data release site comment'>sgr@plantbiology.msu.edu</a>.</p> 
