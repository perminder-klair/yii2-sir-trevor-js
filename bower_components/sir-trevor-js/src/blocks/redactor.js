/*
 Redactor Editor Block
 Make sure you initialize(loaded) following dependencies in your system to make this block work:
 redactor, fontawesome
 */

SirTrevor.Blocks.Redactor = (function(){

    var timeStamp = null;

    return SirTrevor.Block.extend({

        type: "redactor",

        title: function(){ return 'Redactor'; },

        icon_name: '<i class="fa fa-pencil-square-o"></i>',

        editorHTML: function() {
            timeStamp = Date.now();
            return '<div id="redactor-editor-' + timeStamp + '" class="st-required st-text-block" contenteditable="true"></div>';
        },

        onBlockRender : function () {
            $('#redactor-editor-' + timeStamp).redactor();
        },

        loadData: function(data){
            this.getTextBlock().html(SirTrevor.toHTML(data.text, this.type));
        },

        toMarkdown: function(markdown) {
            return markdown.replace(/^(.+)$/mg,"> $1");
        }

    });

})();