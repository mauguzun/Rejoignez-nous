<?
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 



	
<form method="post" action="<?= $url ?>" v-on:submit.prevent="send">
	<div class="card-body">
		
	
		<div class="row row_mb">
			<div class="col-md-6">
						
				<div class="input_label"><span>*</span>
					<?= lang('aviability')?></div>
				<select 
				 ref="aviability"
				 id="<?= $id ?>"
				 required=""
				 class="form-control" v-model="models.aviability" name="fake_aviability">
				 
					<? foreach($list as $k=>$v):?>
					<option value="<?=$k?>"><?=$v?></option>
					<? endforeach ;?>
				</select>
			</div>
			
			
			<div class="col-md-6">
				<div class="input_label"><?= lang('car')?></div>
				<?= 	
				form_dropdown('car', [0=>lang('not_have_car'),1=>lang('have_car')],
					$misc['car'] != null ? $misc['car'] : null ,
					['class'=>'form-control selectpicker']);
				?>
			</div>
		</div>
			
		
		<div class="row row_mb" v-show="models.aviability === '0'">	

			<div class="col-md-6" >
						
				<div class="input_label">
					<input 
					 
					:required="models.aviability === '0'"
					data-calendar="true" class="form-control" name="aviability" 
					/>
					 
					 
				</div>
			</div>
		</div>
		
		<? foreach(['motivation_asl','involved_in_incidents'] as $name):?>
		
		<div class="row row_mb">
			<div class="col-md-12" >
			
				<div class="input_label">
					<span>*</span>
					<? if($name=='motivation_asl'):?>
				
					<?= lang($name)?>
					<? else:?>
					<?= lang('Involved in incidents')?>
					<? endif; ?>
				
				</div>
			
				
				<textarea name="<?= $name?>"
				 class="form-control" type="textarea"
			 id="motivation_asl" 
			 required
			><?= isset($completary[$name]) ? $completary[$name] : null ?></textarea>
			</div>
		</div>
		<? endforeach ;?>
	
	  
		<div class="row_mb buttons_bar">
			<button type="submit"   class="btn bg-blue_min" id=""><?= lang('save')?></button>
		</div>
	</div>
</form>
</div>
</div>
