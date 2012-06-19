<?php

namespace Backend\Helper;

class Navigation
{
	protected static $data;

	protected static $tpl_wrapper = '<div class="@component_navigation subnav clearfix"><ul>@content</ul></div>';

	protected static $tpl_li = '<li><a @active href="@url">@label</a></li>';

	protected static function _build_navigation()
	{
		$base_url = \Backend\Helper\Component::$base_url;
		$current_index = \Backend\Helper\Component::$url_segment[2];
		$tpl_li = array();
		foreach (static::$data as $point) 
		{
			$url_point = str_replace(' ','_',strtolower($point));
			$active = '';
			$current_index == $url_point and $active = 'class="sub_active"';
			$tpl_li[] = str_replace(
				array('@url','@label','@active'),
				array($base_url . '/' . $url_point,$point,$active), 
				static::$tpl_li
			);	
		}

		return str_replace(
			array('@component','@content'), 
			array('',implode('',$tpl_li)), 
			static::$tpl_wrapper
		);
	}

	public static function render(Array $data)
	{
		static::$data = array_unique($data);
		return static::_build_navigation();
	}
}