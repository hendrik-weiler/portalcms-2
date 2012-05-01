<?php

namespace Helper;

class JsVarBase
{
	protected static $_html = '
	<script type="text/javascript">
		var _url = "[url]";
		var _segments = [[segments]];
	</script>';

	protected static function _parse_html()
	{
		$segments = array();
		$url = \Uri::create('/');
		$html = static::$_html;

		foreach(\Uri::segments() as $segment)
			array_push($segments,'"' . $segment . '"');

		$html = str_replace(
		array(
			'[url]','[segments]'
			), 
		array(
			$url,implode(',',$segments)
		), $html);

		return $html;
	}

	public static function render()
	{
		return static::_parse_html();
	}
}