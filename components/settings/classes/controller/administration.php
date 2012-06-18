<?php

namespace Settings;

class Controller_Administration extends \BackendController
{

	public function before()
	{
		parent::before();
		\Lang::load('settings');
	}

	public function action_index()
	{
		
	}
}