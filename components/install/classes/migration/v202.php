<?php

namespace Install\Migration;

class v202 implements \Install\p2migration
{
	public function get_info()
	{
		return array(
			'version' => '2.02',
			'description' => 'Another Test description'
		);
	}

	public function update($languages)
	{
	}

	public function remove()
	{

	}
}