var rpg_map = function( options ) {  

    this.settings = $.extend( {
      'id'         : 0,
      'label'	   : 'New Map',
      'height' : 0,
      'width' : 0,
      'coordinates_blocked' : [],
      'coordinates_sprites' : []
    }, options);

    this.event = [];
    this.upper_layer = null;
    this.game_object = null;

    this.onPlayerMove = function(player) {};
    this.onLoad = function(map) {};

    this.positionIsBlocked = function(x,y) 
    {
        var result = false;
        var hitted_event = null;
        if(this.upper_layer != null && this.upper_layer.settings.coordinates_blocked.length != 0)
        {
           if(this.upper_layer.settings.coordinates_blocked[y] !== undefined 
            && this.upper_layer.settings.coordinates_blocked[y][x] == 1) result = true;
        }
        if(this.settings.coordinates_blocked.length != 0)
        {
          if(this.settings.coordinates_blocked[y] !== undefined
            && this.settings.coordinates_blocked[y][x] == 1) result = true;
        }

        if(this.settings.coordinates_sprites[y + 1] === undefined) result = true;
        if(this.settings.coordinates_sprites[y]) 
          if(this.settings.coordinates_sprites[y][x] === undefined) result = true;

        for(var i = 0; i < this.event.length; ++i)
        {
          if( (this.event[i].settings.x / this.game_object.conf.tilesize) == x 
            && (this.event[i].settings.y / this.game_object.conf.tilesize) == y)
          {
            result = this.event[i].settings.does_block;
            hitted_event = this.event[i];
            this.event[i].onTouch(this.event[i], { status : result, hit_event : hitted_event });
          }  
        }

        return { status : result, hit_event : hitted_event };
    }

    return this;

};