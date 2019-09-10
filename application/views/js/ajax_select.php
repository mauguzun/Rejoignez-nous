
<script src="<?= base_url().'/css/back/ajax-bootstrap-select.min.js' ?>">

</script>


<script>


	let offer_id = false;
	var options =
	{

		ajax:
		{
			url: "<?= $url ?>",
			type: "POST",
			dataType: "json",
			// Use "{{{q}}}" as a placeholder and Ajax Bootstrap Select will
			// automatically replace it with the value of the search query.
			data:
			{
				q: "{{{q}}}"
			}
		},

		locale:
		{
			emptyTitle: "<?= lang('Select and Begin Typing')?>"
		},
		log: 1,

		preprocessData: function(data)
		{
			var i,
			l = data.length,
			array = [];
			if (l)
			{
				for (i = 0; i < l; i++)
				{
					array.push(
						$.extend(true, data[i],
							{
								text: data[i].title,
								value: data[i].id,
								data:
								{
									//subtext: data[i].title
								}
							})
					);
				}
			}
			// You must always return a valid array when processing data. The
			// data argument passed is a clone and cannot be modified directly.
			return array;
		}
	};

	$(".selectpicker")
	.selectpicker()
	.filter(".with-ajax")
	.ajaxSelectPicker(options);
	$("select").trigger("change");



	$('select').on('change', function(e)
		{
			offer_id = this.value ;
		});

	$('form').submit(function()
		{
			if (!offer_id)
			{
				$('[data-error="offer_id"]').html("<?= lang('pick_offer_id')?>");
				$('html, body').animate({ scrollTop: $('[data-error="offer_id"]').offset().top }, 'slow');
				return false;
			}

		})
</script>



