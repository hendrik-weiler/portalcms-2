<?php

namespace db;

class Option extends \Orm\Model
{

	protected static $_table_name = 'options';

	protected static $_properties = array('id', 'key', 'value');

	public static function getKey($key)
	{
		$option = self::find('first',array(
		  'where' => array('key'=>$key),
		));

		if(empty($option))
		{
		  $option = new \stdClass;
		  $option->key = $key;
		  $option->value = 'undefined';
		}

		return $option;
	}
}