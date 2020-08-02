
<div id="content" role="main">


	<div class="breadcrumbs eap-breadcrumbs">
		<a href="<?= base_url()?>" >
			<span>
				<?= lang('Careers') ?>
			</span>
		</a>  &gt;
		<a href="#" >
			<span class="current-page" style="color: #484848 !important;">
             
				<?php echo lang('login_heading');?>

			</span>
            
		</a>
	</div>
    

  
	<!--UPDATE-->    
	<div class="view_column_row row_mb3">
		<div class="view_first_column view_rightside_title">
		</div>
		<div class="view_two_column">
			<h1 class="post-title mb_form_title">
				<?php echo lang('login_heading');?>    </h1>
		</div>
	</div>
	<div class="view_column_row row_mb3">
		<div class="view_first_column view_rightside_title">
		</div>
		
	
		<? if(empty($message)):?>
		<div class="view_two_column">
			<div class="alert alert-primary"
         role="alert"><i class="fas fa-info-circle">
         	
				</i><?= lang('Please use')?>
				<a href="<?= base_url()?>/auth/create_user">
					<?= lang('click here to create one')?>   </a>. </div>
           
           
		</div>
		<? else :?>
		<div class="view_two_column">
			<div class="alert alert-warning"
         role="alert"><i class="fas fa-info-circle">
         	
				</i><?= $message ?> </div>
          
           
		</div>
		<? endif; ?>
		
	</div>

	<form action="<?= base_url()?>/auth/login" style="margin-bottom: 270px" method="post" accept-charset="utf-8">

		<div class="view_column_row row_mb3">
			<div class="view_first_column view_rightside_title">
				<?php echo lang('login_identity_label', 'identity');?>
			</div>
			<div class="view_two_column v_centered_input">
				<input type="email" class="form-control edit_form_input err_availble" name="identity" value="" id="identity">
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
				<input type="password" class="form-control edit_form_input err_availble" name="password" value="" id="password">
				<div class="invalid-feedback" id="pwd_error">
					<?= lang('Invalid Password')?>
				</div>
				<div class="valid-feedback" id="pwd_success">
					<?= lang('Password accepted')?>
				</div>
			</div>
		</div>

		<div class="view_column_row row_mb">
			<div class="view_first_column view_rightside_title">

			</div>
			<div class="view_two_column">
				<div class="form-group form_ttip">
					<button class="blue_btn" role="submit" type="submit">
						<?= lang('login_submit_btn') ?>
					</button>
                
    
					<a href="forgot_password" class="forgot_pwd">
						<?php echo lang('login_forgot_password');?>       </a>
				</div>
			</div>
		</div>

	</form>
	<!--UPDATE-->





</div><!-- #content -->
</div><!-- #primary -->