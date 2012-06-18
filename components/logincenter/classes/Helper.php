<?php

namespace Logincenter;

class Helper
{
	public static function login_redirect_url()
	{
		$components = \File::read_dir(DOCROOT . '../components',1);
		foreach ($components as $dir => $s) 
		{
			if(is_dir(DOCROOT . '../components/' . $dir))
			{
				$dir = str_replace('\\', '', $dir);
				if(file_exists(DOCROOT . '../components/' . $dir . '/options.json'))
				{
					return \Uri::create($dir . '/administration');
				}
			}
		}
		return false;
	}
}