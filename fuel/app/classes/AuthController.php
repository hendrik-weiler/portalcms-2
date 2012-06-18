<?php

class AuthController extends \Controller
{
	public function before()
	{
		\Logincenter\Check::login($this);
	}
}