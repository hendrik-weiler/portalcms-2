<?php

namespace Backend;

class Overlay
{

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
		$dirs = \File::read_dir(APPPATH . '../../components',1);

		foreach ($dirs as $dir => $bool) 
		{
			$filepath = APPPATH . '../../components/' . str_replace(DS,'',$dir) . '/options.json';
			if(file_exists($filepath))
			{
				$component_data = json_decode(file_get_contents($filepath));
				$component_data->name = str_replace(array('/',DS), '', $dir);
				$data->components[] = $component_data;
			}	
		}
	}
}