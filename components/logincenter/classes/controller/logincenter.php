<?php

namespace Logincenter;

class Controller_Logincenter extends \Controller
{

	protected $data;

	public function before()
	{

		$this->data = new \stdClass;
		\Lang::load('login');

		$this->data->title = 'Logincenter';
	}

	public function action_index()
	{
		$saved_logins = \Session::get('saved_logins');
		$this->data->accounts = empty($saved_logins) ? array() : $saved_logins;
	}

	public function after($response)
	{
		$this->response->body = \View::forge('login',$this->data);
	}
}