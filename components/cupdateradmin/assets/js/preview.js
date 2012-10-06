$('.cupdateradmin div.picture').click(function() {
	var index = $('.cupdateradmin div.picture').index(this);
	
	$('.cupdateradmin div.picture').removeClass('active');
	$(this).addClass('active');
	$('#form_preview_index').attr('value',index);
});