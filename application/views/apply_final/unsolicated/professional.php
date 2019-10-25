
<? 
$name = 'professional';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]);
$ref = $name ;
?> 



	
<form method="post" action="<?= $url ?>" v-on:submit.prevent="send">
	<div class="card-body">
		

		
	
		<? foreach($data as $key=> $onedata):?>
	
		<div class="row row_mb" ref="<?=$ref.$key?>" >
		    
			<? foreach(['company'] as $row ) :?>
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
			
			<div class="col-md-4">
				<div class="input_label">
					<span>*</span>	<?= lang('country')?>
				</div>
				<?= form_dropdown('country_id[]',$countries,
					isset($onedata['country_id']) ? $onedata['country_id'] : NULL
				
					, ['class'=>'form-control']);?>
				
			</div>
			
			<? foreach(['industry','position_held'] as $row ) :?>
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
			<div  class="col-md-4">
				<div
				
				
				 class="input_label">
				
					<? if($row == 'start') :?>
				
					<span>*</span>
					<? endif ?>
					<?= lang($row)?>
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
				<? if($row == 'end') :?>
				
				<label class="current_label_down" >
					<?= lang('current') ?>
					<input type="checkbox" 
					value="1"
					<?= isset($onedata['current']) && 
					$onedata['current'] == 1 ? 'checked' : null ?>
					name="current[]" />
				
				</label>
					
				<? endif ?>
			</div>
			<? endforeach; ?>
			
			
			<div class="col-md-12">
				<div class="input_label">
					<span>*</span>	<?= lang('managerial')?>
				</div>
				<?= form_dropdown('managerial[]',$managerial,
					isset($onedata['managerial']) ? $onedata['managerial'] : NULL
					, ['class'=>'form-control']);?>
				
			</div>
			
			<div class="col-md-11">
				<div class="input_label">
					<span>*</span>	<?= lang('role')?>
				</div>
				<textarea class="form-control" name="role[]"><?= isset($onedata['role']) ?$onedata['role'] : null ?></textarea>
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
			
			<? foreach(['company[]'] as $row ) :?>
			<div class="col-md-4">
				<div class="input_label">
					<span>*</span>	<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				type="text" 
				name="<?=$row?>" 
				class="form-control" 
				required="required" list="aircraft_type">
			</div>
			<? endforeach ; ?> 
			
			<div class="col-md-4">
				<div class="input_label">
					<span>*</span>	<?= lang('country')?>
				</div>
				<?= form_dropdown('country_id[]',$countries,null , ['class'=>'form-control']);?>
				
			</div>
			
			<? foreach(['industry[]','position_held[]'] as $row ) :?>
			<div class="col-md-4">
				<div class="input_label">
					<span>*</span>	<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				type="text" 
				name="<?=$row?>" 
				class="form-control" 
				required="required" list="aircraft_type">
			
			</div>
			
			<? endforeach ; ?> 
			
			

			<? foreach(['start[]','end[]'] as $row ):?>
			<div  class="col-md-4">
				<div class="input_label">
					<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				<? if($row == 'start[]') :?>
				required=""
				<? endif ?>			
				name="<?=$row?>" 
				placeholder="<?= lang(str_replace('[]','',$row))?>"    
				data-calendar="true"
				@mouseover="setupCalendar()"
				
				class="form-control"/>
				<? if($row == 'end[]') :?>
				
				<label class="current_label_down" >
					<?= lang('current') ?>
					<input type="checkbox" name="current[]" />
				
				</label>
					
				<? endif ?>
			</div>
			<? endforeach; ?>
			
			
			<div class="col-md-12">
				<div class="input_label">
					<span>*</span>	<?= lang('managerial')?>
				</div>
				<?= form_dropdown('managerial[]',$managerial,null , ['class'=>'form-control']);?>
				
			</div>
			
			<div class="col-md-11">
				<div class="input_label">
					<span>*</span>	<?= lang('role')?>
				</div>
				<textarea class="form-control" name="role[]"></textarea>
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
