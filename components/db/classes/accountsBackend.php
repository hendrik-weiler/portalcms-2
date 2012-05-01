<?php

namespace db;

class AccountsBackend extends \Orm\Model
{

	protected static $_table_name = 'accounts_backend';

	protected static $_properties = array('id', 'username', 'password', 'session','language','admin','permissions');

	public static function getCol($session,$col)
	{
		$account = static::find('first',array(
		  'where' => array('session' => $session),
		));

		return $account->$col;
	}
}