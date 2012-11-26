<?php

namespace Frontend;

class Initializer extends \ComponentController
{

	public static $component_output = array();

	public static $base_layout = 'start.php';

	public function __construct()
	{
		parent::before();
	}

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
			$component_name = $component;

			$component = '\\' . ucfirst($component) . '\\Frontend';
			$component = new $component();

			$reflector = new \ReflectionClass(new $component());
			if($reflector->hasProperty('base_layout'))
				static::$base_layout = $component->base_layout;

			static::$component_output[$component_name] = $component->get_output();
		}

		$selected_layout = $this->option->get('selected_layout');
		if($selected_layout->value == 'undefined')
		{
			print 'Option "selected_layout" is missing.';
			exit;
		}

		return \View::forge($this->path->layouts . '/' . $selected_layout->value . '/' . static::$base_layout, static::$component_output);
	}

}