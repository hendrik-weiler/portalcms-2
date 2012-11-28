<?php

namespace Shop;

class Controller_Administration extends \BackendController
{
	public function action_index()
	{
		$this->data->items = \db\Shop\Item::find('all');
	}

	public function action_new_item()
	{
		

		
		$this->template('items_new');
	}
}