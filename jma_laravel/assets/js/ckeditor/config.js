/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.toolbarGroups = [
	                		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
	                		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	                		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	                		{ name: 'forms', groups: [ 'forms' ] },
	                		{ name: 'styles', groups: [ 'styles' ] },
	                		{ name: 'links', groups: [ 'links' ] },
	                		{ name: 'colors', groups: [ 'colors' ] },
	                		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
	                		{ name: 'tools', groups: [ 'tools' ] },
	                		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
	                		{ name: 'insert', groups: [ 'insert' ] },
	                		{ name: 'others', groups: [ 'others' ] },
	                		{ name: 'about', groups: [ 'about' ] }
	                	];

						/*config.enterMode = CKEDITOR.ENTER_BR;
						config.ShiftEnterMode = CKEDITOR.ENTER_BR;*/
	                	

	                	config.removeButtons = 'Image,Source,Save,NewPage,Preview,Print,Templates,Find,Replace,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,Strike,RemoveFormat,Blockquote,CreateDiv,BidiLtr,BidiRtl,Link,Unlink,Anchor,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Maximize,ShowBlocks,About,SelectAll,Scayt,Language,Undo,Redo,Styles,Paste,PasteText,PasteFromWord,Copy,Cut';
	
	/*
	config.toolbar = [
	          		{ name: 'insert', items: ['Table', 'HorizontalRule', 'SpecialChar', 'Smiley' ] },
	          		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
	          		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
	          		'/',
	          		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
	          		{ name: 'styles', items: [ 'FontSize', 'Format' ] }
	          	];
	          	*/
	
//	config.extraPlugins = 'inlinesave';
	
	
	/*
	config.on = {
			  focus: function(event) {
				  alert("focused..");
			        // Do something when an inline editor instance receives the focus.
			  },
			  blur: function(event) {
				  alert("yes...");
			        // Do something when an inline editor instance loses the focus.  
			  }
			};
			*/
};
