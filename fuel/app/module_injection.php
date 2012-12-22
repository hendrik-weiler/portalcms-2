<?php

class module_injection
{
	public static function generate($predefined = array())
	{
		foreach(scandir(DOCROOT . '../components') as $folder)
		{
			if(!in_array($folder, array('.','..','base'))
				&& !in_array($folder, $predefined)
				&& is_dir(DOCROOT . '../components/' . $folder))
			{
				$predefined[] = $folder;
			}
		}

		return $predefined;
	}
}