var rpg_event = function( options ) {

  this.settings = $.extend( {
    'id'         : 0,
    'label'	   : 'Event 0',
    'layer' : 1,
    'sprite' : 0,
    'x' : 0,
    'y' : 0,
    'default_face' : 'down',
    'face' : 'down',
    'anim' : 2,
    'static' : false
  }, options);

  this.animation_data = {
    x : this.settings.x,
    y : this.settings.y
  };

  this.raph_id = null;

  this.game_object = null;

  this.map = null;

  this.is_animated = false;

  this.enter_interaktion = function(event, enter_result) {};
  this.onTouch = function(event, enter_result) {};

  this.getDisplayImage = function() 
  {
  	var args = arguments;

  	var path = $.sprite[this.settings.sprite].settings.source;

    if(this.settings.static)
    {
      return path;
    }

    if(args[0] === undefined)
    {
      path += '/' + this.settings.face + '_' + this.settings.anim + '.png'
    }
    else
    {
      path += '/' + this.settings.face + '_' + (args[1]) + '.png';
    }

  	return path;
  }

  this.getMapPositionX = function()
  {
    return this.settings.x / this.game_object.conf.tilesize;
  }

  this.getMapPositionY = function()
  {
    return this.settings.y / this.game_object.conf.tilesize;
  }

  this.setFace = function(position)
  {
    this.settings.face = position;

    this.raph_id.attr({src: this.getDisplayImage()});
  }

  this.lookToEvent = function(event)
  {
    var face = 'down';
    switch(event.settings.face)
    {
      case 'up':
      face = 'down';
      break;
      case 'down':
      face = 'up';
      break;
      case 'left':
      face = 'right';
      break;
      case 'right':
      face = 'left';
      break;
    }

    this.settings.face = face;
    this.raph_id.attr({ src : this.getDisplayImage()});
  }

  this.lookDefaultFace = function()
  {
    this.settings.face = this.settings.default_face;
    this.raph_id.attr({ src : this.getDisplayImage()});
  }

  this.onCollideWith = function(event,callback) 
  {
  	if(this.settings.x - $.game.conf.tilesize > event.settings.x
  		&& this.settings.y == event.settings.y)
  	{

  	}
  	if(this.settings.x - $.game.conf.tilesize < event.settings.x
  		&& this.settings.y == event.settings.y)
  	{

  	}
  	if(this.settings.y - $.game.conf.tilesize > event.settings.y
  		&& this.settings.x == event.settings.x)
  	{
  		
  	}
  	if(this.settings.y - $.game.conf.tilesize < event.settings.y
  		&& this.settings.x == event.settings.x)
  	{
  		
  	}
  }

  return this;
}