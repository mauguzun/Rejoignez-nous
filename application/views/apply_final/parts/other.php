
<? $name = 'other';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 


<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">
	<div class="card-body">
		
		<div class="row row_mb">
			<div class="col-md-6">
				<div class="input_label"><?= lang('salary')?></div>
			
				<input value="<?= $misc['salary']? $misc['salary'] : null ;?>" name="salary" class="form-control" required />
			</div>
			<div class="col-md-6">
				<div class="input_label"><?= lang('car')?></div>
				<?= 	
				form_dropdown('car', [0=>lang('not_have_car'),1=>lang('have_car')],
					$misc['car'] != null ? $misc['car'] : null ,
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
