$(document).ready(function () {
	$.each($('table.records_list'), function () {
		var i = 0;
		$.each($(this).children('tbody').children('tr'), function () {
			if(i % 2 == 0) {
				$(this).addClass('row_even');
			} else {
				$(this).addClass('row_odd');
			}
			i++;
		});
	});

	$.each($('table.record_properties'), function () {
		var i = 0;
		$.each($(this).children('tbody').children('tr'), function () {
			if(i % 2 == 0) {
				$(this).addClass('row_even');
			} else {
				$(this).addClass('row_odd');
			}
			i++;
		});
	});

	/*вешаем на форму удаления событие, которое будет заставить подтвердить удаление*/
	var deleteForm		= $('input[value="DELETE"][name="_method"]').parent('form');

	deleteForm.find('button[type="submit"]').click(function () {
		if(confirm('Подвердите удаление')) {
			return true;
		}
		return false;
	});

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
});

function filterClear() {
	$('.ot_filter_form input[type="text"]').val('');
	$('.ot_filter_form input[type="date"]').val('');
	$('.ot_filter_form select option:selected').attr('selected', false);
}