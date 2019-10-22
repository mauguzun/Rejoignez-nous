
<? $name = 'expirience';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name]); ?> 




<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">
	<div class="card-body">
	
	
			
		<? foreach($exp as $key=>$oneRow):?>
		<div class="row row_mb"  ref="<?='exp'.$key?>" >
			<div class="col-md-4">
				<div class="input_label"><span>*</span><?= lang('area')?></div>
				<input list="lang-list" 
				value="<?= isset($oneRow['area']) ? $oneRow['area'] : NULL ?>"   name="area[]" class="form-control"  required="true" >
			</div>
			
			
			
			<? foreach($selects as $name=>$array):?>
			<div class="col-md-3">
				<div class="input_label"><span>*</span><?= lang($name)?></div>
				<select class="form-control" name="<?= $name ?>[]" >
					<? foreach($array as $id=>$text):?>
					<option
					<?= isset($oneRow[$name]) && $oneRow[$name] ==  $id ? 'selected ' : NULL ?>
					 value="<?=$id?>"><?= $text ?></option>
					<? endforeach;?>
				</select>
			</div>
			<? endforeach;?>
			
			
			<div class="col-md-1 illarion">
				<? if($key == 0 ):?>
				<i  @click="addRow('exp')" class="fas fa-plus-square"></i>
				<? else : ?>
				<i @click="removeTemplate('<?='exp'.$key?>')"  class="fas fa-minus-square"></i>
				<? endif;?>

			</div>
		</div>
		<? endforeach ;?>
		
		
		
		
		<div class="row row_mb" v-for="(n)  in expRows"  :key="n.id">
			
			<div class="col-md-4">
				<div class="input_label"><span>*</span><?= lang('area')?></div>
				<input list="lang-list" name="area[]" class="form-control"  required="true" >
			</div>
			
			
			
			<? foreach($selects as $name=>$array):?>
			<div class="col-md-3">
				<div class="input_label"><span>*</span><?= lang($name)?></div>
				<select class="form-control" name="<?= $name ?>[]" >
					<? foreach($array as $id=>$text):?>
					<option value="<?=$id?>"><?= $text ?></option>
					<? endforeach;?>
				</select>
			</div>
			<? endforeach;?>
			
			
			<div class="col-md-1 illarion">
				<i @click="removeRow(n,'exp')"  class="fas fa-minus-square"></i>
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