
<? $name = 'other';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 


<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">
	<div class="card-body">
		
		<div class="row row_mb">
			<div class="col-md-6">
				<div class="input_label"><?= lang('employ_center')?></div>
			
				<?= 	
				form_dropdown('employ_center', [0=>lang('no'),1=>lang('yes')],
					$employ_center != null ? $employ_center['employ_center'] : null ,
					['class'=>'form-control selectpicker']);
				?>
			</div>
			<div class="col-md-6">
				<div class="input_label"><?= lang('employ_center')?></div>
				<?= 	
				form_dropdown('car', [0=>lang('not_have_car'),1=>lang('have_car')],
					$car != null ? $car['car'] : null ,
					['class'=>'form-control selectpicker']);
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
