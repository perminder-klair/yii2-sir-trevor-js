/*
 Text Block
 */
SirTrevor.Blocks.Text = SirTrevor.Block.extend({

    type : "text",
    title : function () { return i18n.t('blocks:text:title'); },
    editorHTML : '<div class="st-required st-text-block" contenteditable="true"></div>',
    icon_name : 'text',
    onContentPasted:function(data) {
        var newtext = SirTrevor.cleanWord($(data.currentTarget).text());
        this.getTextBlock().html(newtext);
    },
    loadData  : function (data) {
        this.getTextBlock().html(SirTrevor.toHTML(data.text, this.type));
    },
    cleanWord:function(input){
        console.log('before clean');
        console.log(input);
        return SirTrevor.cleanWord(input);

    }
});