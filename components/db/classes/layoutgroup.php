<?php

namespace db;

class Accounts extends \Orm\Model
{
	protected static $_table_name = 'accounts';

	protected static $_properties = array('id', 'name');
}