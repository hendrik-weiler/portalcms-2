$(function() {
	var upload = $('#avatar').upload({
		action : _url + 'install/action/upload_picture',
		enctype: 'multipart/form-data',
		onSubmit : function() {
			$('#avatar').find('img').attr('src',_url + 'assets/img/ajax_load.gif');
		},
		onComplete : function(response) {
			response = jQuery.parseJSON(response);
			$('#avatar').find('img').attr('src',response.big);
			$('#avatar span').text(response.filename + ';' + response.account_num);
		}
	});
});