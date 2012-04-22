<?php

namespace Server;

class Model_Cache
{

	private static function _minify($path,$compression=true)
	{
		$file = file($path);
		$newFile = array();
		foreach ($file as $key => $value) 
		{
			if(!$compression)
			{
				$newFile[] = $line;
				continue;
			}
			$line = str_replace(
					array('\r','\n','\t',PHP_EOL)
					,'',
					trim($file[$key])
					);
			if(!preg_match('#^(//|/\*|\*)#i', $line) && $line != '')
			{
				$newFile[] = $line;
			}
		}
		return implode('',$newFile);
	}

	private static function _check_up_cache($file,$rootFile)
	{
		if(!is_dir(APPPATH . 'cache/_server')) mkdir(APPPATH . 'cache/_server');

		$path = APPPATH . 'cache/_server/';
		$filename =  $file . '.cache';

		$content = (static::_minify($rootFile));

		if(file_exists($path . $filename))
		{
			if(filemtime($path . $filename) < filemtime($rootFile))
			{
				\File::update($path,$filename,$content);
			}
		}
		else
		{
			\File::create($path,$filename,$content);
		}

		$content = \File::read($path . $filename,true);
		return ($content);
	}

	public static function check($file,$rootFile,$method)
	{
		return static::_check_up_cache($file,$rootFile,$method == 'c');
	}
}