<?php

namespace Logincenter;

class Check
{
	public static function login(&$this)
	{
		$session = \Session::get('current_session');
		$account = \db\Accounts::find('first',array(
			'where' => array('session'=>$session)
		));

		if(! is_object($account) )
			$this->response = \Response::redirect('logincenter');
	}
}