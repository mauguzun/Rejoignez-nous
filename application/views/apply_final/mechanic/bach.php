
<? $name = 'aeronautical_baccalaureate';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 


<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">
	<div class="card-body">
		
		<div class="row row_mb">
			<? foreach(['aeronautical_baccalaureate','complementary_mention_b1','complementary_mention_b2'] as $name):?>
		
			<div class="col-md-4">
				<div class="input_label"><?= lang($name)?></div>
				
				<? $sel = isset($row[$name]) ? $row[$name] : null ?>
				<?= 			form_dropdown($name, 
					[0=>lang('no'),1=>lang('yes')],$sel,['class'=>'form-control']);
				?>
			</div>

			<? endforeach;?>
			
		
			
		</div>
		<div class="row row_mb">
			<div class="col-md-4">
				<div class="input_label"><?= lang('school')?></div>
			
				<input 
				
				value="<?=  isset($row['school']) ? $row['school'] : null ?>"
				name="school" required="" class="form-control" />
			</div>
			
				<? foreach(['licenses_b1','licenses_b2'] as $name):?>
		
			<div class="col-md-4">
				<div class="input_label"><?= lang($name)?></div>
				
				<? $sel = isset($row[$name]) ? $row[$name] : null ?>
				<?= 			form_dropdown($name, 
					[0=>lang('no'),1=>lang('yes')],$sel,['class'=>'form-control']);
				?>
			</div>

			<? endforeach;?>
			
		</div>
	
	
	<div class="row_mb buttons_bar">
		<button type="submit"    
					class="btn bg-blue_min" ><?= lang('save')?></button>
	</div>
		
	</div>
</form>
</div>
</div>
