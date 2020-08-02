
<div id="content" role="main">
	<div class="breadcrumbs eap-breadcrumbs">
		<a href="<?= base_url()?>" >
			<span>
				<?= lang('Careers') ?>
			</span>
		</a>  &gt;
		<a href="#" >
			<span class="current-page" style="color: #484848 !important;">
				<?php echo lang('create_user_heading');?>
			</span>
		</a>
	</div>

	<!--UPDATE-->
	<div class="view_column_row row_mb3">
		<div class="view_first_column view_rightside_title">
		</div>
		<div class="view_two_column">
			<h1 class="post-title mb_form_title">
				<?php echo lang('create_user_heading');?>
			</h1>
		</div>
	</div>
	<div class="view_column_row row_mb3">
		<div class="view_first_column view_rightside_title">
		</div>
		<div class="view_two_column">

			<?
			if(isset($message)) :?>
			<div class="alert alert-warning" role="alert">
				<i class="fas fa-info-circle">
				</i>
				<?= $message ?>
			</div>
			<?
			else :?>

			<div class="alert alert-primary" role="alert">
				<i class="fas fa-info-circle">
				</i>
				<?= lang('Please follow')?>
				<a href="<?= base_url()?>/auth/login">
					<?= lang('click here to login')?>
				</a>
			</div>

			<? endif ;?>




		</div>
	</div>


	<form action="<?= base_url()?>/auth/create_user" style="margin-bottom: 270px" method="post" accept-charset="utf-8">


		<div class="view_column_row row_mb3">
			<div class="view_first_column view_rightside_title">
				<?php echo lang('login_identity_label', 'identity');?>
			</div>
			<div class="view_two_column v_centered_input">
				<input type="email" class="form-control edit_form_input err_availble" name="email" value="" id="identity" required="require" value="">
				<div class="invalid-feedback" id="email_error">
					<?= lang('Incorrect email')?>
				</div>
				<div class="valid-feedback" id="email_success">
					<?= lang('Email accepted')?>
				</div>
			</div>
		</div>

		<div class="view_column_row row_mb3">
			<div class="view_first_column view_rightside_title">
				<?php echo lang('login_password_label', 'password');?>
			</div>
			<div class="view_two_column v_centered_input">
				<input type="password" class="form-control edit_form_input err_availble" name="password" value="" id="password" required="require">
				<div class="invalid-feedback" id="pwd_error">
					<?= lang('Invalid Password')?>
				</div>
				<div class="valid-feedback" id="pwd_success">
					<?= lang('Password accepted')?>
				</div>
			</div>
		</div>

		<div class="view_column_row row_mb3">
			<div class="view_first_column view_rightside_title">
				<?php echo lang('create_user_password_confirm_label', 'password');?>
			</div>
			<div class="view_two_column v_centered_input">
				<input type="password" class="form-control edit_form_input err_availble" name="password_confirm" value="" id="password_confirm" required="require">
				<div class="invalid-feedback" id="pwd_error_conf">
					<?= lang("Password don't match")?>
				</div>
				<div class="valid-feedback" id="pwd_success_conf">
					<?= lang("Password matches")?>
				</div>
			</div>
		</div>

		<div class="view_column_row row_mb">
			<div class="view_first_column view_rightside_title">
			</div>
			<div class="view_two_column">
				<div class="custom-control custom-checkbox mr-sm-2">
					<input required='require' type="checkbox" class="custom-control-input" id="customControlAutosizing">
					<label  class="custom-control-label" for="customControlAutosizing">
						<a  target="_blank" href="<?=  $privacy_pdf 	?>">
							<?= lang('register_page_link')?>
						</a>

					</label>
				</div>
			</div>
		</div>

		<div class="view_column_row row_mb3">
			<div class="view_first_column view_rightside_title">

			</div>
			<div class="view_two_column">
				<button class="blue_btn" type="submit" id="register_form">
					<?= lang('create_user_submit_btn')?>
				</button>


			</div>
		</div>

		<div class="view_column_row row_mb3">
			<div class="view_first_column view_rightside_title">
			</div>
			<div class="view_two_column">

				<a href="forgot_password" class="forgot_pwd">
					<?php echo lang('login_forgot_password');?>
				</a>

			</div>
		</div>


	</form>

	<!--loader-->




</div><!-- #content -->
</div><!-- #primary -->