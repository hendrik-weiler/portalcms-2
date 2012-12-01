<?php

namespace Helper\Form;

class Select extends \Form
{
	public function create($options, $name, $selected=0, $multiple=false, $attributes=array())
	{
		$multiple and $attributes['multiple'] = 'multiple';
		Wrapper::$current_form[] = static::select($name, $selected, $options, $attributes);

	}
}