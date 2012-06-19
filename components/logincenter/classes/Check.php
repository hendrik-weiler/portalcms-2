<?php

namespace Logincenter;

class Check
{
	public static function login(&$this)
	{
		$account = \Backend\Helper\Account::info('account');

		if(! is_object($account) )
			$this->response = \Response::redirect('logincenter');
	}
}