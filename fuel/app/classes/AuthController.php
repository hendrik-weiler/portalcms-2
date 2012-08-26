<?php

class AuthController extends \ComponentController
{
	public function before()
	{
		parent::before();
		\Logincenter\Check::login($this);
	}
}