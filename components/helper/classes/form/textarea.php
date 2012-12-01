<?php

namespace Helper\Form;

class Textarea extends \Form
{

	private $script = '<script type="text/javascript">
$(function() {
	tinyMCE.init({
		// General options
		mode : "specific_textareas",
		editor_selector : "%selector%",

		theme_advanced_toolbar_location : "top",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,forecolor,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,outdent,indent,blockquote,separator,undo,redo,image,bullist,numlist,table,link,code",
		plugins : "emotions,safari,inlinepopups",
		theme_advanced_buttons1_add : "emotions",
	});
});
</script>
';

	public function create($name, $value='', $width='100%', $height='300px', $class='')
	{
		Wrapper::$current_form[] = static::textarea($name,$value,array('style'=>'width:' . $width . ';height:' . $height . ';', 'class'=>$class));
	}

	public function create_editor($name, $value='', $width='100%', $height='300px', $class='')
	{
		Wrapper::$current_form[] = static::textarea($name,$value,array('style'=>'width:' . $width . ';height:' . $height . ';', 'class'=> 'editor_' . $name . ' ' . $class));
		Wrapper::$current_form[] = str_replace(array(
			'%selector%'
		), array(
			'editor_' . $name
		), $this->script);
	}
}