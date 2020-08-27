/*

    AjaxDiv Class

    Brett Whitty
    whitty@msu.edu

    A class for creating collapsible div elements
    that load their contents via an ajax call.

    Requires mootools 1.2

    Example usage:

        <div id='test'></div>
        <div id='test2'></div>
        <script type="text/javascript">
            var divTest = new AjaxDiv('test', 'Test Header', '/cgi-bin/SNP/sol_snps.cgi?id=PUT-169a-Nicotiana_tabacum-77195', true);
            var divTest2 = new AjaxDiv('test2', 'Test Header', '/cgi-bin/orthomcl/orthomcl_view.cgi?id=PUT-157a-Solanum_tuberosum-11244', false);
        </script>

*/

    var AjaxDiv = new Class({

        Implements: [Options],

        options: {
            parentDiv:          $empty,
            headerText:         $empty,
            url:                $empty,
            startOpen:          false,
            headerOpenClass:    'ajaxdiv_open',
            headerClosedClass:  'ajaxdiv_closed',
            headerIconClass:    'ajaxdiv_header_icon',
            headerTitleClass:   'ajaxdiv_title',
            contentClass:       'ajaxdiv_content',
            loadingClass:       'ajax-loading',
            headerSuffix:       '_header',
            contentSuffix:      '_content',
            titleSuffix:        '_title',
            cookieSuffix:       '_cookie',
            enableRefresh:      true,
            enableTextDetach:   true,
            enableHTMLDetach:   true,
            helpText:           '',
            helpURL:            '',
            helpIconClass:      'ajaxdiv_help_icon',
        },

        initialize: function(options) {
            this.setOptions(options);

            this.parentDivId    = this.options.parentDiv;
            this.headerDivId    = this.parentDivId + this.options.headerSuffix;
            this.headerTitleDivId   = this.headerDivId + this.options.titleSuffix;
            this.contentDivId   = this.options.parentDiv + this.options.contentSuffix;
            this.headerText     = this.options.headerText;
            this.url            = this.options.url;
            this.startOpen      = this.options.startOpen;

            this.openFlag       = this.startOpen;

            this.headerOpenClass    = this.options.headerOpenClass;
            this.headerClosedClass  = this.options.headerClosedClass;
            this.headerIconClass    = this.options.headerIconClass;
            this.headerTitleClass   = this.options.headerTitleClass;
            this.contentClass       = this.options.contentClass;
            this.loadingClass       = this.options.loadingClass;

            this.enableRefresh      = this.options.enableRefresh;
            this.enableTextDetach   = this.options.enableTextDetach;
            this.enableHTMLDetach   = this.options.enableHTMLDetach;

            this.cookieName     = this.headerDivId + this.options.cookieSuffix;
            this.openFlagCookie = null;

            this.helpText       = this.options.helpText;
            this.helpURL        = this.options.helpURL;
            this.helpIconClass  = this.options.helpIconClass;

            /* create the header div */
            this.headerDiv = new Element('div', {
                'id':       this.headerDivId
            });
            /* create the title div */
            this.headerTitleDiv = new Element('div', {
                'id':       this.headerTitleDivId,
                'html':     this.headerText,
                'class':    this.headerTitleClass,
                'title':    'Click to open/close'
            });
            this.headerTitleDiv.inject(this.headerDiv);

            /* make header clickable */
            this.headerTitleDiv.addEvent('click', this.toggle.bind(this) );
            /* create the content div */
            this.contentDiv = new Element('div', {
                'id':       this.contentDivId,
                'class':    this.contentClass
            });

            /* reset the object to its initial state */
            this.resetState();

            /* initialize the buttons (if any) */
            this.initializeButtons();

            /* inject the header and content divs into their parent */
            this.headerDiv.inject(this.parentDivId);
            this.contentDiv.inject(this.parentDivId);
        },

        /* to toggle the div open or closed */
        toggle: function() {
            if (this.isOpen()) {
                this.close();
            } else {
                this.open();
            }
        },

        /* opens the content div */
        open: function() {
            this.initializeContent();
            this.headerDiv.set('class', this.headerOpenClass);
            this.contentDiv.setStyle('visibility', 'visible');
            this.contentDiv.setStyle('display', '');
            this.openFlag = true;

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

        /* closes the content div */
        close: function() {
            this.headerDiv.set('class', this.headerClosedClass);
            this.contentDiv.setStyle('visibility', 'hidden');
            this.contentDiv.setStyle('display', 'none');
            this.openFlag = false;

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

        /* check if the content is open */
        isOpen: function() {
            return this.openFlag;
        },

        /* reset the content to initial state */
        resetState: function() {
            /* close the div */
            /* wipe the div */
            this.contentDiv.set('html', '');
            this.openFlag = this.startOpen;

            this.openFlagCookie = Cookie.read(this.cookieName);

            /* adjust open state based on cookie */
            if (this.openFlagCookie != null) {
                if (this.openFlagCookie == 'true') {
                    this.openFlag  = true;
                } else {
                    this.openFlag  = false;
                }
            }
            /*************************************/

            /* adjust header styles based on whether we start open or closed */
            if (this.isOpen()) {
                this.open();
            } else {
                this.close();
            }

        },

        /* refresh the content */
        refresh: function() {
            if (! this.isOpen()) {
                return false;
            }
            this.contentDiv.set('html', '');
            this.initializeContent();
        },

        /* add buttons to header */
        initializeButtons: function() {

            if (this.helpText != '') {
                 /* add support for detaching text in new window */
                var newButton = this.addHeaderButton(
                    this.headerDivId + '_helpbutton',
                    '<img src="/images/help_icon.png">',
                    this.helpText,
                    this.helpIconClass
                );
                if (this.helpURL != '') {
                    /* add click event for button */
                    newButton.addEvent('click', function(){ window.location = this.helpURL; }.bind(this) );
                }
            }

            if (this.enableRefresh) {
                /* add support for refreshing content */
                var newButton = this.addHeaderButton(
                    this.headerDivId + '_refreshbutton',
                    '<img src="/images/refresh.png">',
                    'Refresh contents',
                    this.headerIconClass
                );

                /* add click event for button */
                newButton.addEvent('click', this.refresh.bind(this) );
            }

            if (this.enableHTMLDetach) {
                /* add support for detaching HTML in new window */
                var newButton = this.addHeaderButton(
                    this.headerDivId + '_htmlbutton',
                    '<img src="/images/new_window_dark.png">',
                    'Copy content HTML to new window',
                    this.headerIconClass
                );

                /* add click event for button */
                newButton.addEvent('click', this.detachHTML.bind(this) );
            }

            if (this.enableTextDetach) {
                /* add support for detaching text in new window */
                var newButton = this.addHeaderButton(
                    this.headerDivId + '_textbutton',
                    'T',
                    'Copy content text to new window',
                    this.headerIconClass
                );

                /* add click event for button */
                newButton.addEvent('click', this.detachText.bind(this) );
            }

        },

        /* get content for the content div */
        initializeContent: function() {
            if (this.contentDiv.get('html') == '') {

                this.contentDiv.addClass(this.loadingClass);

                var thisDiv = this;

                new Request.HTML({
                    evalScripts: true,
                    evalResponse: true,
                    url:        thisDiv.url,
                    onSuccess:  function(responseTree, responseElements, responseHTML, responseJavaScript) {
                        thisDiv.contentDiv.removeClass(thisDiv.loadingClass);
                    },
                    onFailure:  function(responseTree, responseElements, responseHTML, responseJavaScript) {
                        thisDiv.contentDiv.removeClass(thisDiv.loadingClass);
                    },
                    update:     thisDiv.contentDiv
                }).get();

            }
        },
        /* allow the header to be hidden --- will force open if closed */
        hideHeader: function() {
            this.headerDiv.setStyle('display', 'none');
            this.contentDiv.setStyle('border', '0');
            if (! this.isOpen()) {
                this.open();
            }
        },
        /* allow the content div HTML to be exported to a new window */
        detachHTML: function() {
            if (this.contentDiv.get('html') == '') {
                return false;
            }
            var windowHeight = this.contentDiv.offsetHeight + 100;

            if (windowHeight > 768) {
                windowHeight = 768;
            }
            var newWindow = window.open('', '_blank', 'width=1024,height='+windowHeight+',scrollbars=yes,location=no,menubar=yes,toolbar=no,titlebar=no,status=no,resizable=yes');

            newWindow.document.write('<html><head>');
            newWindow.document.write('<link href="/css/solcomp_style.css" rel="stylesheet" type="text/css" />');
            newWindow.document.write('</head><body class="oneColElsCtrHdr"><div id="container"><div id="mainContent">');

            newWindow.document.write(this.contentDiv.get('html'));
            newWindow.document.write('</div></div></body></html>');
            newWindow.document.close();

        },

        /* allow the content div text to be exported to a new window */
        detachText: function() {
            if (this.contentDiv.get('text') == '') {
                return false;
            }
            var windowHeight = this.contentDiv.offsetHeight + 100;

            if (windowHeight > 768) {
                winedowHeight = 768;
            }
            var newWindow = window.open('', '_blank', 'width=1024,height='+windowHeight+',scrollbars=yes,location=no,menubar=yes,toolbar=no,titlebar=no,status=no,resizable=yes');

            newWindow.document.open('text/plain', 'replace');
            newWindow.document.write(this.contentDiv.get('text'));
            newWindow.document.close();

        },

        addHeaderButton: function(buttonId, html, toolTip, elemClass) {

            /* add support for detaching text in new window */
            var newButton = new Element('div', {
                'id':       buttonId,
                'html':     html,
                'class':    elemClass,
                'title':    toolTip
            });
            newButton.inject(this.headerDiv);

            return newButton;
        }


    });
