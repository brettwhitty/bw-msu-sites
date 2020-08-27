var DefaultText = new Class({
    //implements
    Implements: [Options],

    //options
    options: {
        collection: $$('input[type=text]')
    },

    //initialization
    initialize: function(options) {
        //set options
        this.setOptions(options);
        this.defaults();
    },

    //a method that does whatever you want
    defaults: function() {
        this.options.collection.each(function(el) {
            el.set('value', el.get('rel'));
            el.addEvent('focus', function() {
                if (el.get('value') == el.get('rel')) {
                    el.set('value', '');
                }
            });
            el.addEvent('blur', function() {
                if (el.get('value') == '') {
                    el.set('value', el.get('rel'));
                }
            });
        });
    }

});

/*
window.addEvent('domready', function() {
    var defs = new dwDefaults({
        collection: $$('input.defs')
    });
});
*/
