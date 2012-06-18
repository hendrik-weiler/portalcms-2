<?php

namespace Logincenter;

class Controller_Action extends \Controller
{
	public function before()
	{
		\Lang::load('messages');
	}

	private function _clear_logins($logins,$new_login)
	{
		$username = array();
		foreach ($logins as $login) 
			$username[] = $login['username'];
		
		if(in_array($new_login['username'], $username))
			return $logins;
		else
			return $logins + array($new_login);
	}

	public function action_login_attempt()
	{
		$input = \Helper\AjaxLoaderProgress::get_input();
		$username = $input['username'];
		$password = $input['password'];
		$token = $input['fuel_csrf_token'];

		if ( ! \Security::check_token($token))
		{
			$msg_id = 2;
		}
		else
		{
			$account = \db\Accounts::find('first',array(
				'where' => array('username' => ($username),'password'=> sha1($password))
			));
			if(is_object($account))
			{
				$session = sha1(rand(-85265878478,9656487845484).sha1($username).sha1($password).sha1($token));
				\Session::set('current_session',$session);
				$account->session = $session;
				$account->save();

				$saved_logins = \Session::get('saved_logins');
				$saved_logins = !is_array($saved_logins) ? array() : $saved_logins;
				$new_login = array(
					'id' => $account->id,
					'username' => $account->username,
					'picture' => \db\AccountsAvatars::getAvatarByAccountId($account->id)->picture
				);
				\Session::set('saved_logins',static::_clear_logins($saved_logins,$new_login));
				$msg_id = 1;
			}
			else
			{
				$msg_id = 2;
			}
		}
		
		return \Helper\AjaxLoader::get_response($input, 
			\Helper\AjaxLoader::to_r(__('messages.' . $msg_id))
		);
	}

	public function action_logout()
	{
		$session = \Session::get('current_session');
		$account = \db\Accounts::getCol($session,'all');
		$account->session = 'logout_' . sha1(($account->session));
		$account->save();

		return \Response::redirect('logincenter');
	}
}