$(function() {
	var upload = $('#avatar').show().upload({
		action : _url + 'settings/action/upload_picture',
		enctype: 'multipart/form-data',
		onSubmit : function(e) {
			$('#avatar').find('img').attr('src',_url + 'assets/img/ajax_load.gif');
		},
		onComplete : function(response) {
			console.log(response);
			response = jQuery.parseJSON(response);
			$('#avatar').find('img').attr('src',response.big);
			$('input[name=avatar_source]').attr('value',response.filename + ';' + response.account_num);
		}
	});

	$('.avatar_upload').hide();
});