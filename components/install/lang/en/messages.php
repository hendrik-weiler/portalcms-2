<?php

return array(
	'messages' => array(

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

	)
);