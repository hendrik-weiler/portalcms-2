<?php

namespace Install;

class Controller_Action extends \Controller
{
	private $_error_messages = array(
		1 => array(
			'status' => 200,
			'title'	 => 'Successful',
			'message'=>	'Everything went fine!'
		),
		2 => array(
			'status' => 404,
			'title'	 => 'Wrong Username or Password',
			'message'=>	'You have typed in a wrong username or password.<br />Usually its 
			<code>username:root
			password:root or empty</code>'
		),
		3 => array(
			'status' => 404,
			'title'	 => 'Database doenst exist.',
			'message'=>	'The database name you have entered is invalid.'
		),
		4 => array(
			'status' => 404,
			'title'	 => 'Password doenst match',
			'message'=>	'One of the passwords doenst match.'
		),
		5 => array(
			'status' => 404,
			'title'	 => 'No Avatar selected',
			'message'=>	'You have not yet selected an avatar'
		),
		6 => array(
			'status' => 404,
			'title'	 => 'Too short!',
			'message'=>	'Username and password have to be atleast 4 characters length'
		),
		7 => array(
			'status' => 200,
			'title'	 => 'Successful',
			'message'=>	'Install tool disabled successfully.'
		),
	);

	private function _delete_trash_images($id,$image)
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

	public function action_check_login()
	{
		$dev_user = \Input::get('dev_user');
		$dev_pass = \Input::get('dev_pass');
		$prod_user = \Input::get('prod_user');
		$prod_pass = \Input::get('prod_pass');
		$db = \Input::get('db');

		$response = \Helper\AjaxLoader::to_r($this->_error_messages[1]);

		$link = @mysql_connect('localhost',$dev_user, $dev_pass);
		$db_query = mysql_query("CREATE DATABASE IF NOT EXISTS " . $db . ";");
		if (!$link) 
		{
		    $response = \Helper\AjaxLoader::to_r($this->_error_messages[2]);
		}
		else if(!$db_query)
		{
			$response = \Helper\AjaxLoader::to_r($this->_error_messages[3]);
		}
		else
		{
			$this->_write_database_files($dev_user,$dev_pass,$prod_user,$prod_pass,$db);
		}

		$this->response->body = \Helper\AjaxLoader::response($response);
	}

	public function action_update_database()
	{
		$updates = \Input::get('update');
		
		$class = '\\Install\\Migration\\v' . str_replace('.php', '', str_replace('.','',$updates));
		$migration = new $class();
		$migration->update(\db\Language::getLanguagesDatabaseUpdate());

		$result = array('status'=>true);

		$dbu = \db\Option::getKey('database_updates');
		$value = json_decode($dbu->value);
		array_push($value, $updates);

		$dbu->value = json_encode(array_unique($value));
		$dbu->save();

		$dbv = \db\Option::getKey('database_version');
		$dbv->value = $updates;
		$dbv->save();

		print json_encode($result);
	}

	public function action_create_account()
	{
		$avatar_source = \Input::get('avatar_source');
		$avatar_source = empty($avatar_source) ? ';' : $avatar_source;
		$avatar_source = explode(';', $avatar_source);
		$image = $avatar_source[0];
		$id = $avatar_source[1];

		$username = \Input::get('username');
		$password = \Input::get('pass');
		$password_repeat = \Input::get('pass_repeat');

		$username = str_replace(' ','_',$username);

		if(empty($image) || empty($id))
		{
			$response = \Helper\AjaxLoader::to_r($this->_error_messages[5]);
		}
		else if(strlen($username) < 4 || strlen($password) < 4)
		{
			$response = \Helper\AjaxLoader::to_r($this->_error_messages[6]);	
		}
		else if($password == $password_repeat)
		{
			$account = new \db\AccountsBackend();
			$account->username = $username;
			$account->password = sha1($password);
			$account->language = 'en';
			$account->session = 'logout_' . sha1($password) . sha1($username);
			$account->admin = 1;
			$account->permissions = '';
			$account->save();

			$avatar = new \db\AccountsAvatars();
			$avatar->account_id = \db\AccountsBackend::find('last')->id;
			$avatar->picture = $image;
			$avatar->save();

			$this->_delete_trash_images($id,$image);
			$response = \Helper\AjaxLoader::to_r($this->_error_messages[1]);
		}
		else
		{
			$response = \Helper\AjaxLoader::to_r($this->_error_messages[4]);
		}

		$this->response->body = \Helper\AjaxLoader::response($response);
	}

	public function action_upload_picture()
	{
		$last = \DB::query("SHOW TABLE STATUS LIKE 'accounts_backend'", \DB::SELECT)->execute()->as_array();
		$next = 0;
		if($last == false)
			$next = 1;
		else
			$next = $last[0]['Auto_increment'];

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

		    print json_encode(
				array(
		    		'original'=>\Uri::create('uploads/avatars/' . $next . '/original/' . $file[0]['saved_as']),
		    		'big'=>\Uri::create('uploads/avatars/' . $next . '/big/' . $file[0]['saved_as']),
		    		'medium'=>\Uri::create('uploads/avatars/' . $next . '/medium/' . $file[0]['saved_as']),
		    		'small'=>\Uri::create('uploads/avatars/' . $next . '/small/' . $file[0]['saved_as']),
		    		'filename' => $file[0]['saved_as'],
		    		'account_num' => $next
			    )
		    );
		}
	}

	public function action_disable_install_tool()
	{
		\File::create(DOCROOT . '../','DISABLE_INSTALL_TOOL','This file disables the install tool');

		$this->response->body = \Helper\AjaxLoader::response(
			\Helper\AjaxLoader::to_r($this->_error_messages[7])
		);
	}
}