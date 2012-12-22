var rpg_game = function( options ) {  

    this.conf = $.extend( {
      'startmap'         : 0,
      'tilesize'         : 16,
      'height'           : 480,
      'width'            : 640,
      'scale_factor'     : 1
    }, options);

    $.events = $.events === undefined ? [] : $.events;
    $.sprite = $.sprite === undefined ? [] : $.sprite;
    $.maps = $.maps === undefined ? [] : $.maps;
    $.canvas = null;
    $.player = $.player === undefined ? null : $.player;

    rpg_message.game_object = this;

    this.renderMap = function(mapid)
    {
      var map = $.maps[mapid];
      map.game_object = this;
      render_sprites(map);
      render_sprites(map.upper_layer);
      function render_sprites(map)
      {
        if(map == null) return;

        for(var i = 0;i<map.settings.coordinates_sprites.length;++i)
        {
          for(var j = 0;j<map.settings.coordinates_sprites[i].length;++j)
          {
            if(map.settings.coordinates_sprites[i][j] != 0)
            {
              var sprite = $.sprite[map.settings.coordinates_sprites[i][j]];
              $.canvas.image(
                sprite.settings.source, 
                sprite.settings.width * j, 
                sprite.settings.height * i, 
                sprite.settings.width, 
                sprite.settings.height
              );
            }
          }
        }
        map.onLoad(map);
      }
      
    }

    this.renderEvents = function(mapid)
    {
      if($.maps[mapid].event.length == 0) return false;

      for (var i = 0; i < $.maps[mapid].event.length; ++i) 
      {
        var raph_id = $.canvas.image(
          $.maps[mapid].event[i].getDisplayImage(), 
          $.maps[mapid].event[i].settings.x, 
          $.maps[mapid].event[i].settings.y, 
          $.sprite[$.maps[mapid].event[i].settings.sprite].settings.width, 
          $.sprite[$.maps[mapid].event[i].settings.sprite].settings.height
        );

        $.maps[mapid].event[i].raph_id = raph_id;
        $.maps[mapid].event[i].game_object = this;
        $.maps[mapid].event[i].map = $.maps[mapid];
      }
    }

    this.renderPlayer = function(mapid)
    {
        var sprite = $.player;
        sprite.event.game_object = this;
        sprite.event.map = $.maps[mapid];
        sprite.event.raph_id = $.canvas.image(
          sprite.event.getDisplayImage(), 
          sprite.event.settings.x, 
          sprite.event.settings.y, 
          $.sprite[sprite.event.settings.sprite].settings.width, 
          $.sprite[sprite.event.settings.sprite].settings.height
        );
    }

    this.changeMap = function(mapid, x, y)
    {
      $.canvas.clear();
      $.canvas.setSize(this.conf.width, this.conf.height);
      $.canvas.scaleAll(this.conf.scale_factor);
      this.renderMap(mapid);
      this.renderEvents(mapid);

      $.player.event.settings.x = x * this.conf.tilesize;
      $.player.event.settings.y = y * this.conf.tilesize;
      $.player.event.raph_id.attr({x : $.player.event.settings.x, y : $.player.event.settings.y});
      this.renderPlayer(mapid);
    }

    this.run = function(canvas, player, scale_factor) 
    {
      if(scale_factor === undefined) scale_factor = 1;
      this.conf.scale_factor = scale_factor;

      $.player = player;
      $.canvas = canvas;
      $.canvas.setSize(this.conf.width, this.conf.height);
      $.canvas.scaleAll(this.conf.scale_factor);
      this.renderMap(this.conf.startmap);
      this.renderEvents(this.conf.startmap);
      this.renderPlayer(this.conf.startmap);
    }

    return this;

};