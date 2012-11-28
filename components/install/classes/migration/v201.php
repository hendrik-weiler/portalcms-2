<?php

namespace Install\Migration;

class v201 implements \Install\p2migration
{
	public function get_info()
	{
		return array(
			'version' => '2.01',
			'description' => 'Test description'
		);
	}

	public function update($languages)
	{

	}

	public function remove()
	{

	}
}