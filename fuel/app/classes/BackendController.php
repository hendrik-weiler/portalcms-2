<?php

class BackendController extends \AuthController
{
	protected $data;

	protected $component;

	protected $account;

	private $_template = false;

	protected function template($name)
	{
		$this->_template = $name;
	}

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

		$this->data->title = ucfirst($this->component->name) . ' - ' . ucfirst($this->component->current_index);

		\Lang::load($this->component->name . '::default');

		if(!$this->component->options['has_index']
		 && $this->component->current_index == 'index')
		{
			return \Response::redirect($this->component->base_url . '/' . $this->component->navigation[0]);
		}	

		$this->data->option = $this->option;	

		$this->data->form = new \Helper\Form\Wrapper();
	}

	public function after($response)
	{
		parent::after($response);
		$this->data->component_navigation = \Backend\Helper\Navigation::render(__('component_navigation'));

		if(is_array($this->component->options['type']) 
			&& $this->component->options['type'][$this->component->current_index] == 'dragdropgrid')
		{
			$view = 'backend::overlay_dragdropgrid';
		}
			
		if(is_array($this->component->options['type']) 
			&& $this->component->options['type'][$this->component->current_index] == 'dragdrop')
		{
			$view = 'backend::overlay_dragdrop';
		}
			
		if(is_array($this->component->options['type']) 
			&& $this->component->options['type'][$this->component->current_index] == 'form'
			|| $this->component->options['type'] == 'form')
		{
			$this->data->component_content = \View::forge(\Backend\Helper\Component::$current_index,$this->data);
			$view = 'backend::overlay_form';
		}

		if($this->_template != false)
		{
			$this->data->component_content = \View::forge($this->_template,$this->data);
		}
			
		return \Response::forge(\View::forge($view,$this->data));
	}
}