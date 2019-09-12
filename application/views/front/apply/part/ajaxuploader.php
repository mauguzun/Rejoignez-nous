


<div class="uploader" id="<?= $upload_id?>">



	<div id="error">

	</div>
	<div  id="drag-and-drop-zone" class="uploader">
		<div  class="alert alert-primary upload"  style="padding:30px;" >
			<?= lang('Drop Files Here') ?>
		</div>



		<div class="alert alert-light browser " role="alert">



			<button type="button" class="btn btn-warning btn-block "><?= lang('Click to open the file Browser') ?></button>

			<input type="file" name="<?= $upload_id ?>"
			multiple="multiple" title='Click to add Files'>

		</div>


	</div>
	<!-- /D&D Markup -->

	<div id="console">
	</div>

	<div id="loglist">
	</div>


	<div id="filelist">
		<?
		if(isset($show_me)) :?>
		<?
		foreach($show_me as $id=>$oneimg) :?>

		<?= img_div_new($oneimg['img'],$id,$oneimg['name']) ?>
		<? endforeach ;?>

		<? endif;?>
	</div>


	<?
	if(isset($apply)) :?>



	<div class="row">


		<div class="col-md-6">
			<center> <a class="btn btn-outline-danger" onclick="return confirm('Are you sure?');" href="<?= $delete ?>" role="button">
					<i class="far fa-trash-alt"></i> Delete	</a></center>


		</div>


		<div class="col-md-6">
			<div class="form-group">

				<center>


					<a href="<?= $apply ?>"  class="btn btn-primary" title=" <?= lang('press_save_to_progres')?>" id="save" type="submit">
						<?= lang('save')?>		<i class="fas fa-arrow-right"></i>

					</a>

				</center></div>
		</div>
	</div>

	<? endif ;?>




</div>



<script>



	function setAction()
	{
		$('.edit a').on('click',function()
			{

				const action = $(this).attr('class')
				const url = $(this).parent().attr('data-img-url');
				const parent = $(this).parent();
				if(action.includes('trash')  )
				{

					$.get("<?= base_url()?>"+'apply/ajaxupload/delete/'+ $(this).attr('id') ,function(e)
						{
							if(e.error === undefined)
							{
								parent.fadeOut();
							}
						})
				}
				else
				{

				}
				return false;
			})

	}

	setAction();

	$("#<?= $upload_id?> #drag-and-drop-zone").dmUploader
	(
		{

			url:'<?= $upload_url ?>' ,
			// only debug mode
			onInit: function()
			{
				console.log('can upload')
			},
			onNewFile: function(id,file)
			{
				console.log('start upload')
				$('#<?=$upload_id?> #error').html('');
				//$("#<?=$upload_id?> #loglist").empty();
				$('#<?=$upload_id?> #loglist').html("<progress id='"+id+"_file' value='1' max='100'></progress> " );
			},


			onUploadProgress: function(id, percent)
			{
				$("#"+id+'_file').attr('value',percent);
				$("#"+id+'_file').attr('title',percent);

			},

			onUploadSuccess: function(id, data)
			{
				let result = JSON.parse(data);
				console.log(result)
				if(result.error !== undefined)
				{
					$('#<?=$upload_id?> #error').append(result.error)
				}
				else
				{
					$('#<?=$upload_id?> #filelist').append(result.upload_data.result);
					setAction();
				}
			},
			onUploadError: function(id, message)
			{
				console.log(message);
				alert('Error trying to upload #' + id + ': ' + message);
			}

		});
</script>
