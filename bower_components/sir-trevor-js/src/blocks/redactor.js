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
        return '<textarea id="redactor-editor" name="redactor" class="st-required st-input-string st-redactor-input"></textarea>';
    },

    icon_name: '<i class="fa fa-pencil-square-o"></i>',

    onBlockRender : function () {
        this.$('#redactor-editor').redactor();
    },

    loadData: function(data){
        this.$('textarea#redactor-editor').val(data.redactor);
    }
});
