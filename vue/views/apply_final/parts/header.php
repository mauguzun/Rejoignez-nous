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
		<span class="current-page">
			<?= $offer['title']?>
		</span>
	</a>



</div>

<h1 class="post-title"><?= $offer['title']?></h1>

<!---->
	
<?
if(isset($_GET['q'])):?>
<div class="alert alert-danger" role="alert">
	<i class="fas fa-info-circle">
	</i>
	<?= lang('some_important_infomation')?>

</div>
<? endif;?>


<?
if(isset($message)) :?>
<div class="alert alert-danger" role="alert">
	<i class="fas fa-info-circle">
	</i>
	<?php echo $message;?>
</div>
<?
else :?>


<? endif ; ?>


<?
if(isset($app) && $app && $app['filled'] == 1 ) :?>

<div class="alert alert-success"  >
	<i class="fas fa-info-circle">
	</i> <?= lang('you_are_applied')?>
</div>




<?
else :?>


<div class="alert alert-primary"  style="background-color:#fef2cd" >
	<i class="fas fa-info-circle">
	</i> <?= lang('press_save_to_progres')?>
</div>


<? endif ; ?>



<div v-if="message != null"  

  v-bind:class="{ 'alert-danger': error , 'alert-success' : !error }"
  style="position: fixed;z-index: 10000;width: 100%;top:0;left:0">
	<div style="text-align: center;">
		<br>
		<span v-html="message"></span>

		<br>

	</div>
</div>


<!---->
<div class="print_block">
	<button type="button" class="print_disabled"><i class="fa fa-print">
		</i> <?= lang('print')?></button></div>	


<div ref="loader">
	asd
</div>

	
