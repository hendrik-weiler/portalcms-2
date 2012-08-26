<?php

namespace Cstorage;

class Controller_Storage extends \ComponentController
{
	private function _get_label()
	{
		$key = \Input::post('key');
		$component = \Input::post('component');

		$key = explode('.',$key);
		if(count($key) == 2)
		{
			$component = $key[0];
			$key = $key[1];
		}
		else
		{
			$key = $key[0];
		}

		return $component . '.' . $key;
	}

	public function action_set()
	{
		$label = $this->_get_label();
		$this->response->body = $this->storage->set($label, \Input::post('value'));
	}

	public function action_get()
	{
		$label = $this->_get_label();
		$this->response->body = $this->storage->get($label);
	}

	public function action_remove()
	{
		$label = $this->_get_label();
		$this->response->body = $this->storage->remove($label);
	}

	public function after($response)
	{
		return $this->response;
	}
}