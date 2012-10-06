<?php

namespace db\component;

class Info extends \Orm\Model
{

	protected static $_table_name = 'component_info';

	protected static $_properties = array('id', 'version', 'name', 'category', 'author', 'package', 'pictures', 'description', 'preview_index');

}