<?php

namespace Install;

class Controller_Install extends \Controller
{

	protected $data;

	public function before()
	{
		$this->data = new \stdClass;
		$this->data->step = (\Uri::segment(2) == '') ? 1 : \Uri::segment(2);
		\Lang::load('layout');

		$this->data->title = 'PortalCMS 2 - Installation ' . $this->data->step . '/4';
	}

	public function action_index()
	{
		\Response::redirect('install/1');
	}

	public function action_step1()
	{

	}

	public function action_step2()
	{
		
	}

	public function action_step3()
	{
		
	}

	public function action_step4()
	{
		
	}

	public function after($response)
	{
		$this->response->body = \View::forge('layout',$this->data);
	}
}