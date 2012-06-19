<?php

class Controller_Frontend extends Controller
{
	public function action_index()
	{
		return \Response::forge('something');
	}

	public function action_404()
	{
		return $this->response;
	}
}