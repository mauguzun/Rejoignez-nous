
<div id="content" role="main">


	<div class="breadcrumbs eap-breadcrumbs">
			<a href="<?= base_url()?>" ><span><?= lang('Careers') ?></span> </a>  &gt; <span class="current-page" style="color: #484848 !important;">  <?php echo lang('reset_password_heading');?><span></span></span></div>
	<h1 class="post-title"> <?php echo lang('reset_password_heading');?></h1><br>

	<?
	if(isset($message)) :?>
	<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i>
		<?php echo $message;?>
	</div>


	<? endif ; ?>

	<?php echo form_open("auth/reset_password/". $code,[ "style"=>"margin-bottom: 270px"]);?>
	<div class="form-group">
		<?php echo form_input($new_password);?>
	</div>
	<div class="form-group">
		<?php echo form_input($new_password_confirm);?>
	</div>
	
	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>
                <br>

	<div class="form-group">
		<button class="btn btn-primary" type="submit" style="padding-left:20px; padding-right:20px;"><?= lang('reset_password_submit_btn')?></button>

	</div>


	<?php echo form_close();?>






</div><!-- #content -->
</div><!-- #primary -->