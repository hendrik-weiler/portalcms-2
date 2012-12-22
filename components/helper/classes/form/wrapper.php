<?php

namespace Helper\Form;

class Wrapper extends \Form
{
	public static $current_form = array();

	public $input;

	public $textarea;

	public $checkbox;

	public $radiobutton;

	public $actionfield;

	public $select;

	public $submit;

	public function __construct()
	{
		$this->input = new Input();

		$this->textarea = new Textarea();

		$this->checkbox = new Checkbox();

		$this->actionfield = new Actionfield();

		$this->submit = new Submit();

		$this->radiobutton = new Radiobutton();

		$this->select = new Select();
	}

	public function create($url, $type='horizontal', $class='', $returns_back = false)
	{
		static::$current_form = array();
		switch($type)
		{
			case 'horizontal':
				$type = 'form-horizontal';
			break;

			case 'vertical':
				$type = 'form-vertical';
			break;
		}

		if($returns_back) \Uri::create($url) . '?return=' . \Uri::current(); 

		static::$current_form[] = static::open(array('action'=>$url,'class'=>$type . $class,'enctype'=>'multipart/form-data'));
	}

	public function add_html($html)
	{
		static::$current_form[]  = $html;
	}

	public function __invoke()
	{
		return implode('',static::$current_form) . static::close();
	}
}