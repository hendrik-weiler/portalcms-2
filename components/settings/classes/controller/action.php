<?php

namespace Settings;

class Controller_Action extends \AuthController
{
	public function before()
	{
		\Lang::load('install::messages');
	}

	public function action_upload_picture()
	{
		$info = \Backend\Helper\Account::info('account');

		$next = $info->id;

		$config = array(
		    'path' => DOCROOT.DS.'uploads/avatars/' . $next . '/original',
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
		    $file = \Upload::get_files();
		    $pathes = 	array(
	    		'original'=>DOCROOT.'uploads/avatars/' . $next . '/original/' . $file[0]['saved_as'],
	    		'big'=>DOCROOT.'uploads/avatars/' . $next . '/big/' . $file[0]['saved_as'],
	    		'medium'=>DOCROOT.'uploads/avatars/' . $next . '/medium/' . $file[0]['saved_as'],
	    		'small'=>DOCROOT.'uploads/avatars/' . $next . '/small/' . $file[0]['saved_as']
		    );

		    if(!is_dir(DOCROOT.'uploads/avatars/' . $next . '/big'))
		    {
			    \File::create_dir(DOCROOT.'uploads/avatars/' . $next,'big');
			    \File::create_dir(DOCROOT.'uploads/avatars/' . $next,'medium');
			    \File::create_dir(DOCROOT.'uploads/avatars/' . $next,'small');
		    }

		    \Image::load($pathes['original'])
				    ->crop_resize(96, 96)
				    ->save($pathes['big']);

			\Image::load($pathes['original'])
				    ->crop_resize(64, 64)
				    ->save($pathes['medium']);

			\Image::load($pathes['original'])
				    ->crop_resize(32, 32)
				    ->save($pathes['small']);
		}

	    return \Response::forge( json_encode(
			array(
	    		'original'=>\Uri::create('uploads/avatars/' . $next . '/original/' . $file[0]['saved_as']),
	    		'big'=>\Uri::create('uploads/avatars/' . $next . '/big/' . $file[0]['saved_as']),
	    		'medium'=>\Uri::create('uploads/avatars/' . $next . '/medium/' . $file[0]['saved_as']),
	    		'small'=>\Uri::create('uploads/avatars/' . $next . '/small/' . $file[0]['saved_as']),
	    		'filename' => $file[0]['saved_as'],
	    		'account_num' => $next
		    )
	    ));
	}

	public function action_update_account_general()
	{
		$input = \Helper\AjaxLoader::get_input();

		$data = \Backend\Helper\Account::info();
		$account = $data->account;
		$avatar = $data->avatar;

		$avatar_source = $input['avatar_source'];
		$avatar_source = empty($avatar_source) ? ';' : $avatar_source;
		$avatar_source = explode(';', $avatar_source);
		$image = $avatar_source[0];
		$id = $account->id;

		$old_password = $input['old_password'];
		$new_password = $input['new_password'];
		$new_password_repeat = $input['new_password_repeat'];

		if(!empty($old_password) 
			&& !empty($new_password) 
			&& !empty($new_password_repeat))
		{
			if(strlen($old_password) < 4 || strlen($new_password) < 4 || strlen($new_password_repeat) < 4)
			{
				$input['error_code'] = 6;
				$response = \Helper\AjaxLoader::to_r(__('messages.6'));
				return \Helper\AjaxLoader::get_response($input, $response);	
			}
		}

		if(!empty($old_password) && sha1($old_password) != $account->password)
		{
			$input['error_code'] = 6;
			$response = \Helper\AjaxLoader::to_r(__('messages.6'));
			return \Helper\AjaxLoader::get_response($input, $response);
		}

		if(!empty($old_password))
			$account->password = sha1($new_password);

		$account->save();

		if(!empty($image) || count(\Upload::get_files()) > 0)
		{
			if(!$input['ajax_call'])
			{	
				$avatar_pic = $this->action_upload_picture($input);
				$avatar_pic = json_decode($avatar_pic->body,true);
				$id = $avatar_pic['account_num'];
				$image = $avatar_pic['filename'];
			}

			$avatar->picture = $image;
			$avatar->save();
		}

		if(!empty($image))
			\Install\Controller_Action::_delete_trash_images($id,$image);

		$response = \Helper\AjaxLoader::to_r(__('messages.1'));

		return \Helper\AjaxLoader::get_response($input, $response);
	}
}