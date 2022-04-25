$(function(){
	$( 'textarea.texteditor' ).ckeditor({
		toolbar:'Full',
		language: languageabbr
	});
	$( 'textarea.mini-texteditor' ).ckeditor({toolbar:'Basic',width:700});
});