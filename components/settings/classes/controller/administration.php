<?php

namespace Settings;

class Controller_Administration extends \Controller
{

	protected $data;

	public function before()
	{
		$this->data = new \stdClass;
		\Lang::load('settings');
		\Backend\Overlay::init($this->data);
	}

	public function action_index()
	{

	}

	public function after($response)
	{
		return \Response::forge(\View::forge('backend::overlay',$this->data));
	}
}