<?php

namespace Backend;

class Overlay
{

	public static function init(&$data)
	{
		\Backend\Overlay::set_language();
		\Backend\Overlay::set_account($data);
		\Backend\Overlay::set_components($data); 
		\Backend\Overlay::set_content_view($data);
	}

	public static function set_language()
	{
		\Lang::load('backend::overlay');
	}

	public static function set_account(&$data)
	{
		$session = \Session::get('current_session');
		$data->account = \db\Accounts::getCol($session,'all');
		$data->avatar = \db\AccountsAvatars::getAvatarByAccountId($data->account->id);
	}

	public static function set_components(&$data)
	{
		$data->components = array();
		$components = \Config::get('always_load.modules');

		foreach ($components as $component) 
		{
			$filepath = APPPATH . '../../components/' . $component . '/options.json';
			if(file_exists($filepath))
			{
				$component_data = json_decode(\File::read($filepath,true));
				$component_data->name = $component;
				$data->components[] = $component_data;
			}	
		}
	}

	public static function set_content_view(&$data)
	{
		$function = \Uri::segment(3);
		$data->view = empty($function) ? 'index' : $function;
	}
}