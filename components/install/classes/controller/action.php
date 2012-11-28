<?php

namespace Install;

class Controller_Action extends \Controller
{
	public static function _delete_trash_images($id,$image)
	{
		$folder = \File::read_dir(DOCROOT . 'uploads/avatars/' . $id . '/original',true);
		foreach ($folder as $file) 
		{
			if($file != $image)
				\File::delete(DOCROOT . 'uploads/avatars/' . $id . '/original/' . $file);
		}

		$folder = \File::read_dir(DOCROOT . 'uploads/avatars/' . $id . '/big',true);
		foreach ($folder as $file) 
		{
			if($file != $image)
				\File::delete(DOCROOT . 'uploads/avatars/' . $id . '/big/' . $file);
		}

		$folder = \File::read_dir(DOCROOT . 'uploads/avatars/' . $id . '/medium',true);
		foreach ($folder as $file) 
		{
			if($file != $image)
				\File::delete(DOCROOT . 'uploads/avatars/' . $id . '/medium/' . $file);
		}

		$folder = \File::read_dir(DOCROOT . 'uploads/avatars/' . $id . '/small',true);
		foreach ($folder as $file) 
		{
			if($file != $image)
				\File::delete(DOCROOT . 'uploads/avatars/' . $id . '/small/' . $file);
		}
	}

	private function _write_database_files($dev_user,$dev_pass,$prod_user,$prod_pass,$db)
	{
		$php = "<?php
				return array(
					'default' => array(
						'connection'  => array(
							'dsn'        => 'mysql:host=localhost;dbname=%database%',
							'username'   => '%username%',
							'password'   => '%password%',
						),
					),
				);
				";

		$php_new = str_replace(array(
			'%database%','%username%','%password%'
		), array(
			$db,$dev_user,$dev_pass
		), $php);

		\File::update(APPPATH . 'config/development', 'db.php', $php_new);

		$php_new = str_replace(array(
			'%database%','%username%','%password%'
		), array(
			$db,$prod_user,$prod_pass
		), $php);

		\File::update(APPPATH . 'config/production', 'db.php', $php_new);

		$content = array(
			'dev_user' => $dev_user,
			'dev_pass' => $dev_pass,
			'prod_user' => $prod_user,
			'prod_pass' => $prod_pass,
			'db' => $db
		);

		if(!file_exists(DOCROOT . '../components/install/step1.bak'))
			\File::create(DOCROOT . '../components/install','step1.bak',json_encode($content));
		else
			\File::update(DOCROOT . '../components/install','step1.bak',json_encode($content));

	}

	public function before()
	{
		\Lang::load('messages');
	}

	public function action_check_login()
	{
		$input = \Helper\AjaxLoader::get_input();
		$dev_user = $input['dev_user'];
		$dev_pass = $input['dev_pass'];
		$prod_user = $input['prod_user'];
		$prod_pass = $input['prod_pass'];
		$db = $input['database'];

		$response = \Helper\AjaxLoader::to_r(__('messages.1'));

		$status = true;

		$link = @mysql_connect('localhost',$dev_user, $dev_pass);

		if($link)
			$db_query = mysql_query("CREATE DATABASE IF NOT EXISTS " . $db . ";",$link);

		if (!$link) 
		{
			$input['error_code'] = 2;
		    $response = \Helper\AjaxLoader::to_r(__('messages.2'));
		}
		else if(!$db_query)
		{
			$input['error_code'] = 3;
			$response = \Helper\AjaxLoader::to_r(__('messages.3'));
		}
		else
		{
			$this->_write_database_files($dev_user,$dev_pass,$prod_user,$prod_pass,$db);
			if(!file_exists(DOCROOT . '../DATABASE_FINISHED'))
			\File::create(DOCROOT . '../','DATABASE_FINISHED','This file helps portalcms2 to work.');
		}

		return \Helper\AjaxLoader::get_response($input, $response);
	}

