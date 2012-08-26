<?php

namespace cassistant;

class Controller_Administration extends \BackendController
{
	public function action_index()
	{
		$this->data->all_modules = array_keys(\File::read_dir(DOCROOT . '../components',1));
		$this->data->active_modules = \Config::get('always_load.modules');

		$active_modules = $this->data->active_modules;

		$this->data->component_categories = array();

		$component_categories =& $this->data->component_categories;

		$this->data->all_modules = array_map(function($item) use ($active_modules, &$component_categories) {
			$row = new \stdClass;
			$row->name = str_replace(array('/','\\'), '', $item);
			$row->status = in_array($row->name, $active_modules);
			$components = json_decode(file_get_contents(DOCROOT . '../components/' . $row->name . '/component.json'));
			$row->version = $components->version;
			$row->id = $components->id;
			$row->category = $components->category;
			$component_categories[] = $row->category;
			return $row;
		}, $this->data->all_modules);

		$this->data->component_categories  = array_unique($component_categories);
		sort($this->data->component_categories);
	}

	public function action_new_component()
	{
		$this->template('new_component');
	}
}