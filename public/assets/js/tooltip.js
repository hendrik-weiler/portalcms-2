$(function() {
	function get_tooltip_url()
	{
		function removeByIndex(arrayName,arrayIndex){ 
			arrayName.splice(arrayIndex,1); 
		}
		var segments = _segments;
		var component = _segments[0];
		removeByIndex(segments, 0);

		var url = _url + 'server/tooltip/' + component + '/' + segments.join('-') + '.xml';
		return url.replace(/\/([0-9]+)/g,'').toLowerCase();
	}
	function load_tool_tip(url)
	{
		$.ajax({
		    type: "GET",
			url: url,
			dataType: "xml",
			success: function(xml) {
		 		$(xml).find('tooltip').each(function(key,value) {
		 			var selector = $(value).attr('selector');
		 			var position = $(value).attr('position');
		 			var text = $.trim($(value).text());
		 			$(selector)
		 			   .attr('rel','tooltip')
		 			   .attr('data-original-title',text)
		 			   .tooltip({
		 				placement : position
		 			});
		 		});
			}
		});
	}

	load_tool_tip(_url + 'server/tooltip/backend/global.xml');

	for (var i = 0; i < _components.length; i++)
		load_tool_tip(_url + 'server/tooltip/' + _components[i] + '/global.xml');
	
	load_tool_tip(get_tooltip_url());
});