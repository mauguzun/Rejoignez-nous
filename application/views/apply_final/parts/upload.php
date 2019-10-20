
<? 
$this->load->view('apply_final/parts/card_header.php',['name'=>$name ]); ?> 



	
	
	
<div class="card-body">
	<!---->
	<div class="uploader" data-ref="<?=$name?>" ref="<?=$name?>">



		<div id="error">
			
		</div>
		
		<div   id="drag-and-drop-zone" class="uploader">
			<div  class="alert alert-primary upload"  style="padding:30px;" >
				<?= lang('Drop Files Here') ?>
			</div>



			<div class="alert alert-light browser " role="alert">
				<button type="button" class="btn btn-warning btn-block "><?= lang('Click to open the file Browser') ?></button>
				<input type="file" name="<?= $name ?>"
				multiple="multiple" title='Click to add Files'>

			</div>


		</div>
		<!-- /D&D Markup -->

		<div id="console"></div>

		<div id="loglist"></div>

		
		<div id="filelist" class="filelist" >
			<?
			if(isset($files)) :?>
			<?foreach($files as $oneimg) :?>
			
			<? if($oneimg['type'] == $name ):?>
			<?= img_from_db($oneimg) ?>
			<? endif;?>
			<? endforeach ;?>
			
			<? endif;?>
				
			<template v-for="n in files.<?=$name?>">
			
			
			
				<div  :id='"file_"+n.id' class='edit'  >
					<div class="title">{{n.name}}</div>
					<img  :src='n.result' />
					<span @click="deleteImg(n.id)"
						class='trash'><i class='fas fa-trash' ></i></span>
					<a download target='_blank'
					 :href='"<?=base_url()?>user/getfile?url=" + n.id '>
						<i  class='fas fa-download'></i></a></div>
			</template>
		
					
			
		</div>
	</div>

				
	<!---->
</div>
	
		
	
	
</div>
</div>
