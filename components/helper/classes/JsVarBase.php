<?php

namespace Helper;

class JsVarBase
{
	protected static $_html = '
	<script type="text/javascript">
		var _url = "[url]";
		var _current_url = "[current_url]";
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
			'[url]','[current_url]','[segments]','[components]'
			), 
		array(
			$url,\Uri::current(),implode(',',$segments),implode(',',$components)
		), $html);

		return $html;
	}

	public static function render()
	{
		return static::_parse_html();
	}
}