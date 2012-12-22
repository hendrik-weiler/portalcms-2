var rpg_sprite = function( options ) {  

  this.settings = $.extend( {
    'label'	   : 'New Sprite',
    'height' 	   : 0,
    'width'	   : 0,
    'source' : null,
    'does_block' : true
  }, options);

  return this;

};