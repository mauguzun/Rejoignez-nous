<? 
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]);
$ref = $name ;
?> 


<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">


	<div class="card-body">
		
		
		<? foreach($data  as $key=>$oneRow) :?>
		
		
		<div class="row row_mb" 
		ref="<?=$ref.$key?>" >
		
			<div class="col-md-4">
				<div class="input_label">
					<span>*</span><?= lang('function')?>
				</div>
				<input
				type="text" 
				name="function[]" 
				value="<?= isset($oneRow['function[]'])  ? $oneRow['function[]'] : null ?>"
				class="form-control" 
				required="required" 
				/>
			</div>
			
			<!--<div class="col-md-3">
				<div class="input_label">
					<?= lang('employer')?>
				</div>
				<input
				type="text" 
				@keyUp="more"
				name="employer[]" 
				value="<?= isset($oneRow['employer[]'])  ? $oneRow['employer[]'] : null ?>"
				class="form-control" 
				id="<?='key'.$key?>"
				>
			</div>-->
			
			<?foreach(['start[]','end[]'] as $row) :?>
			<div class="col-md-3">
				<div class="input_label">	<span>*</span>
					<?= lang(str_replace('[]','',$row))?>
				</div>
				<input 
				value="<?= isset($oneRow[$row])  ? $oneRow[$row] : null ?>"
				required="required" 
				name="<?=$row ?>"
				@mouseover="setupCalendar()"
				placeholder="<?= lang(str_replace('[]','',$row))?>" 
				data-calendar="true" class="form-control">
							 	
			</div> 		
			<? endforeach ;?>
			
			<div class="col-md-1 illarion">
				<? if($key == 0 ):?>
				<i  @click="addRow('<?= $ref ?>')" class="fas fa-plus-square"></i>
				<? else : ?>
				<i @click="removeTemplate('<?=$ref.$key?>')"  class="fas fa-minus-square"></i>
				<? endif;?>

			</div>
		</div>

		<div class="row row_mb"
		data-id="<?='key'.$key?>"
		<?= empty($oneRow['employer[]']) ? 'style="display:none" ' : null ;
			$not_required = ['address[]','postal[]','city[]','phone_2[]']?>
		  >
			<? foreach(['name[]','email[]','phone[]','phone_2[]' ,'address[]','postal[]','city[]'] as $input):?> 
			<div class="col-md-6">
				<div class="input_label">
					<? if (!in_array($input,$not_required)):?>
					<span>*</span>
					<? endif ;?>
					<?= lang(str_replace('[]','',$input))?>
				</div> 
				<input type="text" 
				name="<?=$input?>"
				value="<?= isset($oneRow[$input])  ? $oneRow[$input] : null ?>"
				class="form-control"
				<? if (in_array($input,$not_required)):?>
				data-not="remove"
				<? endif ;?>
				>
			</div>
			<? endforeach ;?>
		  
		   
			<div class="col-md-6">
				<div class="input_label">
					<span>*</span>
					<?= lang('country')?>
				</div> 
				<?= 
				
				form_dropdown('country_id[]',$countries ,
					isset($oneRow['country_id[]'])  ? $oneRow['country_id[]'] : null,['class'=>'form-control']) ?>
			</div>
			
			
			<div class="col-md-12">
				<div class="input_label"><span>*</span>
					<?= lang('why_left')?>		
				</div> 
				<textarea name="why_left[]" 
				class="form-control"><?= $oneRow['why_left[]']?></textarea>
			
			</div>
		  
				


		</div>
		<? endforeach ;?>
		
		
		<!---->
		
		<template class="row row_mb" v-for="(n)  in <?= $ref ?>"  >
			

			<div class="row row_mb" 
		     >
		
				<div class="col-md-3">
					<div class="input_label">
						<span>*</span><?= lang('function')?>
					</div>
					<input
					type="text" 
					name="function[]" 
					class="form-control" 
					required="required" 
					/>
				</div>
			
				<div class="col-md-3">
					<div class="input_label">
						<?= lang('employer')?>
					</div>
					<input
					type="text" 
					name="employer[]" 
					class="form-control" 
					v-model="n.flag"
					>
				</div>
			
				<?foreach(['start[]','end[]'] as $row) :?>
				<div class="col-md-2">
					<div class="input_label">	<span>*</span>
						<?= lang(str_replace('[]','',$row))?>
					</div>
					<input 
					required="required" 
					name="<?= $row ?>"
					@mouseover="setupCalendar()"
					placeholder="<?= lang(str_replace('[]','',$row))?>" 
					data-calendar="true" class="form-control">
							 	
				</div> 		
				<? endforeach ;?>
			
				<div class="col-md-1 illarion">
					<i @click="removeRow(n,'<?= $ref ?>')"  class="fas fa-minus-square"></i>

				</div>
	
			</div>

			<div class="row row_mb" v-if="n.flag" >
				<? foreach(['name[]','email[]','phone[]','phone_2[]' ,'address[]','zip[]','city[]'] as $input):?> 
				<div class="col-md-6">
					<div class="input_label">
						<span>*</span>
						<?= lang(str_replace('[]','',$input))?>
					</div> 
					<input type="text" 
					name="<?=$input?>"

					class="form-control">
				</div>
				<? endforeach ;?>
		  
		   
				<div class="col-md-6">
					<div class="input_label">
						<span>*</span>
						<?= lang('country')?>
					</div> 
					<?= 
				
					form_dropdown('country_id[]',$countries ,null ,['class'=>'form-control']) ?>
				</div>
			
			
				<div class="col-md-12">
					<div class="input_label"><span>*</span>
						<?= lang('why_left')?>		
					</div> 
					<textarea name="why_left[]" 
				class="form-control"></textarea>
			
				</div>
		  
				


			</div>
			
		</template>
		
		
		<!---->
		

		<div class="row_mb buttons_bar">
			<button type="submit"   class="btn bg-blue_min" id=""><?= lang('save')?></button>
		</div>
	</div>
			
	
	</div>
	
	
</form>
</div>
</div>
