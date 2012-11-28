<script type="text/javascript" src="<?php print Uri::create('server/component/shop/test.coffee'); ?>"></script>
<?php print Form::open('shop/administration/items/new/create'); ?>

<div class="control-group">

	<?php print Form::label(__('controls.label'),'label',array('class'=>'control-label')) ?>
	<div class="controls">
		<?php print Form::input('label',''); ?>
	</div>

</div>

<div class="control-group">

	<?php print Form::label(__('controls.item_nr'),'label',array('class'=>'control-label')) ?>
	<div class="controls">
		<?php print Form::input('label',''); ?>
	</div>

</div>

<div class="form-actions">
	<?php print Form::submit('create',__('global.save'),array('class'=>'btn btn-primary')); ?>
</div>

<?php print Form::close(); ?>