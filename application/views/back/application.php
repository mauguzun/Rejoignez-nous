

<div class="row">
	<div class="col-lg-12" >

		<!-- Marketing campaigns -->
		<b>
			<?= lang('with_selected')?>
		</b>
		<button class="btn btn-primary square" id="download">
			<i class="far fa-file-archive">
			</i>
		</button>
		<button class="btn btn-primary square" id="print">
			<i class="fa fa-print">
			</i>
		</button> 
        
		<button class="btn btn-primary square" id="email">
			<i class="fa fa-envelope">
			</i>
		</button>



		<!-- /marketing campaigns -->
	</div>
</div>





<script>


   


	$('#download').click(function(){
			let print = [];
			$('input[type="checkbox"]:checked').each(function(){
					print.push($(this).attr('id'));
				})
			if (print.length > 0){
				$('[data-zip]').each((i,e)=>{
						if (print.includes( e.cloneNode(true).getAttribute('data-zip') )) {
							e.click();
						}
					})
			}else{
				alert( "<?= lang('pls_select_some_row') ?>");
			}
		})
   

	$('#print').click(function(){
			let print = [];
			$('input[type="checkbox"]:checked').each(function(){
					print.push($(this).attr('id'));
				})
			if (print.length > 0){
            	
				$('[data-print]').attr('download','download');
				$('[data-print]').each((i,e)=>{
						if (print.includes( e.cloneNode(true).getAttribute('data-print') )) {
							//open tab              
							e.click();                
						}
					})
				$('[data-print]').removeAttr('download');
			}else{
				alert( "<?= lang('pls_select_some_row') ?>");
			}
		})
	
	$("#main").click(function(){
		
		  
			$(".table-checkbox").prop('checked', $(this).prop('checked'));
   		
		})
	
	
	$('#email').click(function(){
    	
			let print  = [];
			$('input[type="checkbox"]:checked').each(function(){
					print.push({
						email:$(this).attr('data-email-id'),
						user:$(this).attr('data-person')
					});
				})
			if (print.length > 0 ){
            	for(let i = 0 ; print[i] ; i++){
					sendEmail(print[i].email ,print[i].user)
				}
				 
			}else{
				alert( "<?= lang('pls_select_some_row') ?>");
			}
		})
</script>
<style>
	.square{
		width: 50px;
	}
</style>

