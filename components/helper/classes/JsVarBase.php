<?php

namespace Helper;

class JsVarBase
{
	protected static $_html = '
	<script type="text/javascript">
		var _url = "[url]";
		var _segments = [[segments]];
		var _components = [[components]];
	</script>';

	protected static function _parse_html()
	{
		$segments = array();
		$components = array();

		$url = \Uri::create('/');
		$html = static::$_html;

		foreach(\Uri::segments() as $segment)
			array_push($segments,'"' . $segment . '"');

		foreach(\Config::get('always_load.modules') as $module)
			array_push($components,'"' . $module . '"');

		$html = str_replace(
		array(
			'[url]','[segments]','[components]'
			), 
		array(
			$url,implode(',',$segments),implode(',',$components)
		), $html);

		return $html;
	}

	public static function render()
	{
		return static::_parse_html();
	}
}