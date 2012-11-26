<?php print Form::open('layout/administration/save'); ?>
<div class="selection">

	<?php foreach ($layouts as $key => $layout): ?>
	<?php
		$selected_class = '';
		$radio_is_checked = false;
		if($option->get_or_create_new('selected_layout', $layouts[0]->folder_name)->value == $layout->folder_name)
		{
			$selected_class = ' selected';
			$radio_is_checked = true;
		}
	?>
	<div class="layout<?php print $selected_class ?>">
		<div class="_label">
			<?php print $layout->label ?>
		</div>
		<div class="_description">
			<?php print $layout->description ?>
		</div>
		<div class="_checkbox">
			<?php print \Form::radio('folder',$layout->folder_name, $radio_is_checked); ?>
		</div>
	</div>
	<?php endforeach; ?>

</div>
<div class="form-actions">
	<?php print Form::submit('submit',__('global.save'),array('class'=>'btn btn-primary')) ?>
</div>
<?php print Form::close(); ?>