if(pcms2 === undefined)
	var pcms2 = new Object();

var pcms2_Storage = function() 
{

	function _get_current_component()
	{
		return _segments[0];
	}

	function _request(mode, _key, _value, _component)
	{
		return $.ajax({
		  type: "POST",
		  url: _url + 'cstorage/' + mode,
		  data: { key: _key, value: _value, component : _component }
		});
	}

	this.set = function(key, value, callback)
	{
		_request('set', key, value, _get_current_component()).done(callback);
	}

	this.get = function(key, callback)
	{
		_request('get', key, 'undefined', _get_current_component()).done(callback);
	}

	this.remove = function(key, callback)
	{
		_request('remove', key, 'undefined', _get_current_component()).done(callback);
	}
}

pcms2['Storage'] = new pcms2_Storage();