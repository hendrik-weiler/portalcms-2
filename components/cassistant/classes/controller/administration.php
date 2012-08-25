<?php

namespace cassistant;

class Controller_Administration extends \BackendController
{
	public function action_index()
	{
		$this->data->all_modules = array_keys(\File::read_dir(DOCROOT . '../components',1));
		$this->data->active_modules = \Config::get('always_load.modules');

		$active_modules = $this->data->active_modules;

		$this->data->all_modules = array_map(function($item) use ($active_modules) {
			$row = new \stdClass;
			$row->name = str_replace(array('/','\\'), '', $item);
			$row->status = in_array($row->name, $active_modules);
			return $row;
		}, $this->data->all_modules);
	}

	public function action_new_component()
	{
		$this->template('new_component');
	}
}