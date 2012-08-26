<!DOCTYPE html>
<html>
<head>
	<title><?php print $title; ?></title>
	<?php
		print Asset::css('bootstrap.min.css');
		print Asset::css('autocomplete.css');

		print \Helper\JsVarBase::render();
		print Asset::js('jquery-1.7.2.min.js');
		print Asset::js('jquery-ui.min.js');
		print Asset::js('jquery.ocupload-1.1.2.min.js');
		print Asset::js('jquery.base64.min.js');
		print Asset::js('bootstrap.min.js');
		print Asset::js('storage.js');
		print Asset::js('tooltip.js');
	?>
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/component/backend/overlay.sass'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/public/redmond/jquery-ui-1.8.19.custom.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php print \Uri::create('server/component/' . Backend\Helper\Component::$name . '/' . Backend\Helper\Component::$name . '.sass'); ?>">
</head>
<body>
	<div class="row head">
		<div class="span4 account">
			<div class="avatar_pic">
				<img class="thumbnail" src="<?php print \Uri::create('uploads/avatars/' . $account->id . '/medium/' . $avatar->picture); ?>" />
			</div>
			<div class="avatar_content arrow">
				<h4><?php print $account->username; ?></h4>
				<a <?php \Uri::segment(1) == 'settings' and print 'class="active2"' ?> href="<?php print \Uri::create('settings/administration') ?>"><?php print __('global.settings') ?></a>
				<a id="logout" href="<?php print \Uri::create('logincenter/action/logout'); ?>" class="btn btn-primary"><?php print __('global.logout') ?></a>
			</div>
		</div>
		<div class="main_nav">
			<!-- <?php print Form::select('language',\Session::get('current_language',\db\Language::getLanguages())) ?> -->
			<ul>
			<?php foreach($components as $component): ?>
				<?php if(isset($component->nav_visible) && $component->nav_visible): ?>
				<li>
					<a <?php \Uri::segment(1) == $component->name and print 'class="active"' ?> href="<?php print \Uri::Create($component->name . '/' . $component->nav_url); ?>"><?php print $component->label->default; ?></a>
				</li>
				<?php endif; ?>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="container">
		<div class="body">
			<?php print html_entity_decode($component_navigation); ?>
			<?php print $component_content; ?>
		</div>
	</div>
</body>
</html>