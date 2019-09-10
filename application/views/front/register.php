

<div class="inner-info register_screen" style="padding-bottom: 20px !important; margin-bottom:30px; max-width:500px;">



	<h4>
		<?php echo lang('create_user_heading');?>
	</h4>
	<br>
	<?php echo form_open("auth/create_user");?>

	<div class="form-group">
		<?php echo form_input($email);?>
	</div>
	<div class="form-group">
		<?php echo form_input($password);?>
	</div>
	<div class="form-group">
		<?php echo form_input($password_confirm);?>
	</div>
	<div class="custom-control custom-checkbox mr-sm-2">
		<input required='require' type="checkbox" class="custom-control-input" id="customControlAutosizing">
		<label  class="custom-control-label" for="customControlAutosizing">
			<a  target="_blank" href="<?=  $privacy_pdf 	?>"><?= lang('register_page_link')?></a>
		</label>
	</div>
	<br>
	<div class="custom-control custom-checkbox mr-sm-2">
		<button class="btn btn-outline-success my-2 my-sm-0 my-button"  type="submit">
			<?= lang('create_user_submit_btn') ?>
		</button>
	</div>
<br><br><br>
	<div class="custom-control custom-checkbox mr-sm-2">

	
		<a href="<?= base_url().'auth/login'?>"  >
			Already registred?
		</a>
	</div>
</div>
	<?php echo form_close();?>






</html>