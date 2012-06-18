<?php print Form::open(array('action'=>'install/action/check_login','class'=>'install1')); ?>
	<?php print Form::hidden('_redirect',\Uri::create('install/2')); ?>
	<?php print Form::hidden('_current',\Uri::create('install/1')); ?>
	<div class="row">
		<div class="span4">
			<h3><?php print __('1.develop_label') ?></h3>
		    <label><?php print __('1.user') ?></label>
		    <input type="text" name="dev_user" value="<?php print $dev_user ?>">
		    <label><?php print __('1.pass') ?></label>
		    <input type="text" name="dev_pass" value="<?php print $dev_pass ?>">
    	</div>

		<div class="span4">
			<h3><?php print __('1.prod_label') ?></h3>
		    <label><?php print __('1.user') ?></label>
		    <input type="text" name="prod_user" value="<?php print $prod_user ?>">
		    <label><?php print __('1.pass') ?></label>
		    <input type="text" name="prod_pass" value="<?php print $prod_pass ?>">
    	</div>
	</div>
	<div class="row">
		<div class="span4">
			<h3><?php print __('1.db'); ?></h3>
			<input type="text" name="database" value="<?php print $db ?>" />
			<p class="help-block"><?php print __('1.db_help') ?></p>
		</div>
	</div>
    <div class="form-actions">
    	<input type="submit" class="btn btn-primary" value="<?php print __('global.next') ?>" />
    </div>
    <?php 
    	print Helper\AjaxLoader::render(
    		'.install1',
    		__('messages'),
	    	\Uri::create('install/2'),
	    	\Uri::create('install/action/check_login')
    	); 
    ?>
<?php print Form::close(); ?>