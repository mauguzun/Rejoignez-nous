<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js">
</script>

<div class="content">
	<div class="row">
		<div class="col-lg-12">
			<table>


				<tr>

					<td>
						<select  id="group" class="form-control change">
							<option value="">

							</option>
							<?
							foreach($groups as $value) :?>

							<?
							if($value['id'] <5 | $value['id'] > 7   ):?>
							<option 
							
							<? if (isset($_GET['group']) && $_GET['group'] == $value['id']):?>
							  selected=""
							<? endif;?>
							
							value="<?= $value['id']?>">
								<?= $value['description']?>
							</option>
							<? endif;?>
							<? endforeach ;?>

						</select>
					</td>



					<td>
						<input type="text"

						class="form-control"
						id="offer"
						placeholder="<?= lang('title')?>"
						style="visibility:hidden"


						>
					</td>
				</tr>
			</table>



		</div>
	</div>
</div>







<script>



$('#group').change(()=>{
	
	let mode = ($('#group').val())
	
	x.ajax.url( "http://localhost/Rejoignez-nous/back/user/ajax?group="+mode ).load();
})


	

	// change url




</script>