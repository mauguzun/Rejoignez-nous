


<div class="uploader" id="<?= $upload_id?>">


	<strong><?=lang($upload_id)  ?></strong>

		<div id="error">

	</div>
	<div  id="drag-and-drop-zone" class="uploader">
		<div  class="alert alert-primary upload"  style="padding:30px;" >
			<?= lang('Drop Files Here') ?>
		</div>

		
		
			<div class="alert alert-light browser" role="alert">
				
					<span>
						
<button type="button" class="btn btn-warning"><?= lang('Click to open the file Browser') ?></button>
					</span>
					<input type="file" name="<?= $upload_id ?>"
					multiple="multiple" title='Click to add Files'>
				
			</div>

	
	</div>
	<!-- /D&D Markup -->
	<!-- /D&D Markup -->

	<div id="console">
	</div>

	<div id="loglist">
	</div>


	<div id="filelist">
		<?
		if(isset($show_me)) :?>
		<?
		foreach($show_me as $id=> $oneimg) :?>

		<?= img_div($oneimg,$id) ?>
		<? endforeach ;?>

		<? endif;?>
	</div>


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

					$.get("<?= base_url()?>"+'user/main/upload/delete?url=/'+ url ,function(e)
						{
							if(e.error === undefined)
							{
								parent.fadeOut();
							}
						})
				}else
				{

				}
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


