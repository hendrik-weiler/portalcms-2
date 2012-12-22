var rpg_player = function(event) {

	var self = this;

	this.event = event;

	function make_moveable()
	{
		$('body').keydown(function(e) {

			switch(e.keyCode)
			{
				// up
				case 38:
				if(!event.is_animated && !rpg_message.active)
				{
					rpg_animation.makeStep(event,0,-1);
					event.map.onPlayerMove(event);
				}	
				break;

				// right
				case 39:
				if(!event.is_animated && !rpg_message.active)
				{
					rpg_animation.makeStep(event,1,0);
					event.map.onPlayerMove(event);
				}	
				break;

				// left
				case 37:
				if(!event.is_animated && !rpg_message.active)
				{
					rpg_animation.makeStep(event,-1,0);
					event.map.onPlayerMove(event);
				}	
				break;

				// down
				case 40:
				if(!event.is_animated && !rpg_message.active)
				{
					rpg_animation.makeStep(event,0,1);
					event.map.onPlayerMove(event);
				}	
				break;

				// enter
				case 13:
				if(rpg_message.active)
				{
					rpg_message.current_msgbox.remove();
					rpg_message.current_msgtext.remove();
					rpg_message.active = false;
					rpg_message.onClose(event);
				}
				else
				{
					self.attemptEnter(event);
				}
				break;

				// escape
				case 27:
				break;
			}

		});
	}

	make_moveable();

	this.attemptEnter = function(player)
	{
		var x_difference = 0;
		var y_difference = 0;

		switch(player.settings.face)
		{
			case 'up':
			y_difference = -1;
			break;
			case 'left':
			x_difference = -1;
			break;
			case 'right':
			x_difference = 1;
			break;
			case 'down':
			y_difference = 1;
			break;
		}


		var is_blocked = player.map.positionIsBlocked(
			(player.settings.x / player.game_object.conf.tilesize) + x_difference, 
			(player.settings.y / player.game_object.conf.tilesize) + y_difference
		);

		if(is_blocked.hit_event != null)
		{
			is_blocked.hit_event.lookToEvent(player);
			is_blocked.hit_event.enter_interaktion(this, is_blocked);
		}
	}
}