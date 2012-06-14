<!DOCTYPE html>
<html>
<head>
	<title>Backend</title>
	<?php print Asset::css('bootstrap.min.css') ?>
	<?php print Asset::js('jquery-1.7.2.min.js') ?>
	<?php print Asset::js('ajax_load.js') ?>
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/component/backend/overlay.css'); ?>">
</head>
<body>
	<div class="row head">
		<div class="span4">
				<img class="thumbnail" src="<?php print \Uri::create('uploads/avatars/' . $account->id . '/medium/' . $avatar->picture); ?>" />
				<?php print $account->username; ?>
				<button id="logout" class="btn btn-primary"><?php print __('global.logout') ?></button>
				<?php print Form::select('language',\Session::get('current_language',\db\Language::getLanguages())) ?>
		</div>
		<div class="span12">
			<ul>
			<?php foreach($components as $component): ?>
				<li>
					<a href="<?php \Uri::Create(print $component->nav_url); ?>"><?php print $component->label->default; ?></a>
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