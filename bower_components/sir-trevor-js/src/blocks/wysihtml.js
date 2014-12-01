"use strict";

/*
 Wysihtml Editor Block
 Make sure you initialize(loaded) following dependencies in your system to make this block work:
 bootstrap, bootstrap3-wysihtml5-bower, fontawesome
 */

/*
 Text Block
 */

var Block = require('../block');
var stToHTML = require('../to-html');
var timeStamp = null;

module.exports = Block.extend({

    type: "wysihtml",

    title: function() { return 'wysihtml'; },

    editorHTML: function() {
        timeStamp = Date.now();
        return '<div id="wysihtml-editor-' + timeStamp + '" class="st-required st-text-block" contenteditable="true"></div>';
    },

    icon_name: 'text',

    onBlockRender : function () {
        $('#wysihtml-editor-' + timeStamp).wysihtml5();
    },

    loadData: function(data){
        this.getTextBlock().html(stToHTML(data.text, this.type));
    }
});
