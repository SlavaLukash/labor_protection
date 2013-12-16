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

	$.datepicker.setDefaults(
		$.extend($.datepicker.regional["ru"])
	);
	$('.date-input').datepicker({
		dateFormat: 'dd.mm.yy',
		changeYear: true,
		yearRange: "-50:+50"
	});

	$.each($('.date-input'), function () {
		$(this).attr('placeholder', 'дд.мм.гггг')
		$(this).wrap("<div class='b-date'></div>");
		$(this).after('<div class="dp-img"></div>');
	});

	$('div.dp-img').click(function () {
		$(this).prev().focus();
	});
});

function filterClear() {
	$('.ot_filter_form input[type="text"]').val('');
	$('.ot_filter_form input[type="date"]').val('');
	$('.ot_filter_form select option:selected').attr('selected', false);
}