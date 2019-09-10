<div class="col-md-8 info">

	<div class="inner-info">
		<h3>

			<?= $title?>
		</h3>
		<p class="sub-string" style="margin-bottom:10px;margin-top:10px;">
			<?= lang('in_law');?>
		</p>




		<?
		if(isset($special_buttons)) :?>
		<div class="dropdown"  style="width: 100%;">
			<button class="btn btn-secondary " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?= lang('other_options') ?>
				<span class="badge"><?= count($special_buttons) ?></span>
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

				<?
				foreach($special_buttons as $key=>$value):?>
				<a  href="<?= base_url().'user/'.$key?>" class="dropdown-item"  >
					<?= lang($value) ?>
				</a>

				<? endforeach ; ?>
			</div>
			
			
			<a download="" href="<?= base_url().'user/main/printdata' ?>">
				<button class="btn btn-secondary " type="button" aria-haspopup="true" >
					<i  class="fa fa-print" style="color:#fff;"></i>
				</button>
			</a>
		</div>
		<? endif;?>
		<br><br><br>



		<?
		if(isset($table)) :?>
		<div class="inner-info">
			<?= $table ?>
		</div>

		<? endif ;?>



		<button id="openModal" class="btn btn-outline-success my-2 my-sm-0" type="submit" style="float: right;">
			<?= lang('upload_files')?>
		</button>

		<!-- <?php echo form_close();?>-->
	</div>
</div>





<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/sum">
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js">
</script>
<script src="<?= base_url()?>css/locales/bootstrap-datepicker.<?= $this->session->userdata('lang') ?>.min.js" >
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" />




<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js">
</script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>

<script>

	$('#openModal').click(function()
		{

			$('#footerModal').modal('show');
			$('#footerModal').on('hidden.bs.modal', function ()
				{
				  location.reload();
				})
		})




	$('*[data-form-url]').click(function()
		{

			let $form = $('#form');
			$form.attr('action',$(this).attr('data-form-url'));

			var validator = $form.validate(options);
			if (validator.form())
			{
				$form.submit();
			}
		})

	<? if (isset($hidden) && isset($hidden_select_value)) :?>
	$('*[data-hidden]').change(function()
		{

			if($(this).val() != "<?= $hidden_select_value ?>")
			{
				$("#hidden").html('<?= isset($hidden)?str_replace("\n","",$hidden):NULL;?>') ;
			}else
			{
				$("#hidden").html("") ;
			}

		})
	<? endif ;?>

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

	/* $('textarea').summernote({
	maxTextLength:2500
	});*/

</script>