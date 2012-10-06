<?php foreach($infos as $info): ?>
	<div class="update row">
		<div class="span3">

		</div>
		<div class="span7">
			<?php print $info->name ?>
		</div>
		<div class="span3">
			<?php print \Html::anchor('cupdateradmin/administration/edit/' . $info->id,__('list.edit')) ?>
		</div>
	</div>
<?php endforeach; ?>