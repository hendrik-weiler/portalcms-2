<?php

namespace Helper;

class Path 
{
	public $components;

	public $layouts;

	public function __construct()
	{
		$this->components = realpath(DOCROOT . '../components');

		$this->layouts = realpath(DOCROOT . '../layout');
	}
}