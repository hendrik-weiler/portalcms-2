<?php

namespace Server;

class Model_Cache extends \Model
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

	private static function _check_up_cache($file,$rootFile,$cache_dir,$parser_type)
	{
		if(!is_dir(APPPATH . 'cache/_server')) mkdir(APPPATH . 'cache/_server');
		if(!is_dir(APPPATH . 'cache/_server/' . $cache_dir)) mkdir(APPPATH . 'cache/_server/' . $cache_dir);

		$path = APPPATH . 'cache'.DS.'_server/'.DS. $cache_dir . DS;
		$filename =  str_replace('.', '_', $file) . '.cache';

		!file_exists($path . $filename) and \File::create($path , $filename, '');

		$content = (static::_minify($rootFile));

		$content_file = file_get_contents($rootFile);

		$content = \File::read($path . $filename,true);

		if(filemtime($path . $filename) > filemtime($rootFile) && $content != '')
		{
			return $content;
		}	
		else if($parser_type == 'coffee')
		{
			
			#\File::update($path,$filename,
			# 	
			#);
		}
		else if($parser_type == 'sass' || $parser_type == 'scss')
		{
			@require APPPATH . 'vendor/Phamlp/sass/SassParser.php';
			$sass = @new \SassParser(array('style'=>'compressed'));
			$css = @$sass->toCSS($rootFile);

			$url=substr(\Uri::create('/'), 0, -1);
			$piePath = \Uri::create('assets/htc/PIE.php');
			$css = str_replace(array('DOCROOT','PIEPATH'),array($url,$piePath),$css);
			\File::update($path,$filename,$css);
		}
		else if($parser_type == 'css')
		{
			\File::update($path,$filename,Model_Css::parse($rootFile,'min'));
		}
		return \File::read($path . $filename,true);
	}

	public static function check($file,$rootFile,$cache_dir,$parser_type)
	{
		return static::_check_up_cache($file,$rootFile,$cache_dir,$parser_type);
	}
}