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
    	<button type="submit" class="btn btn-primary"><?php print __('global.next') ?></button>
    </div>
    <?php print Helper\AjaxLoader::render('.form-actions button:eq(0)',
    	\Uri::create('install/2'),
    	\Uri::create('install/action/check_login'),
    	'dev_user->input[name=dev_user],dev_pass->input[name=dev_pass],
    	 prod_user->input[name=prod_user],prod_pass->input[name=prod_pass],db->input[name=database]'); ?>