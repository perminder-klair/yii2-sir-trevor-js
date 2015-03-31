"use strict";

/*
 HTML Code Editor Block
 Make sure you initialize(loaded) following dependencies in your system to make this block work:
 fontawesome
 */

var Block = require('../block');
var timeStamp = null;

module.exports = Block.extend({

    type: "code",

    title: function() { return 'code'; },

    editorHTML: function() {
        return '<textarea id="code-editor" name="text" class="st-required st-text-block st-code-input" contenteditable="true" rows="8" style="width: 100%;"> </textarea>';
    },

    icon_name: 'text',

    loadData: function(data){
        this.$('#code-editor').val(data.text);
    }
});