	public function action_update_database()
	{
		$input = \Helper\AjaxLoaderProgress::get_input();

		function migrate($updates)
		{
			$class = '\\Install\\Migration\\v' . str_replace('.php', '', str_replace('.','',$updates));
			$migration = new $class();
			$migration->update(\db\Language::getLanguagesDatabaseUpdate());
		}

		if($input['ajax_call'])
		{
			$updates = $input['update'];

			migrate($updates);
			$result = array('status'=>true);

			$dbu = \db\Option::getKey('database_updates');
			$value = json_decode($dbu->value);
			array_push($value, $updates);

			$dbu->value = json_encode(array_unique($value));
			$dbu->save();

			$dbv = \db\Option::getKey('database_version');
			$dbv->value = $updates;
			$dbv->save();
		}
		else
		{
			$version_updates = json_decode($input['in_progress']);
			foreach ($version_updates as $value) 
				migrate($value);

			$dbu = \db\Option::getKey('database_updates');
			$value = json_decode($dbu->value);
			$value = $value + $version_updates;

			$dbu->value = json_encode(array_unique($value));
			$dbu->save();

			$dbv = \db\Option::getKey('database_version');
			$dbv->value = $version_updates[count($version_updates)-1];
			$dbv->save();
		}

		if(!file_exists(DOCROOT . '../DATABASE_FINISHED'))
		\File::create(DOCROOT . '../','DATABASE_FINISHED','This file helps portalcms2 to work.');

		return \Helper\AjaxLoaderProgress::get_response($input, json_encode($result));
	}

	public function action_create_account()
	{
		$input = \Helper\AjaxLoaderProgress::get_input();
		$avatar_source = $input['avatar_source'];
		$avatar_source = empty($avatar_source) ? ';' : $avatar_source;
		$avatar_source = explode(';', $avatar_source);
		$image = $avatar_source[0];
		$id = $avatar_source[1];

		$username = $input['username'];
		$password = $input['password'];
		$password_repeat = $input['password_repeat'];

		$username = str_replace(' ','_',$username);

		if($input['ajax_call'])
		{
			if(empty($image) || empty($id))
			{
				$input['error_code'] = 5;
				$response = \Helper\AjaxLoader::to_r(__('messages.5'));
				return \Helper\AjaxLoader::get_response($input, $response);
			}
		}
		else
		{
			if(count(\Upload::get_files()) == 0)
			{
				$input['error_code'] = 5;
				return \Helper\AjaxLoader::get_response($input, $response);
			}
		}

		if(strlen($username) < 4 || strlen($password) < 4)
		{
			$input['error_code'] = 6;
			$response = \Helper\AjaxLoader::to_r(__('messages.6'));
			return \Helper\AjaxLoader::get_response($input, $response);	
		}

		if($password != $password_repeat)
		{
			$input['error_code'] = 5;
			$response = \Helper\AjaxLoader::to_r(__('messages.5'));
			return \Helper\AjaxLoader::get_response($input, $response);
		}

		$account = new \db\Accounts();
		$account->username = $username;
		$account->password = sha1($password);
		$account->language = 'en';
		$account->session = 'logout_' . sha1($password) . sha1($username);
		$account->group = 1;
		$account->save();

		if(!$input['ajax_call'])
		{	
			$avatar = $this->action_upload_picture($input);
			$avatar = json_decode($avatar->body,true);
			$id = $avatar['account_num'];
			$image = $avatar['filename'];
		}

		$avatar = new \db\AccountsAvatars();
		$avatar->account_id = \db\Accounts::find('last')->id;
		$avatar->picture = $image;
		$avatar->save();

		static::_delete_trash_images($id,$image);
		$response = \Helper\AjaxLoader::to_r(__('messages.1'));

		return \Helper\AjaxLoader::get_response($input, $response);
	}

	public function action_upload_picture($input=array())
	{
		$last = \DB::query("SHOW TABLE STATUS LIKE 'accounts'", \DB::SELECT)->execute()->as_array();
		$next = 0;
		if($last == false)
			$next = 1;
		else
			$next = $last[0]['Auto_increment'];

		if(isset($input['ajax_call']) && !$input['ajax_call'])
			$next -= 1;

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
	}

	public function action_disable_install_tool()
	{
		$input = \Helper\AjaxLoaderProgress::get_input();

		\File::create(DOCROOT . '../','DISABLE_INSTALL_TOOL','This file disables the install tool');

		return \Helper\AjaxLoader::get_response($input, 
			\Helper\AjaxLoader::to_r(__('messages.7'))
		);
	}

	public function after($response)
	{
		return $response;
	}
}