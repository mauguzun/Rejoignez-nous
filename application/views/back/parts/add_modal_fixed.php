
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css"
/>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js">
</script>


<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js">
</script>



<div class="col-lg-12">

	<!-- Marketing campaigns -->
	<div class="panel panel-flat">
		<div class="panel-heading" style="background-color:white; color:#105497; border:0px;">
			<h6 class="panel-title">
				<b>
					<?php echo $title;?>
				</b>

			</h6>
		</div>
		<?php echo form_open_multipart($url,['id'=>'form']);?>
		<div class="table-responsive">
			<div class="col-md-12">

				<div class="row">
					<br>
					<?
					foreach($control as $key => $value) :?>
					<div class="col-md-12">

						<div class="form-group">
							<?= $value ?>

						</div>
						<div style="color:red;text-align:center;"  data-error="<?=  $key ?>" class="col-md-12">

						</div>
					</div>
					<? endforeach ;?>


				</div>

			</div>
		</div>



		<div class="panel-heading" style="background-color:white; color:#105497; border:0px;">
			<br>
			<div id="up_error" class="error">

			</div>

			<div class="heading-elements">

				<?
				foreach($buttons as $text=>$url):?>

				<button data-form-url="<?= $url ?>"  class="btn btn-primary" >
					<b>
						<?= lang($text) ?>
					</b>
				</button>&nbsp;&nbsp;
				<? endforeach ?>





				<?
				if(isset($cancel)) :?>

				<a href="<?= $cancel ?>" class="btn btn-primary" >
					<b>
						<?= lang('cancel') ?>
					</b>
				</a>&nbsp;&nbsp;

				<? endif ?>

			</div>
			<br>
		</div>
		<?php echo form_close();?>
	</div>
</div>




<script>




	if( typeof  summernote === 'undefined')
	{
		const loadme = ['https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js',
			"<?= base_url().'/css/back/ajax-bootstrap-select.min.js' ?>",
			"https://rawgit.com/dbrekalo/fastselect/master/dist/fastselect.standalone.min.js",
			'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js'];

		let promisArray = [];

		loadme.forEach(i =>
			{

				let script =  $.getScript( i, function( data, textStatus, jqxhr )
					{
						console.log( textStatus ); // Success
					});
				promisArray.push(script);
			});



		Promise.all(promisArray).then(e=>
			{


	   $('[name=fake_start_date]').change(function()
		{
			if($(this).val() == 'Immediate'){
				$('#start_date').val('Immediate');
				$('#start_date').datepicker('remove');
			}else{
				initCalendar();

			}
		})

				setSumer();

				let initCalendar = function()
				{


					$('*[data-calendar]').datepicker(
						{
							todayBtn: "linked",
							clearBtn: true,
							daysOfWeekHighlighted: [6,0],
							autoclose: true,
							format: 'dd/mm/yyyy',
							weekStart:1,
							language: "<?= $this->session->userdata('lang') ?>"
						});

				}
				initCalendar();


				$('*[data-calendar]').on('keydown',function()
					{
						$(this).datepicker('remove');
					});

				$('*[data-calendar]').on('click',function()
					{
						initCalendar()
					});




				for(let i in callFunctions)
				{
					callFunctions[i]();
				}


				/*try{
				setupAutocomplete()
				}catch(e){
				console.log("auto not found")
				}


				try{
				setupFastsearch()
				}catch(e){
				console.log("setupFastsearch not found")
				}*/

			});
	}
	else
	{


	}




</script>
