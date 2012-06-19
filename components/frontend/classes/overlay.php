<?php

namespace Frontend;

class Overlay
{

	public static function init(&$data)
	{

	}

	public static function set_language()
	{
		\Lang::load('backend::overlay');
	}

}