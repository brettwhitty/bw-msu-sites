/*
 *
 * SeqCart Class
 *
 * A shopping cart for fasta sequence files using HTML5 client-side database
 *
 * requires:
 *      Mootools 1.2
 *      jStorage
 *
 * Brett Whitty
 * whitty@msu.edu
 *           
 */

var SeqCart = new Class({
    Implements:     [Options, Events],
    options:    {
        dbPrefix: 'seqCart',    //prefix for the db item keys
        validate: false         //validate the sequences before adding
    },
    initialize: function(options) {
        this.setOptions(options);
        this.readIndex();
    },
    idx: '',
    readIndex: function() {
        var json = $.jStorage.get(this.dbPrefix + 'Index', '');
        if (json == '') {
            this.idx = new Array();
        } else {
            this.idx = JSON.decode(json);
        }
    },
    writeIndex: function() {
        $.jStorage.set(this.dbPrefix + 'Index', JSON.encode(this.idx));
    },
    add: function (e) {
        //this.idx.include(JSON.encode(e));
        this.idx.include(e);
        this.writeIndex();
    },
    get: function(i) {
        return this.idx[i];
    }
});
