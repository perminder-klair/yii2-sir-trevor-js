"use strict";

/*
 Block Heading and Text
 Make sure you initialize(loaded) following dependencies in your system to make this block work:
 fontawesome
 */

var _ = require('../lodash');

var Block = require('../block');
var stToHTML = require('../to-html');

var template = _.template([
    '<div class="st-text-image">',
        '<div class="row">',
            '<div class="col-12">',
                '<label class="st-input-label">Title</label>',
                '<input maxlength="140" name="title" placeholder="headingtext"',
                ' class="st-input-string js-title-input" type="text" />',
            '</div>',
            '<div class="col-12">',
            '<label class="st-input-label">Text</label>',
                '<div class="st-required st-text-block" contenteditable="true"></div>',
            '</div>',
        '</div>',
    '</div>'
].join("\n"));

module.exports = Block.extend({

    type: "headingtext",

    title: function(){ return i18n.t('blocks:headingtext:title'); },

    icon_name: '<i class="fa fa-align-center"></i>',

    editorHTML: function() {
        return template(this);
    },

    loadData: function(data){
        this.getTextBlock().html(stToHTML(data.text, this.type));
        this.$('.js-title-input').val(data.title);
    }
});
