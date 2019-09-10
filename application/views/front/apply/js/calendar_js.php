
<script>

	$('body').on('click', '.fa-plus', function()
		{
			$('*[data-calendar]').datepicker('destroy');

			$($(this).parent().parent()).clone().find("input:text").val("").end().insertAfter('.one_row:last');
			initCalendar();
		});

	$('body').on('click', '.fa-minus', function()
		{
			if($('.one_row').length >1 )
			{
				$($(this).parent().parent()).remove();
			}
			else
			{
				$($(this).parent().parent()).find('input').val('')

			}

		});




	function initCalendar()
	{
		$('*[data-calendar]').datepicker(
			{
				todayBtn: "linked",
				clearBtn: true,
				daysOfWeekHighlighted: [6,0],
				autoclose: true,
				format: 'dd/mm/yyyy',
				weekStart:1,
				language: "<?= $this->session->userdata('lang') ?>"
			});

	}
	initCalendar();


</script>