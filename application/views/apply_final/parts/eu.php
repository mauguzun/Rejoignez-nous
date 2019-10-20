
<? $name = 'eu';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name]); ?> 



<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">
	<div class="card-body">
		<div class="row row_mb">
			<div class="col-md-6">
				<div class="input_label"><span>*</span><?= lang('eu_nationality')?></div>

				<?=  form_dropdown('eu_nationality', [0=>lang('no'),1=>lang('yes')],$eu_nationality,['class'=>'form-control selectpicker']); ?>
			</div>
			<div class="col-md-6">
				<div class="input_label"><span>*</span><?= lang('can_work_eu')?></div>
				<?=  form_dropdown('can_work_eu', [0=>lang('no'),1=>lang('yes')],$can_work_eu,['class'=>'form-control selectpicker']); ?>

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