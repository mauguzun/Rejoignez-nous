<? $name = 'position';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 
			
<div class="card-body">

	<form method="post" action="<?= $url ?>"   v-on:submit.prevent="send">	
	

		<div class="row row_mb">
			<div class="col-md-6">
				<div class="input_label"><span>*</span><?= lang('create_application_contract')?></div>
				<?= form_dropdown('contract_id',$contracts,
				isset($data['contract_id'])? $data['contract_id'] : null
				,['class'=>'form-control','required'=>'require']) ?>
			</div>
				
			<div class="col-md-6">
				<div class="input_label"><span>*</span><?= lang('function')?></div>
				<input list="function_list" name="function" 
				type="text" 
				value="<?= isset($data['function'])? $data['function'] : null ?>"
				required="" class="form-control">
			</div>

		</div>

		<div class="row_mb buttons_bar">
			<button type="submit" class="btn bg-blue_min" id="publish"><?= lang('save')?></button>
		</div>
			
	</form>


</div>
<datalist id="function_list">
	<?foreach($functions as $value):?>
	<option value="<?= $value['function']?>"><?= $value['function']?> | function</option>
	<? endforeach; ?>
</datalist>

</div>
</div>
</div>
