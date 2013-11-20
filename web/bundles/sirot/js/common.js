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
});