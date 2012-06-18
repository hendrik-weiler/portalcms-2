<link rel="stylesheet" type="text/css" href="<?php print \Uri::create('server/component/settings/settings.sass'); ?>">
<div class="settings-container">
	<?php print Form::open(''); ?>

	<?php print Form::input('name') ?>

	<div class="form-actions">
		<?php print Form::submit('action',__('global.button.save'),array('class'=>'btn btn-primary')) ?>
	</div>

	<?php print Form::close(); ?>
</div>