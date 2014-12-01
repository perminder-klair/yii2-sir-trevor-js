"use strict";

/*
 Redactor Editor Block
 Make sure you initialize(loaded) following dependencies in your system to make this block work:
 redactor, fontawesome
 */

var Block = require('../block');
var stToHTML = require('../to-html');
var timeStamp = null;

module.exports = Block.extend({

    type: "redactor",

    title: function() { return 'Redactor'; },

    editorHTML: function() {
        timeStamp = Date.now();
        return '<div id="redactor-editor-' + timeStamp + '" class="st-required st-text-block" contenteditable="true"></div>';
    },

    icon_name: '<i class="fa fa-pencil-square-o"></i>',

    onBlockRender : function () {
        $('#redactor-editor-' + timeStamp).redactor();
    },

    loadData: function(data){
        this.getTextBlock().html(stToHTML(data.text, this.type));
    }
});
