/**
 * Created by pascalbrewing on 02.09.14.
 */
SirTrevor.Blocks.Textimage = (function (_) {
    var template = _.template([
        '<div>' +
        '<div class="st-block-left" style="width: 50%;float: left;border: 1px solid #cccccc;">' +
        '<div class="st-required st-image-block" ></div>' +
        '<div class="st-block__upload-container">'+
        '<input type="file" type="st-file-upload">'+
        '<button class="st-upload-btn"><%= i18n.t("general:upload") %></button>'+
        '</div>'+
        '</div>' +
        '<div class="st-block-right" style="width: 50%;float: left;border: 1px solid #cccccc;">' +
        '<div class="class="st-required st-heading-block" contenteditable="true">'+
            '<input type="text" name="headline" placeholder="headline" />'+
        '</div>' +
        '<div class="class="st-required st-text-block" contenteditable="true"></div>' +
            '<textarea name="mytext"></textarea>'+
        '</div>' +
        '</div>'
    ].join("\n"));

    return SirTrevor.Block.extend({

        type          : "textimage",
        title         : 'Text and Image',
        icon_name     : 'iframe',
        droppable     : true,
        uploadable    : true,
        loadData      : function (data) {
            SirTrevor.log(['loaded data',data]);

            // Create our image tag
            this.$editor.html(template);
            var imageBlock = this.$editor.find('.st-image-block');

            //imageBlock.html(this.upload_options);

        },
        editorHTML    : function () {
            return template(this);
        },
        onBlockRender : function () {
            /* Setup the upload button */
            SirTrevor.log('onBlockRender Text Image');
            SirTrevor.log(['this.$inputs',this.$inputs]);

            var imageBlock = this.$editor.find('.st-image-block');
            console.log(SirTrevor.Block.upload_options);
            //this.$inputs.find('button').bind('click', function (ev) { ev.preventDefault(); });
            //this.$inputs.find('input').on('change', _.bind(function (ev) {
            //    this.onDrop(ev.currentTarget);
            //}, this));
        },
        onUploadSuccess : function(data) {
            this.setData(data);
            this.ready();
        },

        onUploadError : function(jqXHR, status, errorThrown){
            this.addMessage(i18n.t('blocks:image:upload_error'));
            this.ready();
        },

        onDrop: function(transferData){
            var file = transferData.files[0],
                urlAPI = (typeof URL !== "undefined") ? URL : (typeof webkitURL !== "undefined") ? webkitURL : null;

            // Handle one upload at a time
            if (/image/.test(file.type)) {
                this.loading();
                // Show this image on here
                this.$inputs.hide();
                this.$editor.html($('<img>', { src: urlAPI.createObjectURL(file) })).show();

                this.uploader(file, this.onUploadSuccess, this.onUploadError);
            }
        }
    });
}(_));