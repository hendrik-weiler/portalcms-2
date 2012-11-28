<?php

namespace Helper;

class Option
{
	public function __construct()
	{
		if(!file_exists(DOCROOT . '../DATABASE_FINISHED'))
			$options = array();
		else
			$options = \db\Option::find('all');

		foreach ($options as $option) 
		{
			$this->{$option->key} = $option->value;
		}
	}

	public function get_or_create_new($key, $value)
	{
		return \db\Option::getKeyNew($key, $value);
	}

	public function get($key)
	{
		return \db\Option::getKey($key);
	}
}