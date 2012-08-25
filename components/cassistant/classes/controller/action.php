<?php

namespace cassistant;

class Controller_Action extends \AuthController
{
	public function before()
	{
		\Lang::load('messages');
	}
}