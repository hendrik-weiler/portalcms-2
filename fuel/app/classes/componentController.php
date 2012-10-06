<?php

use \Cstorage\Storage;

class ComponentController extends \Controller
{
	protected $storage;

	protected $response;

	public function before()
	{
		Storage::$current_component = \Uri::segment(1);
		$this->storage = new \Cstorage\Storage();
		$this->response = new \Response();
	}
}