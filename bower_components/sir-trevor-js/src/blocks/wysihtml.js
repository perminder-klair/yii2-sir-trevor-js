/*
 Wysihtml Editor Block
 Make sure you initialize(loaded) following dependencies in your system to make this block work:
 bootstrap, bootstrap3-wysihtml5-bower, fontawesome
 */

SirTrevor.Blocks.Wysihtml = (function(){

    return SirTrevor.Block.extend({

        type: "wysihtml",

        title: function(){ return 'wysihtml'; },

        icon_name: '<i class="fa fa-pencil-square-o"></i>',

        editorHTML: function() {
            timeStamp = Date.now();
            return '<div id="wysihtml-editor-' + timeStamp + '" class="st-required st-text-block" contenteditable="true"></div>';
        },

        onBlockRender : function () {
            $('#wysihtml-editor-' + timeStamp).wysihtml5();
        },

        loadData: function(data){
            this.getTextBlock().html(SirTrevor.toHTML(data.text, this.type));
        },

        toMarkdown: function(markdown) {
            return markdown.replace(/^(.+)$/mg,"> $1");
        }

    });

})();