<?php

namespace db\Shop;

class Category extends \Orm\Model
{
	protected static $_table_name = 'shop_category';

	protected static $_properties = array(
		'id', 
		'label', 
		'url',
		'order',
	);
}