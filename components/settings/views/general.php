<script type="text/javascript" src="<?php print Uri::create('server/component/settings/avatar.js'); ?>"></script>
<div class="settings-container">
	<?php 
		\Lang::load('install::layout');
		\Lang::load('install::messages'); 
	?>

	<div class="row">
		<div class="span3">
			<h3><?php print __('edit_account') ?></h3>
			<label><?php print __('3.avatar') ?></label>
			<div id="avatar" style="display:none">
				<a class="thumbnail" style="width:96px;height:96px" href="">
					<img src="">
				</a>
			</div>	
	<?php print Form::open(array('action'=>'settings/action/update_account_general','enctype'=>'multipart/form-data','class'=>'general_setting')); ?>
		<?php print Form::hidden('_redirect',\Uri::create('settings/administration/general')); ?>
		<?php print Form::hidden('_current',\Uri::create('settings/administration/general')); ?>
		<?php print Form::hidden('avatar_source','') ?>
			<?php print Form::file('avatar',array('class'=>'avatar_upload')); ?>
			<label><?php print __('old_pw') ?></label>
			<input type="password" name="old_password">
			<label><?php print __('new_pw') ?></label>
			<input type="password" name="new_password">
			<label><?php print __('new_pw_repeat') ?></label>
			<input type="password" name="new_password_repeat">
		</div>
	</div>
	<div class="row">
		<div class="form-actions">
			<input type="submit" class="btn btn-primary" value="<?php print __('global.save') ?>">
		</div>
	</div>
	<?php print Form::close(); ?>
    <?php 
    	print Helper\AjaxLoader::render(
    		'.general_setting',
    		__('messages'),
	    	\Uri::create('settings/administration/general'),
	    	\Uri::create('settings/action/update_account_general')
    	); 
    ?>
</div>