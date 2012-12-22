<?php

namespace Rpg_editor;

class Controller_Action extends \AuthController
{
	private $default_map_gen = "
	$.maps[%id%] = new rpg_map({
		id : %id%,
		label : 'Map %id%',
		coordinates_sprites : [],
		coordinates_blocked : []
	});

	$.maps[%id%].upper_layer = new rpg_map({
		coordinates_sprites : [],
		coordinates_blocked : []
	});
	";

	private $map_gen = "
	$.maps[%id%] = new rpg_map({
		id : %id%,
		label : '%label%',
		height : %height%,
		width : %width%,
		coordinates_sprites : %first_layer_coordinates_sprites%,
		coordinates_blocked : %first_layer_coordinates_blocked%
	});

	$.maps[%id%].upper_layer = new rpg_map({
		coordinates_sprites : %second_layer_coordinates_sprites%,
		coordinates_blocked : %second_layer_coordinates_blocked%
	});
	";


	public function action_add_map()
	{
		$maps = \File::read_dir(DOCROOT . 'uploads/rpg_editor/project1/game_data/maps',1);
		$map_id = count($maps);

		\File::create(DOCROOT . 'uploads/rpg_editor/project1/game_data/maps','map_' . $map_id . '.js', str_replace('%id%', $map_id, $this->default_map_gen));
	}

	private function parse_map_file($filepath)
	{
		$content = \File::read($filepath, true);
		$content = preg_replace('#\$\.maps\[([0-9]+)\] = new rpg_map\(#i', '[', $content);
		$content = preg_replace('#\$\.maps\[([0-9]+)\].upper_layer = new rpg_map\(\{#i', '},{', $content);
		$content = preg_replace_callback('#(.*)( )?:#i', function($result) {
			return '"' . trim($result[1]) . '" :';
		}, $content);
		$content = str_replace("'", '"', $content);
		$content = str_replace('});', '', $content);
		$content .= '}]';

		return json_decode($content,true);
	}

	public function action_save_map()
	{
		$map_id = \Input::get('map_id');

		$data = $this->parse_map_file(DOCROOT . 'uploads/rpg_editor/project1/game_data/maps/map_' . $map_id . '.js');

		$label = $data[0]['label'];
		$width = $data[0]['width'];
		$height = $data[0]['height'];

		//var_dump($label, $width, $height);exit;

		\File::update(DOCROOT . 'uploads/rpg_editor/project1/game_data/maps','map_' . $map_id . '.js', str_replace(
			array(
				'%id%',
				'%label%',
				'%width%',
				'%height%',
				'%first_layer_coordinates_sprites%',
				'%first_layer_coordinates_blocked%',
				'%second_layer_coordinates_sprites%',
				'%second_layer_coordinates_blocked%',
			), 
			array(
				$map_id,
				$label,
				$width,
				$height,
				\Format::forge(\Input::get('map_data_first_layer'))->to_json(),
				'[]',
				'[]',
				'[]'
			),
			$this->map_gen)
		);
	}

	public function action_change_map_settings()
	{
		$label = \Input::post('label');
		$height = \Input::post('height');
		$width = \Input::post('width');
		$map_id = \Input::post('map_id');

		$data = $this->parse_map_file(DOCROOT . 'uploads/rpg_editor/project1/game_data/maps/map_' . $map_id . '.js');

		

		\File::update(DOCROOT . 'uploads/rpg_editor/project1/game_data/maps','map_' . $map_id . '.js', str_replace(
			array(
				'%id%',
				'%label%',
				'%width%',
				'%height%',
				'%first_layer_coordinates_sprites%',
				'%first_layer_coordinates_blocked%',
				'%second_layer_coordinates_sprites%',
				'%second_layer_coordinates_blocked%',
			), 
			array(
				$map_id,
				$label,
				$width,
				$height,
				\Format::forge($data[0]['coordinates_sprites'])->to_json(),
				\Format::forge($data[0]['coordinates_blocked'])->to_json(),
				\Format::forge($data[1]['coordinates_sprites'])->to_json(),
				\Format::forge($data[1]['coordinates_blocked'])->to_json()
			),
			$this->map_gen)
		);
	}
}