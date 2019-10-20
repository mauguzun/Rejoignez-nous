
<? $name = 'aviability';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 


<form method="post" action="<?= $url ?>"  v-on:submit.prevent="send">
	<div class="card-body">
		
		<div class="row row_mb">
			<div class="col-md-12">
						
				<div class="input_label"><span>*</span>
					<?= lang('aviability')?></div>
				<select 
				 ref="aviability"
				 id="<?= $id ?>"
				 class="form-control" v-model="models.aviability" name="fake_aviability">
				 
					<? foreach($list as $k=>$v):?>
					<option value="<?=$k?>"><?=$v?></option>
					<? endforeach ;?>
				</select>
			</div>
			
		</div>
		<div class="row row_mb" v-show="models.aviability === '0'">	

			<div class="col-md-12">
						
				<div class="input_label">
					<input 
					 
					:required="models.aviability === '0'"
					data-calendar="true" class="form-control" name="aviability" 
					/>
					 
					 
				</div>
			</div>
		</div>
	
		<div class="row_mb buttons_bar">
			<button type="submit"    
					class="btn bg-blue_min" id="publish"><?= lang('save')?></button>
		</div>
		
	</div>
</form>
</div>
</div>
