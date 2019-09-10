
<div id="content" role="main">
	<div class="breadcrumbs eap-breadcrumbs">
		<a href="<?= base_url()?>" ><span><?= lang('Careers') ?></span> </a>  &gt; 
		<a href="#" ><span class="current-page">
				<?php echo lang('create_user_heading');?></span></a></div>

	<h1 class="post-title"><?php echo lang('create_user_heading');?></h1><br>
	
<!--	<?
	if(isset($message)) :?>
	<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>
		<?php echo $message;?>
	</div>
	<?
	else :?>-->

	<div class="alert alert-primary" role="alert"><i class="fas fa-info-circle"></i>
		<? echo lang('create_user_subheading');?>
	</div>

<!--	<? endif ; ?>-->

	<?php echo form_open("auth/create_user",[ "style"=>"margin-bottom: 270px"]);?>
	<div class="form-group">


		<?php echo form_input($email);?>

	</div>


	<div class="form-group">

		<?php echo form_input($password);?>		</div>

	<div class="form-group">
		<?php echo form_input($password_confirm);?>
	</div>
	<div class="form-group">

		<div class="custom-control custom-checkbox mr-sm-2">
			<input required='require' type="checkbox" class="custom-control-input" id="customControlAutosizing">
			<label  class="custom-control-label" for="customControlAutosizing">
				<a  target="_blank" href="<?=  $privacy_pdf 	?>"><?= lang('register_page_link')?></a>
			</label>
		</div>
	</div>




	<div class="form-group">
		<button class="btn btn-primary"
		type="submit" style="padding-left:20px; padding-right:20px;"><?= lang('create_user_submit_btn')?></button>

	</div>


	<?php echo form_close();?>






</div><!-- #content -->
<div id="sidebar-right">
</div>
</div><!-- #primary -->