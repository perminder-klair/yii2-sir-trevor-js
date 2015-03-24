"use strict";

/*
 Wysihtml Editor Block
 Make sure you initialize(loaded) following dependencies in your system to make this block work:
 bootstrap, bootstrap3-wysihtml5-bower, fontawesome
 */

var Block = require('../block');
var stToHTML = require('../to-html');
var timeStamp = null;

module.exports = Block.extend({

    type: "wysihtml",

    title: function() { return 'wysihtml'; },

    editorHTML: function() {
        return '<textarea id="wysihtml-editor" name="wysihtml" class="st-required st-input-string st-wysihtml-input" rows="8" style="width: 100%;"></textarea>';
    },

    icon_name: 'text',

    onBlockRender : function () {
        this.$('#wysihtml-editor').wysihtml5();
    },

    loadData: function(data){
        this.$('textarea#wysihtml-editor').val(data.wysihtml);
    }
});
