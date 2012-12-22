var rpg_animation = {
	makeStep : function(event ,x_path, y_path, success) {
		var face = 'down';
		event.is_animated = true;

		if(success === undefined) success = function() {};

		x_path *= event.game_object.conf.tilesize;
		y_path *= event.game_object.conf.tilesize;

		var animate_step = {
			x : (event.settings.x + x_path), 
			y : (event.settings.y + y_path)
		};

		event.animation_data.x = animate_step.x;
		event.animation_data.y = animate_step.y;

		var cannot_move = event.map.positionIsBlocked(animate_step.x / event.game_object.conf.tilesize,animate_step.y / event.game_object.conf.tilesize);

		if(!cannot_move.status)
		{
			event.settings.x = animate_step.x;
			event.settings.y = animate_step.y;
		}

		if(x_path < 0 && y_path <= 0) face = 'left';
		if(x_path > 0 && y_path >= 0) face = 'right';
		if(y_path < 0 && x_path <= 0) face = 'up';
		if(y_path > 0 && x_path >= 0) face = 'down';

		event.setFace(face);

		if(!cannot_move.status)
		{
			var counter = 1;
			var delay = 300;
			var interval = window.setInterval(function() {

				event.settings.anim += 1;
				event.raph_id.attr({src: event.getDisplayImage()});
				if(event.settings.anim == 3)
				{
					event.settings.anim = 1;
				}

				var animate_step = {
					x : (event.settings.x - x_path) + (x_path/3 * counter), 
					y : (event.settings.y - y_path) + (y_path/3 * counter)
				}

				event.raph_id.animate(animate_step,delay / 3);

				counter++;
				if(counter == 4)
				{
					window.clearInterval(interval);
					event.is_animated = false;
					success(event);
				}
			}, delay / 3);
		}
		else
		{
			event.is_animated = false;
		}
	},
	stopAnimation : function(event) {
		event.raph_id.stop();
		event.raph_id.attr({
			x : event.animation_data.x,
			y : event.animation_data.y,
		});
	},
	teleportTo : function(event, x, y) {
		event.raph_id.attr({x : x , y : y});
	},
	moveEventPath : function(event ,x_path, y_path, success, call_success) {

		if(success === undefined) success = function() {};
		if(call_success === undefined) call_success = true;

		var step_x = 0;
		var step_y = 0;

		if(x_path == 0)
		{
			if(y_path == 0)
			{
				if(call_success)
					success(event);
				return true;
			}	
			else
			{
				step_y = y_path < 0 ? -1 : 1;
				y_path -= step_y;
			}	
		}
		else
		{
			step_x = x_path < 0 ? -1 : 1;
			x_path -= step_x;
		}

		rpg_animation.makeStep(event ,step_x, step_y, function(event) {
			rpg_animation.moveEventPath(event ,x_path, y_path, success);
		});
	},
	moveEventTo : function(event,x,y, success) {

		if(success === undefined) success = function() {};

		var x_path = x - event.getMapPositionX();
		var y_path = y - event.getMapPositionY();

		rpg_animation.moveEventPath(event, x_path, 0, function() {
			rpg_animation.moveEventPath(event, 0, y_path, function() {
				success(event);
			});
		});
	}
}