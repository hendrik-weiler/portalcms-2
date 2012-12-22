<?php

namespace Rpg_editor;

class Controller_Administration extends \BackendController
{
	public function action_index()
	{
		if(!is_dir(DOCROOT . 'uploads/rpg_editor'))
			\File::create_dir(DOCROOT . 'uploads','rpg_editor');

		if(!is_dir(DOCROOT . 'uploads/rpg_editor/project1'))
		{
			\File::create_dir(DOCROOT . 'uploads/rpg_editor','project1');

			\File::create_dir(DOCROOT . 'uploads/rpg_editor/project1','game_data');
			\File::create_dir(DOCROOT . 'uploads/rpg_editor/project1/game_data','maps');
			\File::create_dir(DOCROOT . 'uploads/rpg_editor/project1/game_data','events');
			\File::create_dir(DOCROOT . 'uploads/rpg_editor/project1/game_data','sprites');

			\File::create_dir(DOCROOT . 'uploads/rpg_editor/project1','lib');
			\File::create_dir(DOCROOT . 'uploads/rpg_editor/project1','sprites');
		}	

		$this->data->maps = \File::read_dir(DOCROOT . 'uploads/rpg_editor/project1/game_data/maps',1);
		$this->data->events = \File::read_dir(DOCROOT . 'uploads/rpg_editor/project1/game_data/events',1);
		$this->data->sprites = \File::read_dir(DOCROOT . 'uploads/rpg_editor/project1/game_data/sprites',1);
	}

	public function action_material_upload()
	{
		$this->no_render();

		$sprite_template = "
			$.sprite[%id%] = new rpg_sprite({
				label : '%label%',
				source : '%path%',
				height: %height%,
				width: %width%
			});
		";

		$sprites_dir = \File::read_dir(DOCROOT . 'uploads/rpg_editor/project1/game_data/sprites',1);

		$config = array(
		    'path' => DOCROOT . 'uploads/rpg_editor/project1/sprites',
		    'randomize' => true,
		    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
		);

		// process the uploaded files in $_FILES
		\Upload::process($config);

		// if there are any valid files
		if (\Upload::is_valid())
		{
		    // save them according to the config
		    \Upload::save();

			foreach(\Upload::get_files() as $file)
			{
				$base_path = 'uploads/rpg_editor/project1/sprites/' . $file['saved_as'];
				$path = \Uri::create($base_path);
				$sizes = \Image::sizes(DOCROOT . $base_path);

				$label = basename(DOCROOT . 'uploads/rpg_editor/project1/game_data/sprites/' . $file['filename']);

				\File::create(DOCROOT . 'uploads/rpg_editor/project1/game_data/sprites','sprite_' . count($sprites_dir) . '.js', str_replace(
					array(
						'%id%',
						'%label%',
						'%path%',
						'%width%',
						'%height%',
					), 
					array(
						count($sprites_dir),
						$label,
						$path,
						$sizes->width,
						$sizes->height
					),
					$sprite_template)
				);
			}
		}

		\Response::redirect('rpg_editor/administration/Editor?current_map=' . \Input::post('map_id'));
	}
}