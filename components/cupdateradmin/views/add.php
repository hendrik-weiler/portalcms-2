<div class="cupdateradmin">
	<?php print Form::open(array('action'=>$action_url,'enctype'=>'multipart/form-data','class'=>'form')); ?>
	<?php print Form::hidden('_redirect',\Uri::current()); ?>
	<?php print Form::hidden('_current',\Uri::current()); ?>

	<?php print Form::label(__('form.author')) ?>
	<?php print Form::input('author', $author) ?>

	<?php print Form::label(__('form.version')) ?>
	<?php print Form::input('version', $version) ?>

	<?php print Form::label(__('form.category')) ?>
	<?php print Form::input('category', $category) ?>

	<?php print Form::label(__('form.name')) ?>
	<?php print Form::input('name', $name) ?>

	<?php print Form::label(__('form.pictures')) ?>
	<div class="picture-list">
	<?php foreach($pictures as $key => $picture): ?>
		<?php $class = ''; $key == $preview_index and $class = ' active'; ?>
		<div class="picture<?php print $class ?>">
			<img src="<?php print $picture ?>">
		</div>
	<?php endforeach; ?>
	</div>
	<?php print Form::file('pictures[]') ?>
	<?php print Form::file('pictures[]') ?>
	<?php print Form::file('pictures[]') ?>

	<?php print Form::hidden('preview_index', $preview_index) ?>

	<?php if(!empty($package)): ?>
		<div class="package row">
			<div class="span1 pic">
				<img src="<?php print Uri::create('server/component/cupdateradmin/package_zip.png'); ?>">
			</div>
			<div class="span8 name">
				<?php print $package ?>
			</div>
		</div>
	<?php endif; ?>
	<?php print Form::label(__('form.package')) ?>
	<?php print Form::file('package') ?>

	<?php print Form::label(__('form.description')) ?>
	<?php print Form::textarea('description', $description, array('style'=>'width:100%;height:300px')) ?>

	<div class="form-actions">
		<?php print Form::submit('save',__('global.save'),array('class'=>'btn btn-primary')) ?>
		<?php print Form::submit('back',__('global.back'),array('class'=>'btn btn-secondary')) ?>
	</div>

    <?php 
    	/*print Helper\AjaxLoader::render(
    		'.form',
    		__('messages'),
	    	\Uri::create('cupdateradmin/administration'),
	    	\Uri::create('cupdateradmin/action/add/save')
    	); */
    ?>

	<?php print Form::close(); ?>
</div>
<script type="text/javascript" src="<?php print Uri::create('server/component/cupdateradmin/preview.js'); ?>"></script>