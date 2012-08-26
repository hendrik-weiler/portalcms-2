if(pcms2 === undefined)
	var pcms2 = new Object();

$(function() {
	var pcms2_Tooltip = function() 
	{

		this.get_tooltip_url = function()
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
		this.load_tool_tip = function(url)
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
	}

	pcms2['Tooltip'] = new pcms2_Tooltip();
	
	pcms2.Tooltip.load_tool_tip(_url + 'server/tooltip/backend/global.xml');

	for (var i = 0; i < _components.length; i++)
		pcms2.Tooltip.load_tool_tip(_url + 'server/tooltip/' + _components[i] + '/global.xml');
	
	pcms2.Tooltip.load_tool_tip(pcms2.Tooltip.get_tooltip_url());
});