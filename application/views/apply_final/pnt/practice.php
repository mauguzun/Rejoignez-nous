<? $name = 'practice';
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 


	
<form method="post" action="<?= $url ?>" v-on:submit.prevent="send">
	<div class="card-body">
		
	
		
		
		<? foreach($data as $key=> $onedata):?>
	
		<div class="row row_mb" ref="<?='practic'.$key?>" >
		

			<? foreach(['start[]','end[]'] as $row ):?>
			<div  class="col-md-3">
				<div class="input_label">
					<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				value="<?= isset($onedata[$row]) ?$onedata[$row] : null ?>"
				data-calendar="true" 
				required=""
				@mouseover="setupCalendar()"
				name="<?=$row?>"     
				type="text"  
				class="form-control"/>
			
			</div>
			<? endforeach; ?>
			
			
			<? foreach(['school_name[]','qualification_obtained[]'] as $row ):?>
			<div  class="col-md-2">
				<div class="input_label">
					<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				value="<?= isset($onedata[$row]) ?$onedata[$row] : null ?>"
				required=""
				name="<?=$row?>"     
				type="text"  
				class="form-control"/>
			
			</div>
			<? endforeach; ?>
			
				
			<div class="col-md-1 illarion">
				<? if($key == 0 ):?>
				<i  @click="addRow('practic')" class="fas fa-plus-square"></i>
				<? else : ?>
				<i @click="removeTemplate('<?='practic'.$key?>')"  class="fas fa-minus-square"></i>
				<? endif;?>

			</div>
		</div>
		<? endforeach ?>

		<!---->
		
		<div class="row row_mb" v-for="(n)  in pracitRows"  :key="n.id">
			
			<? foreach(['start[]','end[]'] as $row ):?>
			<div  class="col-md-3">
				<div class="input_label">
					<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				@mouseover="setupCalendar()"
				data-calendar="true" 
				required=""
				name="<?=$row?>"     
				type="text"  
				class="form-control"/>
			
			</div>
			<? endforeach; ?>
			
			
			<? foreach(['school_name[]','qualification_obtained[]'] as $row ):?>
			<div  class="col-md-2">
				<div class="input_label">
					<?= lang(str_replace('[]','',$row))?>
				</div>
				<input
				required=""
				name="<?=$row?>"     
				type="text"  
				class="form-control"/>
			
			</div>
			<? endforeach; ?>
			
				
			<div class="col-md-1 illarion">
				<i @click="removeRow(n,'practic')"  class="fas fa-minus-square"></i>

			</div>
	
		</div>
		<!---->
		
		<div class="row_mb buttons_bar">
			<button type="submit"   class="btn bg-blue_min" id=""><?= lang('save')?></button>
		</div>
	</div>
</form>
</div>
</div>
