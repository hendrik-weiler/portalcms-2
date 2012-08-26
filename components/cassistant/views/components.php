<div>
	<a href="<?php print \Uri::create('cassistant/administration/components/new_component') ?>"><?php print __('new_component') ?></a>
</div>
<div class="row chead">
	<div class="span6"><?php print __('th.name') ?></div>
	<div class="span3"><?php print __('th.id') ?></div>
	<div class="span3"><?php print __('th.version') ?></div>
	<div class="span2"><?php print __('th.status') ?></div>
</div>

<?php foreach($component_categories as $category): ?>
<div class="row seperate-line">
	<?php print $category ?>
</div>

<?php foreach($all_modules as $module): ?>
<?php if($module->category == $category): ?>
<div class="row">
	<div class="span6"><?php print $module->name; ?></div>
	<div class="span3"><?php print $module->id; ?></div>
	<div class="span3"><?php print $module->version; ?></div>
	<div class="span2"><?php print $module->status ? __('active') : __('inactive'); ?></div>
</div>
<?php endif; ?>
<?php endforeach; ?>

<?php endforeach; ?>