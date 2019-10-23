
<? $name = 'foreignlang';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 



	
<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">
	<div class="card-body">
		
		
		<? foreach( ['french_level','english_level'] as $name) :?> 
		<div class="row row_mb">
			<div class="col-md-6">

				<input  disabled=""  type="text" value="<?= lang($name)?>" class="form-control">
			</div>
			<div class="col-md-5">
					
				<select name="<?= $name ?>" class="form-control selectpicker" >
					<?foreach($lang_level as $id=> $value):?>
					<option 
					<?= $levels && $levels[$name] == $id ? 'selected' : null ?>
					
					value="<?=$id?>"> <?= $value ?></option>
					<? endforeach ;?>
				</select>
			</div>
				
			<div class="col-md-1 illarion"  >
				<? if($name == 'english_level'):?>
				<i @click="addRow('lang')" class="fas fa-plus-square"></i>
				<? endif ;?>
					
			</div>
				
				
		</div>
				
		<? endforeach ;?>
			
		
			
		<? if(isset($extra)):?>
		<? foreach($extra as $k=>$row) :?>
		<!---->
		<span ref="<?='lang'.$k?>" >
			<div class="row row_mb"   >
				<div class="col-md-6">
					<input list="langs" value="<?= $row['language']?>" name="language[]" class="form-control"  required="true" >
				</div>
				<div class="col-md-5">
					
					<select name="level_id[]" class="form-control selectpicker" >
						<?foreach($lang_level as $id=> $value):?>
						<option 
						<?= $row['level_id'] && $row['level_id'] == $id ? 'selected' : null ?>
						value="<?=$id?>"> <?= $value ?></option>
						<? endforeach ;?>
					</select>
				</div>
			
				<div class="col-md-1 illarion">
					<i @click="removeTemplate('<?='lang'.$k?>')"  class="fas fa-minus-square"></i>
				</div>
			</div>
		</span>
		<!---->
		<? endforeach ;?>
			
			
		<? endif;?>
			
		<div class="row row_mb" v-for="n in langRows"  :key="n.id">
			<div class="col-md-6">
				<input list="lang-list" name="language[]" class="form-control"  required="true" >
			</div>
			<div class="col-md-5">
					
				<select name="level_id[]" class="form-control selectpicker" >
					<?foreach($lang_level as $id=> $value):?>
					<option value="<?=$id?>"> <?= $value ?></option>
					<? endforeach ;?>
				</select>
			</div>
			
			<div class="col-md-1 illarion">
				<? if($name == 'english_level'):?>
				<i @click="removeRow(n,'lang')"  class="fas fa-minus-square"></i>
					
					
				<? endif ;?>
					
			</div>
		</div>
		<div class="row row_mb" >
		
		
			
			<div class="col-md-12">
			<div class="input_label"><?= lang('fcl')?></div>
				
				
				<? $sel = isset($fcl['fcl']) ? $fcl['fcl'] : null ?>
				<?= 			form_dropdown('fcl', 
					[0=>lang('no'),1=>lang('yes')],$sel,['class'=>'form-control']);
				?>
			</div>
			
			
		</div>
		
		
		
		<div class="row_mb buttons_bar">
			<button type="submit"    
					class="btn bg-blue_min" id="publish"><?= lang('save')?></button>
		</div>
	</div>
	
	<datalist id="langs">
		<? foreach($language_list as $lang):?>
		<option value="<?= $lang ?>"><?= $lang ?></option>
		<? endforeach;?>
	</datalist>
	
</form>
</div>
</div>
