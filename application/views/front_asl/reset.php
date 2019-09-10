
<div id="content" role="main">


	<div class="breadcrumbs eap-breadcrumbs">
			<a href="<?= base_url()?>" ><span><?= lang('Careers') ?></span> </a>  &gt; <span class="current-page"> <?php echo lang('forgot_password_heading');?><span></span></span></div>
	<h1 class="post-title"><?php echo lang('forgot_password_heading');?></h1><br>

	<?
	if(isset($message)) :?>
	<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>
		<?php echo $message;?>
	</div>
	<?
	else :?>

	<div class="alert alert-primary" role="alert"><i class="fas fa-info-circle"></i>
	<?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?>
	</div>

	<? endif ; ?>

	<?php echo form_open("auth/forgot_password",[ "style"=>"margin-bottom: 270px"]);?>
	<div class="form-group">


		<?php echo form_input($identity);?>

	</div>
	




	<div class="form-group">
		<button class="btn btn-primary" type="submit" style="padding-left:20px; padding-right:20px;">
		<?= lang('forgot_password_submit_btn')?></button>

	</div>


	<?php echo form_close();?>






</div><!-- #content -->
<div id="sidebar-right">
</div>
</div><!-- #primary -->