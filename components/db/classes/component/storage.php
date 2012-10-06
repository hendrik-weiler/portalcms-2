<?php

namespace db\component;

class Storage extends \Orm\Model
{

	protected static $_table_name = 'component_storage';

	protected static $_properties = array('id', 'account_id','component', 'label', 'value');

	public static function getKey($key)
	{
		$search = array();

		$key = explode('.',$key);

		$search['where']['label'] = $key[0];

		if(count($key) == 2)
		{
			$search['where']['component'] = $key[0];
			$search['where']['label'] = $key[1];
		}	

		$search['account_id'] = \db\Accounts::getCol(\Session::get('current_session'),'id');

		$option = static::find('first',$search);

		if(empty($option))
		{
		  $option = new \stdClass;
		  $option->label = $key;
		  $option->value = 'undefined';
		}

		return $option;
	}
}