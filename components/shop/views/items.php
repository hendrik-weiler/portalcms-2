<div class="items">

	<?php print Html::anchor('shop/administration/items/new',__('new_item')) ?>
	
	<?php foreach ($items as $item): ?>

	<?php endforeach; ?>
	<?php if(empty($items)): ?>
	<div class="item">
		<?php print __('no_items') ?>
	</div>
	<?php endif ?>
</div>