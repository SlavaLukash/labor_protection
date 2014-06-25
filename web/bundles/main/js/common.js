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

	/*вешаем на форму удаления событие, которое будет заставилять подтвердить удаление*/
	$('.remove-btn').on('click', function () {
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

	$('.med_enterprise').click(function() {
		$.post( "/app_dev.php/ajax",
			{ action: "subdivision", id: $('.med_enterprise option:selected').val() },
			function( data ) {
				if($('.med_subdivision').length>0)
				{
					$('.med_subdivision').empty();
					$('.med_subdivision').append(data);
				} else {
					$('.med_subdivision').append(data);
				}
		});
	});
	$('.med_subdivision').click(function() {
		$.post( "/app_dev.php/ajax",
			{ action: "employee", id: $('.med_subdivision option:selected').val() },
			function( data ) {
				if($('.med_employee').length>0)
				{
					$('.med_employee option').remove();
					$('.med_employee').append(data);
				} else {
					$('.med_employee').append(data);
				}
		});
	});

    $('.select2').each(function () {
        var $this = $(this);
        if ($this.data('select2')) {
            return;
        }
        var opts = {
//            allowClear: attrDefault($this, 'allowClear', !$(this).prop('required'))
            allowClear: false
        };

        $this.select2(opts);
        $this.addClass('visible');
    });
});

function filterClear() {
	$('.ot_filter_form input[type="text"]').val('');
	$('.ot_filter_form input[type="date"]').val('');
	$('.ot_filter_form select option:selected').attr('selected', false);
}