<?php

namespace Install;

interface p2migration
{
	/**
	* Returns an array with 'description'-key and 'version'-key inside for explanation of the migration
	* @return array
	*/
	public function get_info();

	public function update($languages);

	public function remove();
}