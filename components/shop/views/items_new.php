<script type="text/javascript" src="<?php print Uri::create('server/component/shop/test.coffee'); ?>"></script>
<?php 

$form->create('shop/administration/items/new/create'); 

$form->input->create(__('controls.label'),'label'); 

$form->input->create(__('controls.item_nr'),'item_nr'); 

$form->checkbox->create('offer','Offer','offer');

$form->radiobutton->create(array(
	array('Dies ist ein Test','test'),
	array('Dies ist ein anderer Test','test2',true),
	array('Dies ist ein dritter Test','test3')
),'offer');

$form->textarea->create_editor('test','');

$form->select->create(array(
	'test',
	'test2',
	'test3'
),'test');

$form->actionfield->create(array(
	$form->submit->create(__('global.create'),'create','primary'),
	$form->submit->create(__('global.back'),'back')
)); 

print $form() 

?>