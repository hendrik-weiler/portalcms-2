<?php

class Controller_Public extends \Controller
{
	public function action_index()
	{
		print "hallo";
	}

	public function after($response)
	{
		return $this->response;
	}

	public function action_404()
	{
		
	}
}