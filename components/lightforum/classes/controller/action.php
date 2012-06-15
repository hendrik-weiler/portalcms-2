<?php

namespace Lightforum;

class Controller_Action extends \Controller
{
	private $_error_messages = array(
		1 => array(
			'status' => 200,
			'title'	 => 'Success!',
			'message'=>	'Login was successful.'
		),
		2 => array(
			'status' => 404,
			'title'	 => 'Wrong Username or Password',
			'message'=>	'You have typed in a wrong username or password.'
		)
	);

	public function action_login_attempt()
	{
		return \Response::forge(\Helper\AjaxLoader::response(
			\Helper\AjaxLoader::to_r($this->_error_messages[$msg_id])
		));
	}
}