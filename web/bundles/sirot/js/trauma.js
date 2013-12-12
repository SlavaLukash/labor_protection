$(document).ready(function () {
	$('ul.button-list').hover(
		function() {
			var time = 0;

			$.each($(this).find('li'), function () {
				var elem = $(this);
				setTimeout(function(){
					if(!elem.hasClass('b-list-first-child')) elem.fadeIn(100);
				}, time);
				time += 100;
			});
			$(this).children('li').children('a').addClass('opened');
		},
		function () {
			$(this).children('li').children('a').removeClass('opened');
			$(this).children('li').hide();
			$(this).children('li.b-list-first-child').show();
		}
	);

	$('li.b-list-first-child a').click(function () {return false;});
});