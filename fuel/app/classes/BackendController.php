<?php

class BackendController extends \AuthController
{
	protected $data;

	public function before()
	{
		parent::before();
		$this->data = new \stdClass;
		\Backend\Overlay::init($this->data);
	}

	public function after($response)
	{
		parent::after($response);
		return \Response::forge(\View::forge('backend::overlay',$this->data));
	}
}