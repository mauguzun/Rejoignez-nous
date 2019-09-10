 <div class="uploader" id="<?= $upload_id?>">




    <!-- /marketing campaigns -->

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
        if (isset($default_file)) :?>
        <img  width='100px' src='<?= $default_file ?>'  />
        <? endif;?>
    </div>
    <script>
        $("#<?= $upload_id?> #drag-and-drop-zone").dmUploader
        ({

                url:'<?= $upload_url ?>' ,
                // only debug mode
                onInit: function(){

                    console.log('can upload')
                },
                onNewFile: function(id,file)
                {
                    console.log('start upload')
                    $('#<?=$upload_id?> #error').html('');
                    $("#<?=$upload_id?> #loglist").empty();
                    $('#<?=$upload_id?> #loglist').html("<progress id='"+id+"_file' value='1' max='100'></progress> " );
                },


                onUploadProgress: function(id, percent)
                {
                    $("#"+id+'_file').attr('value',percent);

                },

                onUploadSuccess: function(id, data){
                    let result = JSON.parse(data);
                    if(result.error !== undefined){
                        $('#<?=$upload_id?> #error').html(result.error)
                    }else{
                        //  delete old
						
						console.log("<?= $input_selector ?>")
                        let file_input = $("input<?= $input_selector ?>");


                        <? if (isset($delete_url)):?>
                        if (file_input.val() !== undefined){
                            $.get( "<?= $delete_url ?>"+file_input.val(),function( data ) {
                                    console.log( "deleted" );
                                });
                        }
                        <? endif;?>


                        file_input.val(result.done);
                        $("#<?=$upload_id?> #filelist").empty();

                        if(result.file !== undefined && result.file == 'file'){
                            $('#<?=$upload_id?> #filelist').html("<img  width='100px' src='" + result.url+ "'  />" );

                        }else{
                            $('#<?=$upload_id?> #filelist').html("<img  width='100px' src='" + result.url+ "'  />" );

                        }
                    }
                },
                onUploadError: function(id, message){
                    console.log(message);
                    alert('Error trying to upload #' + id + ': ' + message);
                }

            });
    </script>

</div>