<?php
		print Form::open(Uri::create('cassistant/action/create_component'));

		print Form::label(__('form.name'));
		print Form::input('name','');

		print Form::label(__('form.options'));

		print Form::label(__('form.visible'));
		print Form::checkbox('visible',1);

		print Form::label(__('form.has_index'));
		print Form::checkbox('has_index',1);

		print Form::label(__('form.labels'));

		print '<a href="#" id="new_label">' . __('form.new_label') . '</a>';
?>
		<div class="label-container">

		<div class="label_entry row">
			<div class="span2">
				<?php print Form::label(__('form.entry_label')); ?>
				<?php print Form::input('entry_label[]','default',array('style'=>'width:120px;')); ?>
			</div>
			<div class="span4">
				<?php print Form::label(__('form.entry_value')); ?>
				<?php print Form::input('entry_value[]',''); ?>
			</div>
			<div class="span2">
				<?php print Form::label('&nbsp;'); ?>
				<?php print '<a href="#" id="delete_label">' . __('form.delete_label') . '</a>'; ?>
			</div>
		</div>

		</div>

<div class="form-actions">
<?php
		print Form::submit('save',__('global.save'), array('class' => 'btn btn-primary'));
		print ' ';
		print Form::submit('back',__('global.back'), array('class' => 'btn btn-secondary'));
?>
</div>

<?php print Form::close(); ?>

<script type="text/javascript" src="<?php print \Uri::create('server/component/cassistant/test.js') ?>"></script>