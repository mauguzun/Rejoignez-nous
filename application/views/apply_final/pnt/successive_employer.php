
<? 
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]);
$ref = $name ;
?> 



	
<form method="post" action="<?= $url ?>" v-on:submit.prevent="send">
	<div class="card-body">
		
	
		
		
		<? foreach($data as $key=> $onedata):?>
	
		<div class="row row_mb " ref="<?=$ref.$key?>" >
		  
			<div class="col-md-3">
				<div class="input_label">
					<?= lang('function')?>
				</div>
				<input
				type="text" 
				name="function[]" 
				readonly="readonly"
				value="<?= isset($onedata['function[]']) ?$onedata['function[]'] : null ?>"
				class="form-control" 
				required="required">
			</div>
			
			<div class="col-md-3">
				<div class="input_label">
					<?= lang('employer')?>
				</div>
				<input
				type="text" 
				
				readonly="readonly"
				name="employer[]" 
				value="<?= isset($onedata['employer[]']) ?$onedata['employer[]'] : null ?>"
				class="form-control" 
				required="required" >
			</div>

			<? foreach(['start[]','end[]'] as $row ):?>
			<div  class="col-md-2">
				<div class="input_label">
					<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				value="<?= isset($onedata[$row]) ?$onedata[$row] : null ?>"
				required=""
				name="<?=$row?>" 
				placeholder="<?= lang(str_replace('[]','',$row))?>"    
				data-calendar="true"
				
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
			
		
		<? if(!empty($onedata['email[]'])) :?>
			
		<div class="row row_mb " >
				 
			<!---->
			<? foreach(['name[]','email[]','phone[]','phone_2[]','city[]','zip[]','address[]'] as $name):?>
			<div class="col-md-6">
				<div class="input_label"><span>*</span>
				    
					<?= lang(str_replace('[]','',$name))?>
					
				</div>
				<input 
				type="<?= $name == "email[]" ? 'email': 'text'?>"
				
				name="<?= $name ?>" 
				value="<?= isset($onedata[$name]) ?$onedata[$name] : null ?>" 
				class="form-control"
				<?= $name != "phone_2[]" ? 'required="required"': null ?>
				/>
				
			</div>
			<? endforeach ?>
			
			<div class="col-md-6">
				<div class="input_label"><span>*</span>
					<?= lang('country')?>			
				</div>
				
				<?= form_dropdown('country_id[]', 
					$countries,$onedata['country_id[]'],['class'=>'form-control']);
				?>
				
			</div>
			
			<div class="col-md-12">
				<div class="input_label"><span>*</span>
					<?= lang('why_left')?>			
				</div>
				
				<textarea name="why_left[]"  required="required" class="form-control"><?= isset($onedata['why_left[]']) ?$onedata['why_left[]'] : null ?></textarea>
				
			</div>
			<!---->
		
		</div>
		<!---->
		<? endif;?>
			
	
		<? endforeach ?>

	

		<div class="row_mb buttons_bar">
			<button type="submit"   class="btn bg-blue_min" id=""><?= lang('save')?></button>
		</div>
	</div>
	
	
</form>
</div>
</div>
