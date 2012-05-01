<?php

namespace Install\Migration;

class v203 implements \Install\p2migration
{
	public function get_info()
	{
		return array(
			'version' => '2.03',
			'description' => 'Third Test description'
		);
	}

	public function update($languages)
	{
	}

	public function remove()
	{

	}
}