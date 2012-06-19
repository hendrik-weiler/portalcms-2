<?php

namespace Base;

class Controller_Action extends \AuthController
{
	public function before()
	{
		\Lang::load('messages');
	}


	public function action_update_account_general()
	{
		$input = \Helper\AjaxLoader::get_input();

		$response = \Helper\AjaxLoader::to_r(__('messages.1'));

		return \Helper\AjaxLoader::get_response($input, $response);
	}
}