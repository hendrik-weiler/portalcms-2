<?php

class Controller_Public extends \Controller
{
	public function action_index()
	{
		$initializer = new \Frontend\Initializer($this->request);
		return $initializer->render();
	}

	public function action_404()
	{
		
	}
}