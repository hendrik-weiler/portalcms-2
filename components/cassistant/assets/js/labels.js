$('.label_entry').eq(0).find('#delete_label').hide();

$('#new_label').click(function(e) {
	e.preventDefault();

	var entry = $('.label_entry').eq(0).clone();
	$(entry).find('#delete_label').show();

	$('.label-container').append(entry);
});

$('#delete_label').live('click',function(e) {
	e.preventDefault();
	var index = $('.label_entry').index($(this).parentsUntil('.label_entry').parents());
	
	$('.label_entry').eq(index).remove();
});