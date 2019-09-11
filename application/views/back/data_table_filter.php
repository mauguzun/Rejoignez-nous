<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js">
</script>

<div class="content">
	<div class="row">
		<div class="col-lg-12">
			<table>


				<tr>
					<?
					if(  !$category_id ):?>
					<td>
						<select id="mode" class="form-control change">
							<option value=""></option>

							<option value="0"><?= lang('all applications recived')?></option>
							<option value="5"><?= lang('unsolicited_application_applys')?></option>
							<option value="7"><?= lang('manualay_applications')?></option>
							<option value="4"><?= lang('Mecanicien')?></option>
							<option value="3"><?= lang('PNT')?></option>
							<option value="2"><?= lang('PNC')?></option>
							<option value="1"><?= lang('HR')?></option>
						</select>
					</td>


					<?
					elseif(is_array($category_id)) :?>

					<td>
						<select id="mode" class="form-control change">
							<option value=""></option>

							<option value="0"><?= lang('all applications recived')?></option>
							<option value="4"><?= lang('Mecanicien')?></option>
							<option value="1"><?= lang('HR')?></option>
						</select>
					</td>

					<? endif; ?>

					<td>
						<select id="status" class="form-control change">
							<option value=""></option>

							<option value="0"><?= lang('all applications recived')?></option>

							<?
							foreach($statuses as $value):?>
							<option value="<?= $value['id']?>"><?= $value['status']?></option>
							<? endforeach;?>
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

	

	$('.change').change(function()
		{
			request();
		})




	function request()
	{
		let mode = $("#mode").val()
		let status = $("#status").val();
		let offer =     $("#offer").val() ;
		window.history.replaceState(null,null,  `?mode=${mode}&status=${status}&offer=${offer}`);

		x.ajax.url( "<?= $url ?>?mode="+mode +"&offer="+offer+"&status="+status  ).load();
	}
	$("#offer").change(function()
		{
			request();
		});


	$('#offer').typeahead(
		{
			/*updater: function(item)
			{


			},*/

			source: function (query, result)
			{
				let request =  $.ajax(
					{
						url: "<?= base_url()?>shared/applications/offer_titles?mode="+$("#mode").val(),
						data :
						{
							'query' : query,
						},
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
		});
	
	// change url 
	
	let searchParams = new URLSearchParams(window.location.search);
	if(searchParams.has('mode') | searchParams.has('status')){
				  
		
		
		
		$("#mode").val(searchParams.get('mode'))
		$("#status").val(searchParams.get('status'));
		request();
	}
</script>