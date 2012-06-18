<div class="row">
	<div class="span3">
		<h3><?php print __('3.header-acc') ?></h3>
		<label><?php print __('3.avatar') ?></label>
		<div id="avatar" style="display:none">
			<a class="thumbnail" style="width:96px;height:96px" href="">
				<img src="">
			</a>
		</div>	
<?php print Form::open(array('action'=>'install/action/create_account','enctype'=>'multipart/form-data','class'=>'install3')); ?>
	<?php print Form::hidden('_redirect',\Uri::create('install/4')); ?>
	<?php print Form::hidden('_current',\Uri::create('install/3')); ?>
	<?php print Form::hidden('avatar_source','') ?>
		<?php print Form::file('avatar',array('class'=>'avatar_upload')); ?>
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
		<input type="submit" class="btn btn-primary" value="<?php print __('3.create') ?>">
	</div>
</div>
    <?php 
    	print Helper\AjaxLoader::render(
    		'.install3',
    		__('messages'),
	    	\Uri::create('install/4'),
	    	\Uri::create('install/action/create_account')
    	); 
    ?>
<?php print Form::close(); ?>