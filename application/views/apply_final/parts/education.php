	<? $name = 'education';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 


<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">

	<div class="card-body">

		<div class="row row_mb">
			<div class="col-md-12">
				<div class="input_label"><?= lang('education_level_id')?></div>
				<select name="education_level_id"
							 class="form-control selectpicker"
							 v-model="models.education_level_id"
							 ref="education_level_id"
							 id="<?= $education?  $education['education_level_id'] : null ?>"
							 data-live-search="true">
					<? foreach($education_level as $id=>$text):?>
					<option <?= $education &&  $education['education_level_id'] == $id ? 'selected' : null ;?>  value="<?= $id?>"><?= $text?></option>
					<? endforeach ?>
				</select>
			</div>
					
		</div>
				
		<!--open if  -->
		<span v-if=" models.education_level_id != '1' ">
						
					
				
			<div class="row row_mb">
				<div class="col-md-6">
					<div class="input_label"><span>*</span><?= lang('create_offer_studies')?></div>
					<input name="studies" value="<?= $education ? $education['studies'] :  null ;?>" class="form-control"  required="require" />
				</div>
				<div class="col-md-6">
					<div class="input_label"><span>*</span><?= lang('create_offer_university')?></div>
					<input name="university" value="<?= $education ? $education['university'] :  null ;?>" class="form-control"  required="require" />
				</div>
			</div>
					
		</span>
		<!---->
				
	 
		<div class="row_mb buttons_bar">
			<button type="submit"    
					class="btn bg-blue_min" id="publish"><?= lang('save')?></button>
		</div>
	</div>
</form>
		
</div>
</div>