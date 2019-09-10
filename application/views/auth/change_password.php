
<?
if(isset($message) && $message != "") :?>
<div class="alert alert-info alert-dismissible"  role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">
			<i class="ion-android-close">
			</i>
		</span>
	</button>
	<i class="fa fa-exclamation-circle fa-2x">
	</i>     <?php echo $message;?>
</div>
<? endif ;?>
<h1><?php echo lang('change_password_heading');?></h1>

<div class="checkout-form">

	<div class="row">
	<div class="col-sm-6">
			<div class="heading-block left-head text-left">

			</div>


			<article>
				<h3>VÅRE PRODUKTER.</h3>
				<p>VÅRE PRODUKTER SELGES KUN TIL SERTIFISERTE VIPPETERAPEUTER. ALLE PRISER INKL. MVA.</p>
			</article>
			<br />
			<br />
			<br />

			<?= isset($additional) ? $additional  : NULL ; ?>


		</div>
		<div class="col-sm-6">

			<?php echo form_open("auth/change_password");?>

			<p>
				<?php echo lang('change_password_old_password_label', 'old_password');?> <br />
				<?php echo form_input($old_password);?>
			</p>

			<p>
				<label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> <br />
				<?php echo form_input($new_password);?>
			</p>

			<p>
				<?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> <br />
				<?php echo form_input($new_password_confirm);?>
			</p>

			<?php echo form_input($user_id);?>
			<p><?php echo form_submit('submit', lang('change_password_submit_btn'));?></p>

			<?php echo form_close();?>
		</div>
	</div>
</div>
