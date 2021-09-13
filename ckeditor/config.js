/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.contentsCss = '/templates/www/default/css/style-editor.css';
	config.height = 130;
	config.toolbar = 'Full';
	config.allowedContent = true; 
	config.toolbar_Full = [
      ['Source','Maximize','Preview','-','PasteFromWord','Image','Flash','IFrame','Link','Unlink','RemoveFormat'],
      ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
      ['Bold','Italic','Underline','Strike','TextColor','BGColor'],
      ['NumberedList','BulletedList','Outdent','Indent'],
      ['Table','HorizontalRule','SpecialChar'],
      ['Styles','Format','Font','FontSize'],
    ];
	config.toolbar_Min = [
	   ['Bold','Italic','Underline','Strike','Subscript','Superscript']
	 ];
	 config.baseFloatZIndex = 9000;
};
