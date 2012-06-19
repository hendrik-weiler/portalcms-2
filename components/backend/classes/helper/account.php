<?php

namespace Backend\Helper;

class Account
{
	public static function info($type='all')
	{
		$session = \Session::get('current_session');
		$account = \db\Accounts::find('first',array(
			'where' => array('session'=>$session)
		));

		$avatar = \db\AccountsAvatars::getAvatarByAccountId($account->id);
		$group = \db\AccountsGroup::find('first',array(
			'where' => array('id'=>$account->group)
		));

		$data = new \stdClass;
		$data->account = $account;
		$data->avatar = $avatar;
		$data->group = $group;

		switch ($type) 
		{
			case 'account':
				return $account;
				break;
			case 'avatar':
				return $avatar;
				break;
			case 'group':
				return $group;
				break;
		}

		return $data;
	}
}