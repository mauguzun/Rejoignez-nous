<script>

	$('[data-toggle="tooltip"]').tooltip({ html:true , appendToBody: true ,boundary: 'window', 
	delay: {  "hide": 4000 }} )

	$('*[data-circle]').click(function()
		{


			let data_value = $(this).attr('data-value')
			let url = $(this).parent().attr('data-url')
			let id = $(this).parent().attr('id')

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
	
	function set_change(){
		
		$('.change').on('change',function(){
			
				$(this).attr('disabled','disabled');
				let appid =  $(this).attr("data-application-id"); 
				let function_id  = $(this).val();
			
				$.getJSON('<?= base_url()?>shared//ajax/function_by_admin/'+appid + "/" + function_id )
				.then(done=>{
						
						$(this).removeAttr('disabled');
						try{
							x.ajax.reload();	
						}
						catch(e){
							
						}
					})
			
			})
		
		
		
	}

	$('*[data-status]').click(function()
		{

			$('.pls_hide').fadeOut();

			let statusid = $(this).attr('data-id')
			let appid =  $(this).attr("data-application-id"); 
	
			let id = $(this).attr("data-link");
			
			let prom = $.getJSON($(this).attr('href'));
			let self = $(this);
			
		

			prom.then(data=>
				{

					if(data.error === undefined)
					{
						$('[data-title="'+id+'"]').text(data.done);
						if (statusid === '6'){
							
							$.get('<?= base_url()?>shared//ajax/functions_list/'+appid)
							.then(done=>{
								
									$('[data-function="'+id+'"]').fadeIn();
									$('[data-function-list="'+id+'"]').html(done);
									set_change();
								})
							
							
							
						}else{
							self.parent().parent().parent().parent().attr('class','collapse out')
							try{
								x.ajax.reload();	
							}
							catch(e){
							
							}
						}
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
			sendEmail(href,$(this).attr('data-person'));
			return false;
		})

  

</script>