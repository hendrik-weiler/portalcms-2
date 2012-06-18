<?php

namespace Lightforum;

class Controller_Administration extends \BackendController
{
	public function before()
	{
		parent::before();
		\Lang::load('lightforum');
	}

	public function action_index()
	{

	}
}