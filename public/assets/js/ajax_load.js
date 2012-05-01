function ajax_load_gen_params(params)
{
	var split_params = params.split(',');

	var result = {};
	for (var i = 0; i < split_params.length; i++) 
	{
		var single_split = split_params[i].split('->');
		result[single_split[0].trim()] = $(single_split[1]).val();

		if(result[single_split[0]] == '')
			result[single_split[0].trim()] = $(single_split[1]).text();
	};

	return result;
}