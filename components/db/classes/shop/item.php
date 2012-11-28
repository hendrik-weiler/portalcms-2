<?php

namespace db\Shop;

class Item extends \Orm\Model
{
	protected static $_table_name = 'shop_item';

	protected static $_properties = array(
		'id', 
		'mwst_group_id', 
		'category_id',
		'label', 
		'description',
		'offer',
		'article_number',
		'pictures'
	);
}