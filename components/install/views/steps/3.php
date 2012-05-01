<div class="row">
	<div class="span3">
		<h3><?php print __('3.header-acc') ?></h3>
		<label><?php print __('3.avatar') ?></label>
		<div id="avatar">
			<a class="thumbnail" style="width:96px;height:96px" href="">
				<img src="">
			</a>
			<span class="hidden"></span>
		</div>	
		<label><?php print __('3.user') ?></label>
		<input type="text" name="username">
		<p class="help-block"><?php print __('3.notice') ?></p>
		<label><?php print __('3.pass') ?></label>
		<input type="password" name="password">
		<label><?php print __('3.pass_repeat') ?></label>
		<input type="password" name="password_repeat">
	</div>
	<div class="span5">
		<h3><?php print __('3.header-acclist') ?></h3>
		<ul class="thumbnails">
		<?php foreach($accounts as $account): ?>
			<li>
				<img class="thumbnail" src="<?php print \Uri::create('uploads/avatars/' . $account['account']->id . '/big/' . $account['avatar']->picture); ?>">
				<div style="text-align:center"><?php print $account['account']->username; ?></div>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="row">
	<div class="form-actions">
		<button class="btn btn-primary"><?php print __('3.create') ?></button>
		<button class="btn btn-secondary"><?php print __('global.next') ?></button>
	</div>
</div>
    <?php print Helper\AjaxLoader::render('.form-actions button:eq(0)',
    	\Uri::create('install/3'),
    	\Uri::create('install/action/create_account'),
    	'username->input[name=username],pass->input[name=password],
    	 pass_repeat->input[name=password_repeat],avatar_source->#avatar span'); ?>