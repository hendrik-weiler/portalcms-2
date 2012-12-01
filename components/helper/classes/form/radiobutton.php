<?php

namespace Helper\Form;

class Radiobutton extends \Form
{
	private $template = '<div class="radio-list%class%">

		%buttons%

	</div>';

	private $radio_template = '<label class="radio">
	  %radio%
	  %label%
	</label>';

	private function make_radio($label, $value, $checked, $name)
	{
		return str_replace(array(
			'%label%', '%radio%'
		), array(
			$label,
			static::radio($name , $label, $checked),
		), $this->radio_template);
	}

	public function create($buttons, $name, $class='')
	{
		$form_content = array();
		for($i = 0; $i < count($buttons); $i++)
		{
			!isset($buttons[$i][0]) and $buttons[$i][0] = 'undefined';
			!isset($buttons[$i][1]) and $buttons[$i][1] = 'undefined';
			!isset($buttons[$i][2]) and $buttons[$i][2] = false;
			$form_content[] = $this->make_radio(trim($buttons[$i][0]), trim($buttons[$i][1]), $buttons[$i][2], $name);
		}

		Wrapper::$current_form[] = str_replace(array(
			'%buttons%', '%class%'
		), array(
			implode(' ',($form_content)),
			$class
		), $this->template);

	}
}