<!DOCTYPE html>
<html>
<head>
	<title><?php print $title; ?></title>
	<?php
		print Asset::css('bootstrap.min.css');
		print Asset::css('bootstrap-responsive.min.css');
		print Asset::css('autocomplete.css');
		print Asset::js('jquery-1.7.2.min.js');
		print Asset::js('jquery-ui.min.js');
		print Asset::js('ajax_load.js');
		print \Helper\JsVarBase::render();
	?>
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/component/logincenter/logincenter.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/public/redmond/jquery-ui-1.8.19.custom.css'); ?>">
	<script type="text/javascript">
	var logins = [];
	</script>
</head>
<body>
	<div class="logincenter-container">
		<label><?php print __('global.username'); ?></label>
		<input type="text" name="username" />
		<label><?php print __('global.password'); ?></label>
		<input type="password" name="password" />
		<?php print \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
		<div class="action">
			<button class="btn btn-primary"><?php print __('global.login'); ?></button>
		</div>
	    <?php print Helper\AjaxLoader::render('.action button:eq(0)',
	    	false,
	    	\Uri::create('logincenter/action/login_attempt'),
	    	'username->input[name=username],pass->input[name=password],fuel_csrf_token->input[name=fuel_csrf_token]'); ?>
	</div>
</body>
</html>