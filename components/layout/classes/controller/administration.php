<?php

namespace Layout;

class Controller_Administration extends \BackendController
{

	public function get_layout_list()
	{
		$list = array();

		$layout_path = $this->path->layouts;

		@array_walk(\File::read_dir($layout_path,1), function($key, $value) use (&$list, $layout_path) {

			$config = \Format::forge(\File::read($layout_path . '/' . $value . 'config.json',true), 'json')->to_array();

			$layout = new \stdClass;
			$layout->index = count($list);
			$layout->label = $config['label'];
			$layout->description = $config['description'];
			$layout->folder_name = str_replace('/', '', $value);
			$list[] = $layout;
		});

		return $list;
	}

	public function action_index()
	{
		$this->data->layouts = $this->get_layout_list();
	}

	public function action_save()
	{
		$layout = $this->option->get('selected_layout');
		$layout->value = \Input::post('folder');
		$layout->save();

		\Response::redirect('layout/administration/Selection');
	}
}