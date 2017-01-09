/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
   config.filebrowserBrowseUrl = '/admin/assets/vendor/editors/kcfinder/browse.php?opener=ckeditor&type=files';
   config.filebrowserImageBrowseUrl = '/admin/assets/vendor/editors/kcfinder/browse.php?opener=ckeditor&type=images';
   config.filebrowserFlashBrowseUrl = '/admin/assets/vendor/editors/kcfinder/browse.php?opener=ckeditor&type=flash';
   config.filebrowserUploadUrl = '/admin/assets/vendor/editors/kcfinder/upload.php?opener=ckeditor&type=files';
   config.filebrowserImageUploadUrl = '/admin/assets/vendor/editors/kcfinder/upload.php?opener=ckeditor&type=images';
   config.filebrowserFlashUploadUrl = '/admin/assets/vendor/editors/kcfinder/kcfinder/upload.php?opener=ckeditor&type=flash';
};

CKEDITOR.on('instanceReady', function( ev ) {
  var blockTags = ['div','h1','h2','h3','h4','h5','h6','p','pre','li','blockquote','ul','ol',
  'table','thead','tbody','tfoot','td','th',];

  for (var i = 0; i < blockTags.length; i++)
  {
     ev.editor.dataProcessor.writer.setRules( blockTags[i], {
        indent : false,
        breakBeforeOpen : true,
        breakAfterOpen : false,
        breakBeforeClose : false,
        breakAfterClose : true
     });
  }
});