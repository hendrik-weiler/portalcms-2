<?php

namespace Frontend;

class Initializer extends \ComponentController
{

	private function get_frontend_components()
	{
		$components = \File::read_dir(DOCROOT . '../components/',1);

		$list = array();

		foreach($components as $component => $is_file)
		{
			$component = str_replace(DS,'',$component);
			$content = \File::read(DOCROOT . '../components/' . $component . '/component.json',true);
			$options = \Format::forge($content,'json')->to_array();
			if(isset($options['frontend_display']) && $options['frontend_display'] == true)
				$list[] = $component;
		}

		return $list;
	}

	public function render()
	{
		$component_list = $this->get_frontend_components();

		foreach ($component_list as $component) 
		{
			$component = '\\' . ucfirst($component) . '\\Display';
			$component = new $component();
			$result = $component->show();
		}

		return $this->response;
	}

}