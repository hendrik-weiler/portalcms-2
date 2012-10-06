<?php

namespace Cupdateradmin;

class Controller_Administration extends \BackendController
{
	public function action_index()
	{
		$this->data->infos = \db\Component\Info::find('all',array(
			'order_by' => array('creation_date'=>'DESC')
		));
	}

	public function action_add()
	{
		$this->data->author = '';
		$this->data->version = '';
		$this->data->category = '';
		$this->data->name = '';
		$this->data->pictures = array();
		$this->data->description = '';
		$this->data->preview_index = 0;
		$this->data->action_url = 'cupdateradmin/action/add/save';
	}

	public function action_edit()
	{
		$this->template('add');

		$id = $this->param('id');

		$component = \db\Component\Info::find($id);

		$this->data->author = $component->author;
		$this->data->version = $component->version;
		$this->data->category = $component->category;
		$this->data->name = $component->name;
		$this->data->preview_index = $component->preview_index;
		$this->data->pictures = array_map(function($str) use ($component) {
			return \Uri::create('repository/' . $component->id . '/thumb_' . $str);
		},json_decode($component->pictures));
		$this->data->description = $component->description;
		$this->data->package = $component->package;
		$this->data->action_url = 'cupdateradmin/action/edit/' . $id . '/save';
	}
}