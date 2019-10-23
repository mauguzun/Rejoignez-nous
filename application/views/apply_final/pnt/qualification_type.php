
<? $name = 'qualification_type';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]);

$ref = 'quality';
?> 



	
<form method="post" action="<?= $url ?>" v-on:submit.prevent="send">
	<div class="card-body">
		
	
		
		
		<? foreach($data as $key=> $onedata):?>
	
		<div class="row row_mb" ref="<?=$ref.$key?>" >
		    
			<div class="col-md-2">
				<div class="input_label">
					<?= lang('aircaft_type')?>
				</div>
				<input
				type="text" 
				name="aircaft_type[]" 
				value="<?= isset($onedata['aircaft_type[]']) ?$onedata['aircaft_type[]'] : null ?>"
				class="form-control" 
				required="required" list="aircraft_type">
			</div>

			<? foreach(['last_online_check[]','last_simulator_control[]','last_flight[]'] as $row ):?>
			<div  class="col-md-3">
				<div class="input_label">
					<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				value="<?= isset($onedata[$row]) ?$onedata[$row] : null ?>"
				data-calendar="true" 
				required=""
				name="<?=$row?>"     
				type="text"  
				class="form-control"/>
			
			</div>
			<? endforeach; ?>
			
			
			
			
				
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
		
		<div class="row row_mb" v-for="(n)  in qualityRows"  :key="n.id">
			
			<div class="col-md-2">
				<div class="input_label">
					<?= lang('aircaft_type')?>
				</div>
				<input
				type="text" 
				name="aircaft_type[]" 

				class="form-control" 
				required="required" list="aircraft_type">
			</div>
			
			<? foreach(['last_online_check[]','last_simulator_control[]','last_flight[]'] as $row ):?>
			<div  class="col-md-3">
				<div class="input_label">
					<?= lang(str_replace('[]','',$row))?>
				</div>
				<input

				data-calendar="true" 
				@mouseover="setupCalendar()"
				required=""
				name="<?=$row?>"     
				type="text"  
				class="form-control"/>
			
			</div>
			<? endforeach; ?>
				
			<div class="col-md-1 illarion">
				<i @click="removeRow(n,'<?= $ref ?>')"  class="fas fa-minus-square"></i>

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
