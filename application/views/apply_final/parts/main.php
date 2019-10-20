
<? $name = 'main';
   $this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 



	
	
	
		<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">
			<div class="card-body">
				<div class="row row_mb">
					<div class="col-md-4">
						<div class="input_label"><span>*</span><?= lang('user_civility')?> </div>
						<select data-name="civility" class="form-control selectpicker" data-live-search="true">
							<?foreach($civility  as $key=>$value):?>
							<option <?= $app['civility'] == $key ? 'selected' : null ?>  value="<?= $key?>"><?= $value?></option>
							<?endforeach ;?>
						</select>
					</div>
					<div class="col-md-4">
						<div class="input_label"><span>*</span><?= lang('first_name')?></div>
						<input name="first_name" type="text" value="<?= $app['first_name']?>" class="form-control">
					</div>
					<div class="col-md-4">
						<div class="input_label"><span>*</span><?= lang('last_name')?></div>
						<input name="last_name" type="text" value="<?= $app['last_name']?>" class="form-control">
					</div>
				</div>
				<div class="row row_mb">
					<div class="col-md-4">
						<div class="input_label"><span>*</span><?= lang('country')?></div>
						<select name="country_id" class="form-control selectpicker" data-live-search="true">
							<?foreach($countries as $key=>$value):?>
							<option <?= $app['country_id'] == $key ? 'selected' : null ?>  value="<?= $key?>"><?= $value?></option>
							<?endforeach ;?>
						</select>
					</div>
			
					<div class="col-md-4">
						<div class="input_label"><span>*</span><?= lang('city')?></div>
						<input type="text" required="require" value="<?= $app['city']?>" name="city" class="form-control">
					</div>
				
					<div class="col-md-4">
						<div class="input_label"><span>*</span><?= lang('zip')?></div>
						<input type="text" value="<?= $app['zip']?>"  name="zip" class="form-control">
					</div>
				</div>
				<div class="row row_mb">
					<div class="col-md-4">
						<div class="input_label"><span>*</span><?= lang('address')?></div>
						<input type="text"  name="address" value="<?= $app['address']?>" class="form-control">
					</div>
					<div class="col-md-4">
						<div class="input_label"><span>*</span><?= lang('phone')?></div>
						<input type="text"  name="phone" value="<?= $app['phone']?>" class="form-control">
					</div>
					<div class="col-md-4">
						<div class="input_label"><?= lang('phone_2')?></div>
						<input type="text" name="phone_2" value="<?= $app['phone_2']?>" class="form-control">
					</div>
				</div>
				<div class="row row_mb">
					<div class="col-md-12">
						<label> 	<input name="change_acc" type="checkbox" /><?= lang('update_my_main_acc')?>

						</label>   
					</div></div>
				<div class="row_mb buttons_bar">
					<button type="submit"    
					class="btn bg-blue_min" id="publish"><?= lang('save')?></button>
					<!--	<button type="button" class="sc_button_disabled" id="cancel_button">Cancel</button>-->
				</div>
			</div>
	
		</form>
	
	
	</div>
</div>
