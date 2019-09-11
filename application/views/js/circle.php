<script>



	$('*[data-circle]').click(function()
		{


			let data_value = $(this).attr('data-value')
			let url = $(this).parent().attr('data-url')

			let prom = $.getJSON(url+"/"+data_value);
			let self = $(this);

			prom.then(data=>
				{
					if(data.error === undefined)
					{

						console.log(self.parent().parent())
						$('[data-id="'+url+'"]').css('color',data.done )
						self.parent().parent().attr('class','collapse out')
					}else
					{
						alert(data.error);
					}
				})

		})

	// statuses

	$('*[data-status]').click(function()
		{


			let id = $(this).attr("data-link");
			let prom = $.getJSON($(this).attr('href') );
			let self = $(this);

			prom.then(data=>
				{

					if(data.error === undefined)
					{
						$('[data-title="'+id+'"]').text(data.done)
						self.parent().parent().parent().parent().attr('class','collapse out')
					}else
					{
						alert(data.error);
					}
				})
			return false;

		})

	//

	$('.email').click(function()
	{

	let href = $(this).attr('href');

	        
			sendEmail(href);
	    

			return false;
		})

</script>