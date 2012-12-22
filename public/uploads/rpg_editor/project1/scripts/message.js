var rpg_message = {
	game_object : null,
	current_msgbox : null,
	current_msgtext : null,
	onClose : function(player) {},
	active : false,
	show : function(text , onclose) {

		if(onclose !== undefined) rpg_message.onClose = onclose;

		rpg_message.active = true;

		var x = 5;
		var y = (rpg_message.game_object.conf.height / rpg_message.game_object.conf.scale_factor) - 55;

		var width = (rpg_message.game_object.conf.width / rpg_message.game_object.conf.scale_factor) - 10;
		var height = 50;

		rpg_message.current_msgbox = $.canvas.rect(x, y, width, height).attr({ 'fill' : '#ADDAFF', 'fill-opacity' : 0.5, 'stroke-width' : 0.5});
		rpg_message.current_msgtext = $.canvas.text(x + 30, y + 10, text).attr({ 'font-size' : 8});
	}
}