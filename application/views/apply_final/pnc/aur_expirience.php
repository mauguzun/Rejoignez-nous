<? $name = 'aeronautical_experience';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 
			
<div class="card-body">

	<form method="post" action="<?= $url ?>"   v-on:submit.prevent="send">	
	

		<div class="row row_mb"   v-for="n in expRows"  :key="n.id" >
		
			<div :class=" n.flag === true ? 'col-md-7' : 'col-md-11' "   >
				<div class="input_label"><span>*</span><?= lang('function')?></div>
				<input @change="aurExp(n)"  name="function[]"   list="function" type="text" class="form-control">
			</div>
	
	 
			<template v-if="n.flag === true ">
				<div class="col-md-2">
					<div class="input_label"><span>*</span><?= lang('duration')?></div>
					<input name="duration[]" type="text" class="form-control">
				</div>
		
				<div class="col-md-2">
					<div class="input_label"><span>*</span><?= lang('company')?></div>
					<input name="company[]" type="text" class="form-control">
				</div>
			</template>
			<template v-if="n.flag!= true ">
				<input name="duration[]" type="hidden" class="form-control">
				<input name="company[]" type="hidden" class="form-control">
			</template>
		
	
	
			
			<div v-if="n.id === 1" class="col-md-1 illarion">
		
				<i @click="addRow('exp')" class="fas fa-plus-square"></i>
			</div>
				
				
			<div v-if="n.id != 1"  class="col-md-1 illarion ">
				<i @click="removeRow(n,'exp')" class="fas fa-minus-square"></i>
			</div>
	
		
				
		</div>
		
	
	
		<? if(isset($exp) && $exp):?>
		<!-- -->
		
		<? foreach($exp as $key=>$row):?>
		<div class="row row_mb"  ref="<?= 'exp'.$row['id'] ?>" >
		
		
			<div class=" <?= $row['company'] ? 'col-md-7' : 'col-md-11' ?> "   >
				<div class="input_label"><span>*</span><?= lang('function')?></div>
				<input  name="function[]"    
				value="<?= $row['function']?>"  
				@change="extraEx"
				id="<?= 'exp_'.$key ?>"
				list="function" type="text" class="form-control">
			</div>
			
			
			
			<article  ref="<?= 'exp_'.$key ?>"  <?= $row['company'] ? '':'hidden'?>>
				<div class="col-md-2">
					<div class="input_label"><span>*</span><?= lang('duration')?></div>
					<input name="duration[]"    
					value="<?= $row['duration']?>" type="text" class="form-control">
				</div>
		
				<div class="col-md-2">
					<div class="input_label"><span>*</span><?= lang('company')?></div>
					<input name="company[]"  
					value="<?= $row['company']?>" 
					type="text" class="form-control">
				</div>
			
			
			</article>	
				
				
			<? if($key == 0 ):?>
			
			<div class="col-md-1 illarion">
		
				<i @click="addRow('exp')" class="fas fa-plus-square"></i>
			</div>
			<? else :?>
				
			<div class="illarion">
				<i @click="removeTemplate('<?= 'exp'.$row['id'] ?>')" class="fas fa-minus-square"></i>
			</div>
			<? endif; ?>
		</div>
		
		
		<? endforeach;?>
		<!-- -->
		<? endif; ?>
	
	   


		<div class="row_mb buttons_bar">
			<button type="submit" class="btn bg-blue_min" id="publish"><?= lang('save')?></button>
		</div>
			
	</form>


</div>

	 
<datalist id="function">
	<? foreach($functions as $row ):?>
	<option value="<?= $row['function_name']?>"><?= $row['function_name']?></option>
		
	<? endforeach;?>
</datalist>
</div>
</div>
</div>
