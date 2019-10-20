
<? $name = 'medical_aptitudes';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 



	
<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">
	<div class="card-body">
		
		<div class="row row_mb">
			<div class="col-md-12">
				<h5><?= lang('do_you_have_class')?></h5>
				<div class="input_label"><span>*</span>
					<?= lang('end_date_last_medical_visit')?></div>
				<input required="required" 
				name="date"
				data-calendar="true" value="<?= $medical ?>"
				class="form-control" />

			</div>
					
		</div>
					
		<div class="row_mb buttons_bar">
			<button type="submit"    
					class="btn bg-blue_min" id="publish"><?= lang('save')?></button>
			<!--	<button type="button" class="sc_button_disabled" id="cancel_button">Cancel</button>-->
		</div>
		
	</div>
</form>
</div>
</div>
