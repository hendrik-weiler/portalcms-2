<h3><?php print __('4.almost_finished'); ?></h3>

<div class=""><?php print __('4.disabletext'); ?><div>
<p>
	<?php if($can_be_disabled): ?>
	<button style="margin:8px;margin-left:0px;" class="btn btn-primary"><?php print __('4.disabletext_button'); ?></button>
	<?php else: ?>
	<h4><?php print __('4.cant_disable_text'); ?></h4>
	<?php endif; ?>
</p>

<div class=""><?php print __('4.admintext'); ?><div>
<h3 style="margin:8px;margin-left:0px;"><a class="btn btn-primary" href="<?php print \Uri::create('logincenter') ?>"><?php print __('4.adminlink'); ?></a></h3>
    <?php print Helper\AjaxLoader::render('p button:eq(0)',
    	false,
    	\Uri::create('install/action/disable_install_tool'),''); ?>