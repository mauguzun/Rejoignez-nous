
<? 
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]);
$ref = $name ;
?> 



	
<form method="post" action="<?= $url ?>" v-on:submit.prevent="send">
	<div class="card-body">
		
	
		
		
		<? foreach($data as $key=> $onedata):?>
	
		<div class="row row_mb" ref="<?=$ref.$key?>" >
		    
			<div class="col-md-6">
				<div class="input_label">
					<span>*</span>	<?= lang('aircaft_type')?>
				</div>
				<input
				type="text" 
				name="aircaft_type[]" 
				@change="autre"
				value="<?= isset($onedata['aircaft_type[]']) ?$onedata['aircaft_type[]'] : null ?>"
				class="form-control" 
				required="required" list="aircraft_type">
			</div>
			
			<div class="col-md-6">
				<div class="input_label">
					<span>*</span>	<?= lang('company')?>
				</div>
				<input
				type="text" 
				name="company[]" 
				value="<?= isset($onedata['company[]']) ?$onedata['company[]'] : null ?>"
				class="form-control" 
				required="required" >
			</div>

			<? foreach(['validity_date[]','date_of_issue[]'] as $row ):?>
			<div  class="col-md-3">
				<div class="input_label">
					<span>*</span>	<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				value="<?= isset($onedata[$row]) ?$onedata[$row] : null ?>"
				required=""
				name="<?=$row?>" 
				placeholder="<?= lang(str_replace('[]','',$row))?>"    
				data-calendar="true"
					@mouseover="setupCalendar()"
				class="form-control"/>
			
			</div>
			<? endforeach; ?>
			
			
			<div class="col-md-2">
				<div class="input_label">
					<span>*</span>	<?= lang('approval_number')?>
				</div>
				<input
				type="number" 
				min="0" 
				name="approval_number[]" 
				value="<?= isset($onedata['approval_number[]']) ?$onedata['approval_number[]'] : null ?>"
				class="form-control" 
				required="required" >
			</div>
			
				
			<div class="col-md-1 illarion">
				<? if($key == 0 ):?>
				<i  @click="addRow('<?= $ref ?>')" class="fas fa-plus-square"></i>
				<? else : ?>
				<i @click="removeTemplate('<?=$ref.$key?>')"  class="fas fa-minus-square"></i>
				<? endif;?>

			</div>
		</div>
		<? endforeach ?>

		<!---->
		
		<div class="row row_mb" v-for="(n)  in <?= $ref?>"  :key="n.id">
			
			<div class="col-md-6">
				<div class="input_label">
				<span>*</span>		<?= lang('aircaft_type')?>
				</div>
				<input
				type="text" 
				@change="autre"
				name="aircaft_type[]" 
				class="form-control" 
				required="required" list="aircraft_type">
			</div>
			
			<div class="col-md-6">
				<div class="input_label">
				<span>*</span>		<?= lang('company')?>
				</div>
				<input
				type="text" 
				name="company[]" 
				class="form-control" 
				required="required" >
			</div>

			<? foreach(['validity_date[]','date_of_issue[]'] as $row ):?>
			<div  class="col-md-3">
				<div class="input_label">
				<span>*</span>		<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				@mouseover="setupCalendar()"
				required=""
				name="<?=$row?>" 
				placeholder="<?= lang(str_replace('[]','',$row))?>"    
				data-calendar="true"
				
				class="form-control"/>
			
			</div>
			<? endforeach; ?>
			
			
			<div class="col-md-2">
				<div class="input_label">
				<span>*</span>		<?= lang('approval_number')?>
				</div>
				<input
				type="number" 
				min="0" 
				name="approval_number[]" 
				class="form-control" 
				required="required" >
			</div>
			
				
		

			<div class="col-md-1 illarion">
				
				<i @click="removeRow(n,'<?= $name?>')"  class="fas fa-minus-square"></i>

			</div>
		</div>
		<!---->
		
		<div class="row_mb buttons_bar">
			<button type="submit"   class="btn bg-blue_min" id=""><?= lang('save')?></button>
		</div>
	</div>
	
	<datalist id="aircraft_type">
		<? foreach($aircraft_type as $air):?>
		<option value="<?= $air ?>"><?= $air?></option>
		<? endforeach ;?>
	</datalist>
</form>
</div>
</div>
