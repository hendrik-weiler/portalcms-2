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

	public static function getKeyNew($key, $default)
	{
		$result = static::getKey($key);

		if($result->value == 'undefined')
		{
			$new_row = new Option();
			$new_row->key = $key;
			$new_row->value = $default;
			$new_row->save();
			$result = $new_row;
		}

		return $result;
	}
}