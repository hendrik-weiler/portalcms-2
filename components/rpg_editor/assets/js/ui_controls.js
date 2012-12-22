$(function() {

	var current_map = 0;
	var selected_material = 0;

	var tilesizesize = $.game.conf.tilesize * $.game.conf.scale_factor;

	$('.maps .list').append('<ul>');
	for (var i = 0; i < $.maps.length; i++) {
		$('.maps .list').find('ul').append('<li><a data-id="' + i + '" href="#">' + $.maps[i].settings.label + '</a></li>');
	};

	$('.material-panel .list').append('<ul>');
	for (var i = 0; i < $.sprite.length; i++) {
		$('.material-panel .list').find('ul').append('<li><div style="width:' + tilesizesize + 'px" data-id="' + i + '"><img height="' + tilesizesize + '" width="' + tilesizesize + '" src="' + $.sprite[i].settings.source + '" />' + $.sprite[i].settings.label + '</div></li>');
	};

	$('.maps .list a').click(function(e) {
		var map_id = $(e.currentTarget).attr('data-id');
		var settings = $.maps[map_id].settings;
		$('.map-panel #form_label').attr('value',settings.label);
		$('.map-panel #form_height').attr('value',settings.height);
		$('.map-panel #form_width').attr('value',settings.width);
		$('.map-panel #form_map_id').attr('value',map_id);
		current_map = map_id;
	});

	$('.map-panel #form_save').click(function(e) {
		e.preventDefault();
		var data = $('.map-panel form').serialize();
		$.post(_url + 'rpg_editor/action/change_map_settings', data ,function(data) {
			console.log(data);
			//window.location.href = _current_url + '?current_map=' + current_map;
		});
	});

	$('.add_map').click(function(e) {
		e.preventDefault();
		$.get(_url + 'rpg_editor/action/add_map', function(data) {
			window.location.reload();
		});
	});

	// tiles

	var canvas_position = $('#canvas').position();

	var grid = $('<table class="canvas-grid">');
	for (var i = 0; i < $.maps[current_map].settings.height; i++) {
		$(grid).append('<tr>');
		for (var j= 0; j < $.maps[current_map].settings.width; j++) {
			var td = $('<td>').css({
				width : tilesizesize,
				height : tilesizesize
			}).attr({
				'data-sprite-id' : 0 
			});
			$(grid).find('tr').eq(i).append(td);
		};
	};

	grid.css({
		position : 'absolute',
		top : canvas_position.top,
		left : canvas_position.left
	});

	grid.find('td').hover(function(e) {
		$(e.currentTarget).addClass('selected');
	}, function(e) {
		grid.find('td').removeClass('selected');
	});

	grid.find('td').click(function(e) {
		$(e.currentTarget).css({
			background : 'url(' + $.sprite[selected_material].settings.source + ') top left'
		}).attr({
			'data-sprite-id' : selected_material 
		});
	});

	$('body').append(grid);

	$('.material-panel .list li').click(function(e) {
		$('.material-panel .list li').find('div').removeClass('active');
		$(e.currentTarget).find('div').addClass('active');
		selected_material = $(e.currentTarget).find('div').attr('data-id');
	});

	$('.save_map').click(function(e) {
		e.preventDefault();

		var coordinates_first_layer = [];

		$(grid).find('tr').each(function(key, obj) {
			coordinates_first_layer[key] = [];
			$(obj).find('td').each(function(key2, obj2) {
				coordinates_first_layer[key].push($(obj2).attr('data-sprite-id'));
			});
		});

		$.get(_url + 'rpg_editor/action/map/save', { 
			map_id : current_map,
			map_data_first_layer : coordinates_first_layer  
		} ,function(data) {
			console.log(data);
			$.game.changeMap(current_map, 1 , 1);
			//window.location.reload();
		});
	});

});