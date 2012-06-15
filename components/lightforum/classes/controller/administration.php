<?php

namespace Lightforum;

class Controller_Administration extends \Controller
{

	protected $data;

	public function before()
	{

		$this->data = new \stdClass;
		\Lang::load('lightforum');
	}

	public function action_index()
	{
		\Backend\Overlay::set_language();
		\Backend\Overlay::set_account($this->data);
		\Backend\Overlay::set_components($this->data); 
	}

	public function after($response)
	{
		return \Response::forge(\View::forge('backend::overlay',$this->data));
	}
}