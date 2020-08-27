/*

    CollapseDiv Class

    Brett Whitty
    whitty@msu.edu

    A class for making existing div elements collapsible.

    Requires mootools 1.2

    Example usage:

        <div id='test'>
            Some content
        </div>
        <script type="text/javascript">
            new CollapseDiv('test', 'Description text', true);
        </script>

*/

    var CollapseDiv = new Class({
        initialize: function(targetDivId, headerText, startOpen) {
            this.targetDivId    = targetDivId;
            this.targetDiv      = $(targetDivId);
            this.wrapperDivId   = targetDivId + '_wrapper';
            this.headerDivId    = targetDivId + '_header';
            this.cookieName     = targetDivId + '_cookie';
            this.openFlagCookie = Cookie.read(this.cookieName);

/*            this.contentDivId = targetDiv + '_content'; */
            this.headerText = headerText;
/*            this.url = url; */
            this.startOpen = startOpen;
            this.openFlag  = startOpen;

            /* adjust open state based on cookie */
            if (this.openFlagCookie != null) {
                if (this.openFlagCookie == 'true') {
                    this.startOpen  = true;
                } else {
                    this.startOpen  = false;
                }
            }
            /*************************************/

            this.wrapperDiv = new Element('div', {
                'id':       this.wrapperDivId,
                'class':    'collapsediv_wrapper'
            });
            this.wrapperDiv.injectBefore(this.targetDivId);
            this.targetDiv.injectTop(this.wrapperDivId);
            this.targetDiv.setStyle('clear', 'both');

            /* create the header div */
            this.headerDiv = new Element('div', {
                'id':       this.headerDivId
            });
            this.headerTitleDiv = new Element('div', {
                'id':       this.headerDivId + '_title',
                'html':     headerText,
                'class':    'collapsediv_title',
                'title':    'Click to show/hide contents'
            });
            this.headerTitleDiv.inject(this.headerDiv);

            /* make header clickable */
            this.headerTitleDiv.addEvent('click', this.toggle.bind(this) );

            /* add support for detaching html in new window */
            this.headerHTMLDetachDiv = new Element('div', {
                'id':       this.headerDivId + '_htmlbutton',
                'html':     '<img src="/images/new_window_dark.png">',
                'class':    'collapsediv_header_icon',
                'title':    'Copy content HTML to new window'
            });
            this.headerHTMLDetachDiv.inject(this.headerDiv);

            /* add the click event for the detachText icon */
            this.headerHTMLDetachDiv.addEvent('click', this.detachHTML.bind(this) );

            /* add support for detaching text in new window */
            this.headerTextDetachDiv = new Element('div', {
                'id':       this.headerDivId + '_textbutton',
                'html':     'T',
                'class':    'collapsediv_header_icon',
                'title':    'Copy content text to new window'
            });
            this.headerTextDetachDiv.inject(this.headerDiv);

            /* add the click event for the detachText icon */
            this.headerTextDetachDiv.addEvent('click', this.detachText.bind(this) );

            /* reset the object to its initial state */
            this.resetState();

            /* inject the header and content divs into their parent */
            this.headerDiv.injectBefore(targetDivId);
        },

        /* to toggle the div open or closed */
        toggle: function() {
            if (this.isOpen()) {
                this.close();
            } else {
                this.open();
            }

            /* write state to a cookie */
            Cookie.write(
                this.cookieName,
                this.openFlag,
                {
                    duration: 30,
                    domain: location.host,
                    path: location.pathname,
                    secure: false
                }
            );
        },

        /* opens the content div */
        open: function() {
            this.headerDiv.set('class', 'collapsediv_open');
            this.targetDiv.setStyle('visibility', 'visible');
            this.targetDiv.setStyle('display', '');
            this.openFlag = true;
        },

        /* closes the content div */
        close: function() {
            this.headerDiv.set('class', 'collapsediv_closed');
            this.targetDiv.setStyle('visibility', 'hidden');
            this.targetDiv.setStyle('display', 'none');
            this.openFlag = false;
        },

        /* check if the content is open */
        isOpen: function() {
            return this.openFlag;
        },

        /* reset the content to initial state */
        resetState: function() {
            /* close the div */
            /* wipe the div */
            this.openFlag = this.startOpen;

            /* adjust header styles based on whether we start open or closed */
            if (this.isOpen()) {
                this.open();
            } else {
                this.close();
            }
        },

        /* allow the content div HTML to be exported to a new window */
        detachHTML: function() {
            var windowHeight = this.targetDiv.offsetHeight + 100;

            if (windowHeight > 768) {
                windowHeight = 768;
            }
            var newWindow = window.open('', '_blank', 'width=1024,height='+windowHeight+',scrollbars=yes,location=no,menubar=yes,toolbar=no,titlebar=no,status=no,resizable=yes');

            newWindow.document.write('<html><head>');
            newWindow.document.write('<link href="/css/solcomp_style.css" rel="stylesheet" type="text/css" />');
            newWindow.document.write('</head><body class="oneColElsCtrHdr"><div id="container"><div id="mainContent">');

            /*
            $(divName).getElement('.detach_div').getParent().removeClass("search_result");
            $(divName).getElement('.detach_div').destroy();
            */
            
            newWindow.document.write('<div id="' + this.targetDivId + '" class="'+ this.targetDiv.get('class')+'">');
            newWindow.document.write(this.targetDiv.get('html'));
            newWindow.document.write('</div>');
            newWindow.document.write('</div></div></body></html>');
            newWindow.document.close();

            /* $(divName).set('html',''); */
        },

        /* allow the content div text to be exported to a new window */
        detachText: function() {
            var windowHeight = this.targetDiv.offsetHeight + 100;

            if (windowHeight > 768) {
                winedowHeight = 768;
            }
            var newWindow = window.open('', '_blank', 'width=1024,height='+windowHeight+',scrollbars=yes,location=no,menubar=yes,toolbar=no,titlebar=no,status=no,resizable=yes');

            /*
            $(divName).getElement('.detach_div').getParent().removeClass("search_result");
            $(divName).getElement('.detach_div').destroy();
            */
            
            newWindow.document.open('text/plain', 'replace');
            newWindow.document.write(this.targetDiv.get('text'));
            newWindow.document.close();

            /* $(divName).set('html',''); */
        }

    });
