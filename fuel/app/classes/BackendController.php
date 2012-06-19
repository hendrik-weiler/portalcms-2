<?php

class BackendController extends \AuthController
{
	protected $data;

	protected $component;

	protected $account;

	public function before()
	{
		parent::before();
		\Lang::load('global');
		$this->data = new \stdClass;
		\Backend\Overlay::init($this->data);
		\Backend\Helper\Component::analyze();
		$this->component = new \stdClass;
		$this->component->base_url = \Backend\Helper\Component::$base_url;
		$this->component->url_segment = \Backend\Helper\Component::$url_segment;
		$this->component->current_index = \Backend\Helper\Component::$current_index;
		$this->component->options = \Backend\Helper\Component::$options;
		$this->component->navigation = \Backend\Helper\Component::$navigation;
		$this->component->name = \Backend\Helper\Component::$name;

		$this->info = \Backend\Helper\Account::info();
		$this->data->account = $this->info->account;
		$this->data->group = $this->info->group;
		$this->data->avatar = $this->info->avatar;

		\Lang::load($this->component->name . '::default');

		if(!$this->component->options['has_index']
		 && $this->component->current_index == 'index')
		{
			return \Response::redirect($this->component->base_url . '/' . $this->component->navigation[0]);
		}		
	}

	public function after($response)
	{
		parent::after($response);
		$this->data->component_navigation = \Backend\Helper\Navigation::render(__('component_navigation'));
		$this->data->component_content = \View::forge(\Backend\Helper\Component::$current_index,$this->data);
		return \Response::forge(\View::forge('backend::overlay',$this->data));
	}
}