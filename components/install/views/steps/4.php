<h3><?php print __('4.almost_finished'); ?></h3>

<div class=""><?php print __('4.disabletext'); ?><div>
<?php print Form::open(array('action'=>'install/action/disable_install_tool','class'=>'install4')); ?>
	<?php print Form::hidden('_redirect',\Uri::create('install/4')); ?>
	<?php print Form::hidden('_current',\Uri::create('install/4')); ?>
<p>
	<?php if($can_be_disabled): ?>
	<input type="submit" style="margin:8px;margin-left:0px;" class="btn btn-primary" value="<?php print __('4.disabletext_button'); ?>">
	<?php else: ?>
	<h4><?php print __('4.cant_disable_text'); ?></h4>
	<?php endif; ?>
</p>
<?php print Form::close(); ?>

<div class=""><?php print __('4.admintext'); ?><div>
<h3 style="margin:8px;margin-left:0px;"><a class="btn btn-primary" href="<?php print \Uri::create('logincenter') ?>"><?php print __('4.adminlink'); ?></a></h3>
    <?php 
    	print Helper\AjaxLoader::render(
    		'.install4',
    		__('messages'),
	    	\Uri::create('install/4'),
	    	\Uri::create('install/action/disable_install_tool')
    	); 
    ?>