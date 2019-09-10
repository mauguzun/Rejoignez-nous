
<div id="content" role="main">
	<div class="breadcrumbs eap-breadcrumbs">
			<a href="<?= base_url()?>" ><span><?= lang('Careers') ?></span> </a>  &gt; <span class="current-page"> <?php echo lang('login_heading');?><span></span></span></div>

	<h1 class="post-title"><?php echo lang('login_heading');?></h1><br>
	<?// echo lang('login_subheading');?>


	<?php echo form_open("auth/login",[ "style"=>"margin-bottom: 270px"]);?>
	<div class="form-group">


		<?php echo form_input($identity);?>

	</div>
	<div class="form-group">

		<?php echo form_input($password);?>		</div>


	<div class="form-group">

		<a href="forgot_password"><?php echo lang('login_forgot_password');?></a>
	</div>

	<div class="form-group">
		<button class="btn btn-primary" type="submit" style="padding-left:20px; padding-right:20px;"><?= lang('login_submit_btn')?></button>

	</div>

	<div class="form-group">
		<a href="http://careers.aslairlines.com/auth/create_user">
			Register first</a>
	</div>
	</form>





</div><!-- #content -->
<div id="sidebar-right">
</div>
</div><!-- #primary -->