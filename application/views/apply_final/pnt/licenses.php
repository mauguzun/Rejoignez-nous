<? $name = 'licenses';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 



	
<form method="post" action="<?= $url ?>" id="licence" v-on:submit.prevent="send">
	<div class="card-body">
		
		<div  v-if="models.lic_error" class="alert alert-danger"><i class="fas fa-info-circle"></i> {{models.lic_error}}</div>

		<?
		foreach(['cpl','atpl','irme'] as $index ):?>


		<div  class="col-md-12" style="margin-top: 20px;">
			
			<label class="extra_label">
				<input 
				
				<? if(isset($query[$index.'_start'])) :?>
				:run="models['<?=$index?>'] = true "
				<? endif;?>
				
				
				v-model="models['<?=$index?>']" name="<?= $index ?>" type="checkbox"/>
				<?= lang($index).' ' .lang('section')  ?>
			</label>
				
				
			
		</div>
		
		<div  class=""  v-show="models['<?=$index?>']" >
			<div class="input_label">
				<?= lang('start')?>
			</div>
			<input data-calendar="true" 
			@mousedown="setupCalendar()"
			value="<?= isset($query["{$index}_start"]) ? $query["{$index}_start"] : ""  ?>"  
			:required="models['<?=$index?>']"  name="<?= $index?>_start"     type="text"  class="form-control"/>
			<div class="input_label">
				<?= lang('end')?>
			</div>
			<input data-calendar="true" 
			value="<?= isset($query["{$index}_end"]) ? $query["{$index}_end"] : ""  ?>"  

			
			:required="models['<?=$index?>']"  name="<?= $index?>_end"    type="text"  class="form-control"/>
		
		
			<?
		
			if($index == 'cpl') :?>
			<div style="margin-top: 20px ;margin-bottom:20px;">

				<strong>
					<?= lang('mcc_theoretical_atpl_subheader')?>
				</strong>
				<br />
				<br /><br />
				<?
		
		
				foreach(['mcc','theoretical_atpl'] as $ad):?>
		
				<label class="extra_label" for="<?= $ad?>">
					<input
					ref="<?=$ad?>"
				
				
					<? if(isset($query[$ad])) :?>
					:run="models['<?=$ad?>'] = true "
					<? endif;?>
					value="1"
					v-model="models['<?=$ad?>']"
					name="<?= $ad ?>" 
					type="checkbox"
					/>	
					<?= lang($ad) ?>
				</label><br />
		
		
		
				<? endforeach; ?>
			</div>
		
			<? endif ;?>

		</div>


		
		<? endforeach ?>

		
		
			
		
		
		<div class="row_mb buttons_bar">
	
	
			<button type="submit"    
				
				class="btn bg-blue_min" id=""><?= lang('save')?></button>
					


		</div>
	</div>
	
	
</form>
</div>
</div>
