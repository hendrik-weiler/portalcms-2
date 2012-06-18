<?php print Form::open(array('action'=>'install/action/update_database','class'=>'install2')); ?>
	<?php print Form::hidden('_redirect',\Uri::create('install/3')); ?>
	<?php print Form::hidden('_current',\Uri::create('install/2')); ?>
	<?php 
		$update = array();
		array_map(function($value) use(&$update,$finished_updates) {
			if(!in_array($value, $finished_updates))
				$update[] = $value['version'];
			return $value;
		},$updates);
		print Form::hidden('in_progress',json_encode($update)) 
	?>
<div class="row">
	<div class="span4">
		<h3><?php print __('2.update_list') ?></h3>
		<ul class="nav nav-list">
			<?php foreach($updates as $update): ?>
			<li <?php print $current_version == $update['version'] ? ' class="active"' : ''; ?>>
				<a href="#">
					<i class="<?php print in_array($update['version'],$finished_updates) ? 'icon-ok' : 'icon-remove' ?> <?php print $current_version == $update['version'] ? 'icon-white' : '' ?>"></i>
					<span><?php print $update['version'] ?></span>
				</a>
				<span id="description-<?php print $update['version'] ?>" class="hidden"><?php print $update['description'] ?></span>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="span3">
		<h3><?php print __('2.informations') ?></h3>
		<p>
			<table>
				<tr>
					<td><?php print __('2.current_version') ?></td>
					<td><?php print '<span id="current_version" class="label label-info">' . $current_version . '</span>' ?></td>
				</tr>
				<tr>
					<td><?php print __('2.latest_version') ?></td>
					<td><?php print '<span class="label label-success">' . $latest_version . '</span>' ?></td>
				</tr>							
			</table>
			<br />
			<h3><?php print __('2.description') ?></h3>
			<p class="description"></p>
		</p>
	</div>
</div>
<div class="row">
	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="<?php print __('2.update_button'); ?>">
	</div>
</div>
    <?php 
    	$data = array();
    	foreach ($updates as $key => $update) 
    	{
    		if(!in_array($update['version'],$finished_updates))
    		{
    			$obj = new \stdClass;
				$obj->name = 'update';
    			$obj->value = $update['version'];
    			$data[][] = $obj;
    		}	
    	}

    	print Helper\AjaxLoaderProgress::render(
	    	'.install2',
	    	__('messages'),
	    	\Uri::create('install/2'),
	    	\Uri::create('install/action/update_database'),
	    	json_encode($data),'progressbar',count($updates)-count($finished_updates)
    	); ?>
<?php print Form::close(); ?>