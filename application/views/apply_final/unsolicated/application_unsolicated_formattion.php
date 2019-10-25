
<? 
$name = 'application_unsolicated_formattion';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]);
$ref = $name ;
?> 



	
<form method="post" action="<?= $url ?>" v-on:submit.prevent="send">
	<div class="card-body">
		

		
	
		<? foreach($data as $key=> $onedata):?>
	
		<div class="row row_mb" ref="<?=$ref.$key?>" >
		
			<? foreach(['school_type','school_name','qualification'] as $row ) :?>
			<div class="col-md-4">
				<div class="input_label">
					<span>*</span>	<?= lang($row)?>
				</div>
				<input
				type="text" 
				name="<?=$row?>[]" 
				value="<?= isset($onedata[$row]) ?$onedata[$row] : null ?>"
				class="form-control" 
				required="required" list="aircraft_type">
			</div>
			<? endforeach ; ?> 
			
			
			
			
			

			<? foreach(['start','end'] as $row ):?>
			<div  class="col-md-6">
				<div class="input_label">
				
					<? if($row == 'start') :?>
				
					<span>*</span>
					<? endif ?>
					<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				value="<?= isset($onedata[$row]) && $onedata[$row] != '0000-00-00' ? date_to_input($onedata[$row]) : null ?>"
				<? if($row == 'start') :?>
				required=""
				<? endif ?>
				
				name="<?=$row?>[]" 
				placeholder="<?= lang(str_replace('[]','',$row))?>"    
				data-calendar="true"
				@mouseover="setupCalendar()"
				
				class="form-control"/>
				
			</div>
			<? endforeach; ?>
			
			
			<div class="col-md-11">
				<div class="input_label">
					<span>*</span>	<?= lang('location')?>
				</div>
				<input
				name="location[]"
				class="form-control"
				value="<?= isset($onedata['location']) ? $onedata['location'] : null ?>"
				required="" />
			
				
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
	
	<div class="row row_mb" v-for="(n)  in <?= $ref?>"  :key="n.id">
			
	
		
			<? foreach(['school_type','school_name','qualification'] as $row ) :?>
			<div class="col-md-4">
				<div class="input_label">
					<span>*</span>	<?= lang($row)?>
				</div>
				<input
				type="text" 
				name="<?=$row?>[]" 
				value=""
				class="form-control" 
				required="required" list="aircraft_type">
			</div>
			<? endforeach ; ?> 
			
			
			
			
			

			<? foreach(['start','end'] as $row ):?>
			<div  class="col-md-6">
				<div class="input_label">
				
					<? if($row == 'start') :?>
				
					<span>*</span>
					<? endif ?>
					<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				value=""
				<? if($row == 'start') :?>
				required=""
				<? endif ?>
				
				name="<?=$row?>[]" 
				placeholder="<?= lang(str_replace('[]','',$row))?>"    
				data-calendar="true"
				@mouseover="setupCalendar()"
				
				class="form-control"/>
				
			</div>
			<? endforeach; ?>
			
			
			<div class="col-md-11">
				<div class="input_label">
					<span>*</span>	<?= lang('location')?>
				</div>
				<input
				name="location[]"
				class="form-control"
				value=""
				required="" />
			
				
			</div>
			
			
				
		
			<div class="col-md-1 illarion">
				
				<i @click="removeRow(n,'<?= $name?>')"  class="fas fa-minus-square"></i>

			</div>
		</div>
		
		<div class="row_mb buttons_bar">
			<button type="submit"   class="btn bg-blue_min" id=""><?= lang('save')?></button>
		</div>
	</div>
	
	
</form>
</div>
</div>
