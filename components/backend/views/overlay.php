<!DOCTYPE html>
<html>
<head>
	<title>Backend</title>
	<?php print Asset::css('bootstrap.min.css') ?>
	<?php print Asset::js('jquery-1.7.2.min.js') ?>
	<?php print Asset::js('ajax_load.js') ?>
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/component/backend/overlay.sass'); ?>">
</head>
<body>
	<div class="row head">
		<div class="span4 account">
				<div class="avatar_pic">
					<img class="thumbnail" src="<?php print \Uri::create('uploads/avatars/' . $account->id . '/medium/' . $avatar->picture); ?>" />
				</div>
				<div class="avatar_content">
					<h4><?php print $account->username; ?></h4>
					<a href=""><?php print __('global.settings') ?></a>
					<button id="logout" class="btn btn-primary"><?php print __('global.logout') ?></button>
				</div>
		</div>
		<div class="span12 main_nav">
			<!-- <?php print Form::select('language',\Session::get('current_language',\db\Language::getLanguages())) ?> -->
			<ul>
			<?php foreach($components as $component): ?>
				<li>
					<a <?php \Uri::segment(1) == $component->name and print 'class="active"' ?> href="<?php \Uri::Create(print $component->nav_url); ?>"><?php print $component->label->default; ?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="body">
		<?php print $content; ?>
	</div>
    <?php print Helper\AjaxLoader::render('#logout',
    	\Uri::create('logincenter'),
    	\Uri::create('logincenter/action/logout'),
    	''); ?>
</body>
</html>