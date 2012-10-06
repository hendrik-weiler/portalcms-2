<?php

namespace Cupdateradmin;

class Controller_Action extends \AuthController
{
	public function before()
	{
		\Lang::load('messages');
	}

	public function action_save()
	{
		$input = \Helper\AjaxLoader::get_input();

		$response = \Helper\AjaxLoader::to_r(__('messages.1'));

		if(!is_dir(DOCROOT . 'repository'))
			\File::create_dir(DOCROOT, 'repository');

		$info = new \db\Component\Info();
		$info->author = $input['author'];
		$info->version = $input['version'];
		$info->category = $input['category'];
		$info->name = $input['name'];
		$info->description = $input['description'];
		$info->preview_index = $input['preview_index'];
		$info->save();

		$last_info = \db\Component\Info::find('last');

		if(!is_dir(DOCROOT . 'repository/' . $last_info->id))
			\File::create_dir(DOCROOT . 'repository', $last_info->id);

		$config = array(
		    'path' => DOCROOT.'repository/' . $last_info->id,
		    'randomize' => true,
		    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png', 'zip'),
		);

		// process the uploaded files in $_FILES
		\Upload::process($config);

		// if there are any valid files
		if (\Upload::is_valid())
		{
		    // save them according to the config
		    \Upload::save();

		    $pictures = array();
		    foreach(\Upload::get_files() as $file)
		    {
		    	if($file['extension'] == 'zip')
		    	{
		    		$last_info->package = $file['saved_as'];
		    	}
		    	else
		    	{
		    		\Image::load(DOCROOT . 'repository/' . $last_info->id . '/' . $file['saved_as'])
		    			->crop_resize(96,96)
		    			->save(DOCROOT . 'repository/' . $last_info->id . '/thumb_' . $file['saved_as']);
		    		$pictures[] = $file['saved_as'];
		    	}
		    }

			$last_info->pictures = json_encode($pictures);
			$last_info->save();
		}

		return \Helper\AjaxLoader::get_response($input, $response);
	}

	public function action_edit_save()
	{
		$input = \Helper\AjaxLoader::get_input();

		$response = \Helper\AjaxLoader::to_r(__('messages.1'));

		if(!is_dir(DOCROOT . 'repository'))
			\File::create_dir(DOCROOT, 'repository');

		$info = \db\Component\Info::find($this->param('id'));
		$last_info = $info;
		$info->author = $input['author'];
		$info->version = $input['version'];
		$info->category = $input['category'];
		$info->name = $input['name'];
		$info->description = $input['description'];
		$info->preview_index = $input['preview_index'];
		$info->save();

		if(!is_dir(DOCROOT . 'repository/' . $last_info->id))
			\File::create_dir(DOCROOT . 'repository', $last_info->id);

		$config = array(
		    'path' => DOCROOT.'repository/' . $last_info->id,
		    'randomize' => true,
		    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png', 'zip'),
		);

		if(!empty($input['back']))
		{
			\Response::redirect('cupdateradmin/administration');
		}

		// process the uploaded files in $_FILES
		\Upload::process($config);

		// if there are any valid files
		if (\Upload::is_valid())
		{
		    // save them according to the config
		    \Upload::save();

		    $pictures = empty($last_info->pictures) ? array() : json_decode($last_info->pictures);
		    foreach(\Upload::get_files() as $file)
		    {
		    	if($file['extension'] == 'zip')
		    	{
		    		if(file_exists(DOCROOT . 'repository/' . $last_info->id . '/' . $last_info->package))
		    			unlink(DOCROOT . 'repository/' . $last_info->id . '/' . $last_info->package);

		    		$last_info->package = $file['saved_as'];
		    	}
		    	else
		    	{
		    		\Image::load(DOCROOT . 'repository/' . $last_info->id . '/' . $file['saved_as'])
		    			->crop_resize(96,96)
		    			->save(DOCROOT . 'repository/' . $last_info->id . '/thumb_' . $file['saved_as']);
		    		$pictures[] = $file['saved_as'];
		    	}
		    }

			$last_info->pictures = json_encode($pictures);
			$last_info->save();
		}

		return \Helper\AjaxLoader::get_response($input, $response);
	}
}