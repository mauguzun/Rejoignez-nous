
<? $name = 'aeronautical_experience';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name]); ?> 




<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">
	<div class="card-body">
	
	
			
	
		<div class="row row_mb">
			<? foreach(['b737_classic','b737_ng'] as $name):?>
		
			<div class="col-md-6">
				<div class="input_label"><?= lang($name)?></div>
				
				<? $sel = isset($row[$name]) ? $row[$name] : null ?>
				<?= 			form_dropdown($name, 
					$selects['mechanic_offer_managerial'],$sel,['class'=>'form-control']);
				?>
			</div>

			<? endforeach;?>
			
		
			
		</div>
		<div class="row row_mb">
			
			<div class="col-md-6">
				<div class="input_label"><?= lang('part_66_license')?></div>
				
				<? $sel = isset($row['part_66_license']) ? $row['part_66_license'] : null ?>
				<?= 			form_dropdown('part_66_license', 
					[0=>lang('no'),1=>lang('yes')],$sel,['class'=>'form-control']);
				?>
			</div>

			<div class="col-md-6">
				<div class="input_label"><?= lang('managerial_duties')?></div>
				<? $sel = isset($row['managerial_duties']) ? $row['managerial_duties'] : null ?>
				<?= 			form_dropdown($name, 
					$selects['expirience_managerial'],$sel,['class'=>'form-control']);
				?>
			</div>

		
		
			
		</div>
		
	
		
		<div class="row_mb buttons_bar">
			<button type="submit"    
					class="btn bg-blue_min" id="publish"><?= lang('save')?></button>

		</div>
	</div>
			
</form>
</div>
</div>