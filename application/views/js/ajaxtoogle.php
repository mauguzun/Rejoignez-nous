<script>
	$("*[data-selector='<?= $selector?>']").unbind("click").click(function()
		{


			if (confirm("Are You Sure?") == false)
			{
				return ;
			}

			const text = $(this).text();
			let element = $(this);



			element.attr("style","opacity:0.5");


			let promise = $.post("<?= $url ?>",
				{
					id: $(this).attr('id'),
					text: text,
					table : $(this).attr('data-table'),
					value : $(this).attr('data-value'),
					column : $(this).attr('data-column'),

				} );


			promise.error((httpObj, textStatus) =>
				{
					if(httpObj.status==401)
					alert("Yod dont have acess")

					element.removeAttr("style");
				});

			promise.then(data=>
				{



					let result = JSON.parse(data);
					if(result.error === undefined)
					{
						$(this).attr('class',result['class']);
						$(this).attr('data-value',result['value']);
						$(this).text(result.text);
					}

					element.removeAttr("style");

				})

		})


</script>