<?php

namespace Logincenter;

class Helper
{
	public static function login_redirect_url()
	{
		$components = \File::read_dir(DOCROOT . '../components',1);
		$modules = \Config::get('always_load.modules');
		foreach ($components as $dir => $s) 
		{
			$dir = str_replace('\\', '', $dir);
			if(is_dir(DOCROOT . '../components/' . $dir) && in_array(strtolower($dir), $modules))
			{
				if(file_exists(DOCROOT . '../components/' . $dir . '/options.json'))
				{
					return \Uri::create($dir . '/administration');
				}
			}
		}
		return false;
	}
}