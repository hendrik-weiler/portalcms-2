<script type="text/javascript" src="<?php print \Uri::create('uploads/rpg_editor/project1/lib/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php print \Uri::create('uploads/rpg_editor/project1/lib/raphael-min.js') ?>"></script>
<script type="text/javascript" src="<?php print \Uri::create('uploads/rpg_editor/project1/lib/scale.raphael.js') ?>"></script>

<script type="text/javascript" src="<?php print \Uri::create('uploads/rpg_editor/project1/scripts/map.js') ?>"></script>
<script type="text/javascript" src="<?php print \Uri::create('uploads/rpg_editor/project1/scripts/sprite.js') ?>"></script>
<script type="text/javascript" src="<?php print \Uri::create('uploads/rpg_editor/project1/scripts/game.js') ?>"></script>
<script type="text/javascript" src="<?php print \Uri::create('uploads/rpg_editor/project1/scripts/event.js') ?>"></script>
<script type="text/javascript" src="<?php print \Uri::create('uploads/rpg_editor/project1/scripts/animation.js') ?>"></script>
<script type="text/javascript" src="<?php print \Uri::create('uploads/rpg_editor/project1/scripts/player.js') ?>"></script>
<script type="text/javascript" src="<?php print \Uri::create('uploads/rpg_editor/project1/scripts/message.js') ?>"></script>

<script type="text/javascript">
// set defaults (gets overwritten in next js includes)
$player = new rpg_event({
	x : 96,
	y : 0,
	sprite : 0
});

$.maps = [];
$.maps[0] = new rpg_map({
	id : 0,
	label : '0',
	coordinates_sprites : []
});

$.sprite = [];
$.sprite[0] = new rpg_sprite({
	label : 'transparency',
	source : 'sprites/transparency.png',
	height: 16,
	width: 16
});
</script>

<?php 

$current_map = \Input::get('current_map') == '' ? 0 : \Input::get('current_map');

foreach($maps as $map)
	print '<script src="' . \Uri::create('uploads/rpg_editor/project1/game_data/maps/' . $map) . '"></script>';

foreach($events as $event)
	print '<script src="' . \Uri::create('uploads/rpg_editor/project1/game_data/events/' . $event) . '"></script>';

foreach($sprites as $sprite)
	print '<script src="' . \Uri::create('uploads/rpg_editor/project1/game_data/sprites/' . $sprite) . '"></script>';
?>

<script type="text/javascript" src="<?php print \Uri::create('server/component/rpg_editor/ui_controls.js') ?>"></script>
<div class="first-col">
	<div class="properties">
		<h5>Properties</h5>
		<div class="map-panel">
			<?php 

			$form->create(''); 

			$form->input->create('Label','label', '','input-medium'); 

			$form->input->create('Height','height', '','input-small');  

			$form->input->create('Width','width', '','input-small');  

			$form->add_html(\Form::hidden('map_id',''));

			$form->submit->create('Save','save','primary');

			print $form();
			?>
		</div>
	</div>
	<div class="maps">
		<h5>Maps</h5>
		<div class="list">
		</div>
		<div class="options">
			<?php print \Html::anchor('#add-maps','Add Map', array('class'=>'add_map')) ?>
		</div>
	</div>
</div>
<div class="second-col">
	<div class="options">
		<?php print \Html::anchor('#first-layer','First Layer') ?>
		<?php print \Html::anchor('#second-layer','Second Layer') ?>
		<?php print \Html::anchor('#event-layer','Event Layer') ?>
		| <?php print \Html::anchor('#save-map','Save Map',array('class'=>'save_map')) ?>
	</div>
	<div class="canvas-box">
		<div id="canvas"></div>
		<script type="text/javascript">

			$.game = new rpg_game({
				startmap : <?php print $current_map ?>,
				tilesize : 16
			});
			var canvas = new ScaleRaphael('canvas', 320, 240);
			var player = new rpg_player($player);

			$.game.run(canvas, player, 2);
		</script>
	</div>
</div>
<div class="third-col material">
	<div class="material-panel">
		<h5>Material</h5>
		<div class="list">

		</div>
		<?php 

		$form->create('rpg_editor/administration/material/upload');  

		$form->add_html(\Form::file('image'));

		$form->add_html('<input name="map_id" value="' . $current_map . '" type="hidden" id="form_map_id">');

		$form->submit->create('Add Material','add_material','primary');

		print $form();
		?>
	</div>
</div>