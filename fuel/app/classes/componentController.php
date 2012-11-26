<?php

use \Cstorage\Storage;

class ComponentController extends \Controller
{
	protected $storage;

	protected $response;

	protected $option;

	protected $path;

	public function before()
	{
		Storage::$current_component = \Uri::segment(1);
		$this->storage = new \Cstorage\Storage();
		$this->response = new \Response();

		$this->path = new \Helper\Path();

		$this->option = new \Helper\Option();
	}
}