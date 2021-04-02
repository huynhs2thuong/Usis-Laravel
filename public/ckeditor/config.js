
CKEDITOR.editorConfig = function( config )
{
    // Define changes to default configuration here. For example:
    config.language = 'vi';
    config.skin = 'office2013';
    config.height = 400;

    //config.uiColor = '#AADC6E';

    config.toolbar = [
        ['Source','-','NewPage','Preview','-','Templates'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        '/',
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['BidiLtr', 'BidiRtl' ],
        ['Link','Unlink','Anchor'],
        '/',
        ['Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
        ['Styles','Format','Font','FontSize'],
        ['TextColor','BGColor'],
        ['Maximize', 'ShowBlocks']
        ];

    config.extraPlugins = 'htmlwriter';
    config.entities = false;
    config.allowedContent = true;
    config.filebrowserUploadUrl = '/@dmin/resource';
    config.removeDialogTabs = 'image:advanced;link:advanced';

};
