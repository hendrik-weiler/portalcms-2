<?php

namespace db;

class Accounts extends \Orm\Model
{
	protected static $_table_name = 'accounts';

	protected static $_properties = array('id', 'username', 'password', 'session','language','group');

	public static function getCol($session,$col)
	{
		$account = static::find('first',array(
		  'where' => array('session' => $session),
		));

		if($col == 'all')
			return $account;

		return $account->$col;
	}
}