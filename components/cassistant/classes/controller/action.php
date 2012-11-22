<?php

namespace cassistant;

class Controller_Action extends \AuthController
{
	public function before()
	{
		\Lang::load('messages');
	}

	public function action_create_component()
	{
		
		\Response::redirect('cassistant/administration/components');
	}
}