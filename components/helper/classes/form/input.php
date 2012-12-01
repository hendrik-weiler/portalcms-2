<?php

namespace Helper\Form;

class Input extends \Form
{
	private $template = '<div class="control-group">

		%label%
		<div class="controls">
			%input%
		</div>

	</div>';

	public function create($label, $name, $value='', $class='')
	{
		Wrapper::$current_form[] = str_replace(array(
			'%label%', '%input%'
		), array(
			static::label($label, $name,array('class'=>'control-label' . $class)),
			static::input($name,$value,array('class'=>$class))
		), $this->template);
	}
}