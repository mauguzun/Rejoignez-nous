
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js">
</script>
<script>
	$('*[data-typehead]').each(function()
		{
			var $this = $(this);
			$this.typeahead(
				{
					source: function (query, result)
					{
						let request =  $.ajax(
							{
								url:  $this.attr('data-typehead-url'),
								data :
								{
									'query' : query,
									'table' : $this.attr('data-typehead-table'),
									'column' : $this.attr('data-typehead-column')
								}   ,
								dataType: "json",
								type: "POST",

							});

						request.then(data=>
							{
								if(data.error === undefined)
								{
									result($.map(data, function (item)
											{
												return item;
											}));
								}
							})
					}
				})
		})

</script>