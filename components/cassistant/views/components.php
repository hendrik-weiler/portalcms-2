<div>
	<a href="<?php print \Uri::create('cassistant/administration/components/new_component') ?>"><?php print __('new_component') ?></a>
</div>
<?php foreach($all_modules as $module): ?>
<div class="row clearfix"></div>
	<div class="span8"><?php print $module->name; ?></div>
	<div class="span2"><?php print $module->status ? __('active') : __('inactive'); ?></div>
</div>
<?php endforeach; ?>