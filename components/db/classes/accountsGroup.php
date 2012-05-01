<?php

namespace db;

class AccountsGroup extends \Orm\Model
{
	protected static $_table_name = 'accounts_group';

	protected static $_properties = array('id', 'label', 'permissions');

	public static function getGroupByLabel($label)
	{
		$search = static::find('first',array(
			'where' => array('label'=>$label)
		));

		return $search;
	}
}