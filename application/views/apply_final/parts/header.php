<div class="breadcrumbs eap-breadcrumbs">
	<a href="<?= base_url()?>" >
		<span>
			<?= lang('Careers') ?>
		</span>
	</a>  &gt;
	<a href="<?= base_url().'offers' ?>" >
		<span >
			<?= lang('our_offers') ?>
		</span>
	</a>  &gt; 

	<a href="#" >
		<span class="current-page" style="color: #484848 !important;">
			<?= $offer['title']?>
		</span>
	</a>



</div>

<h1 class="post-title"><?= $offer['title']?></h1>

<!---->
	

<div v-if="!filled" class="alert alert-danger" role="alert">
	<i class="fas fa-info-circle">
	</i>
	<?= lang('some_important_infomation')?>

</div>



<div v-if="filled" class="alert alert-success"  >
	<i class="fas fa-info-circle">
	</i> <?= lang('you_are_applied')?>
</div>




<!--
<div class="alert alert-primary"  style="background-color:#fef2cd" >
<i class="fas fa-info-circle">
</i> <?= lang('press_save_to_progres')?>
</div>-->


<!--{{application_id}}
-->	


<div v-if="message != null"  

  v-bind:class="{ 'alert-danger': error , 'alert-success' : !error }"
  style="position: fixed;z-index: 10000;width: 100%;top:0;left:0">
	<div style="text-align: center;">
		<br>
		<span 
		
		v-html="message"></span>

		<br><br>

	</div>
</div>

<!---->
<div class="print_block" >
	<a type="button"
	v-show="filled"
	ref="printButton"
	 href="<?= base_url()."/apply/new/".$offer_type."/printer/" ?>"
	 target="_blank"
	  
	 class="my btn btn-info"><i class="fa fa-print">
		</i> <?= lang('print')?></a>
		
	<a type="button"
	
	 ref="delButton"
	 href="<?= base_url()."/apply/new/".$offer_type."/delete/" ?>"

	 onclick="return confirm('Are you sure?');"
	 class="my btn btn-danger"><i class="far fa-trash-alt">
		</i> <?= lang('delete')?></a>
</div>	


<div class="app-loader" v-show="loader === true" >
	<? $this->load->view('apply_final/parts/loader.php')?>
</div>

