<?php

namespace Helper\Form;

class Checkbox extends \Form
{
	private $template = '<label class="checkbox">
	  %checkbox%
	  %label%
	</label>';

	public function create($name, $label, $value, $checked=false, $class='')
	{

		Wrapper::$current_form[] = str_replace(array(
			'%label%', '%checkbox%'
		), array(
			$label,
			static::checkbox($name , $label, $checked),
		), $this->template);

	}
}