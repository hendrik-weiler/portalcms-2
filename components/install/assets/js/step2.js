$(function() {
	$('.nav-list a').click(function(e) {
		e.preventDefault();
		write_description($(this));
	});

	$('.description').html($('.nav-list li[class=active]').find('span[id*=description]:eq(0)').text());
});
	function write_description(element)
	{
		$('.description').html($(element).parents().find('span[id*=description]:eq(0)').html());
	}
	function progressbar(result,data)
	{
		if(result.status)
		{
			var li = $('.nav-list a').find('span:contains(' + data.update + ')').parentsUntil('li').parents();
			write_description($(li));
			$('#current_version').html(data.update);
			$('.nav-list li').removeClass('active').find('i').removeClass('icon-white');
			$(li).addClass("active").find('i')[0].className = 'icon-ok icon-white';
		}
	}