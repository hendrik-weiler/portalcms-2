<?php

namespace Helper\Form;

class Actionfield extends \Form
{
	private $template = '<div class="form-actions%class%">

		%buttons%

	</div>';

	public function create($buttons, $class='')
	{
		$form_content = array();
		for($i = 0; $i < count($buttons); $i++)
			$form_content[] = array_pop(Wrapper::$current_form);

		Wrapper::$current_form[] = str_replace(array(
			'%buttons%', '%class%'
		), array(
			implode(' ',array_reverse($form_content)),
			$class
		), $this->template);
	}
}