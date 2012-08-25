<?php

namespace db;

class LayoutData extends \Orm\Model
{
	protected static $_table_name = 'layout_data';

	protected static $_properties = array('id', 'group_id', 'html', 'creation_date');
}