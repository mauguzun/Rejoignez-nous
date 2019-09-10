
<script>
	

	
$("*[data-clipboard]").unbind('click').click(function(){		
		$.getJSON($(this).attr('data-url')).then((result)=>{	
			if(result.error === undefined){
				$.getJSON("<?= base_url() ?>/shared/offer/copy_row/" + result.done).then((data)=>{
					x.row.add(data[0]).draw();
				});
			}
		});
});
		
		/*counter = 0 ;
		x.row.add( [
            counter +'.1',
            counter +'.2',
            counter +'.3',
        ] ).draw( false );*/
		/*$.getJSON($(this).attr('data-url')).then((result)=>{
			
			
			
			
			 if(result.error === undefined){
				navigator.clipboard.writeText(result.text)
                   .then(() => {
                                                       alert("<?= lang('text_copied_to_clipboard')?>");
                                                   })
                   .catch(err => {
                                                       console.error( err);
                                                   })
            }
		})
		
		
})*/
</script>



