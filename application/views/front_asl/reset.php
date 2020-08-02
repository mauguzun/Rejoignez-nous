
<div id="content" role="main">


	<div class="breadcrumbs eap-breadcrumbs">
		<a href="<?= base_url()?>" ><span><?= lang('Careers') ?></span> </a>  &gt; <span class="current-page" style="color: #484848 !important;"> <?php echo lang('forgot_password_heading');?><span></span></span></div>
	<h1 class="post-title"><?php echo lang('forgot_password_heading');?></h1><br>

	
	
	
	<!--UPDATE-->    
	<div class="view_column_row row_mb3">
		<div class="view_first_column view_rightside_title">
		</div>
		<div class="view_two_column">
			<h1 class="post-title mb_form_title">
				<?php echo lang('forgot_password_heading');?>   </h1>
		</div>
	</div>	
	<div class="view_column_row row_mb3">
		<div class="view_first_column view_rightside_title">
		</div>
    
    
		<div class="view_two_column">
			<?
			if(isset($message)) :?>
			<div class="alert alert-warning" role="alert"><i class="fas fa-info-circle"></i>
				<?php echo $message ?>
	   
			</div>
			<?
			else :?>

			<div class="alert alert-primary" role="alert"><i class="fas fa-info-circle"></i>
				<?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?>
	   
			</div>
			<? endif ; ?>
		</div>
    
      
 
    
    
    
	</div>

	
	<form action="<?= base_url()?>/auth/forgot_password" style="margin-bottom: 270px" method="post" accept-charset="utf-8">
	
		<div class="view_column_row row_mb3">
			<div class="view_first_column view_rightside_title">
				<?php echo lang('login_identity_label', 'identity');?>
			</div>
			<div class="view_two_column v_centered_input">
				<input type="email" class="form-control edit_form_input err_availble" name="identity" value="" id="identity" required="require" >
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

			</div>
			<div class="view_two_column">
				<div class="form-group form_ttip">
					<button class="blue_btn" type="submit">
						<?= lang('forgot_password_submit_btn')?>
					</button>

				</div>
			</div>
		</div>


	</form>
	<!--UPDATE--> 





</div><!-- #content -->
</div><!-- #primary -->


