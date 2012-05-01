<?php

namespace db;

class AccountsAvatars extends \Orm\Model
{
	protected static $_table_name = 'accounts_avatars';

	protected static $_properties = array('id', 'account_id', 'picture');

	public static function getAvatarByAccountId($id)
	{
		return static::find('first',array(
			'where' => array('account_id'=>$id)
		));
	}
}