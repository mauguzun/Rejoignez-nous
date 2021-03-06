

<div class="row">
	<div class="col-lg-12" >

		<!-- Marketing campaigns -->
		<b>
			<?= lang('with_selected')?>
		</b>
		<button data-toggle="tooltip" data-placement="top" title="<?= lang('zip')?>"  class="btn btn-primary square" id="download">
			<i class="far fa-file-archive">
			</i>
		</button>
		<button  data-toggle="tooltip" data-placement="top" title="<?= lang('print') ?>"  class="btn btn-primary square" id="print">
			<i class="fa fa-print">
			</i>
		</button> 
        
		<button  data-toggle="tooltip" data-placement="top" title="<?= lang('email') ?>" class="btn btn-primary square" id="email">
			<i class="fa fa-envelope">
			</i>
		</button>
		
		<button  data-toggle="tooltip" 
		data-placement="top" title="<?= lang('delete') ?>"
		 class="btn btn-primary square" id="delete">
			<i class="fa fa-trash">
			</i>
		</button>



		<!-- /marketing campaigns -->
	</div>
</div>





<script>

	$("#delete").click(function(){
		
		
			if( $('input[type="checkbox"]:checked').length == 0 ){
				alert( "<?= lang('pls_select_some_row') ?>");
				return;
			}
			if (confirm('<?= lang("are_you_sure")?>')){
				$('input[type="checkbox"]:checked').each(function(index, element){
					
					if( $(this).attr('id') !== 'main'){
						$.getJSON(  '<?= base_url()?>shared/ajax/delete_app_by_id/' + $(this).attr('id')).then(()=>{
								if (index === ($('input[type="checkbox"]:checked').length - 1)) {
									x.ajax.reload();
								}
							})
					}
						
					})
					
			}
		  
		
   		
		})
	

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
					if ($(this).attr('data-person')){
						print.push({
								email:$(this).attr('data-email-id'),
								user:$(this).attr('data-person')
							});
					}
					
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

