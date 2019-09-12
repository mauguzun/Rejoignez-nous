<div class="footer-wrap clearfix" style="height: 207px;">
	<?= $asl_footer?>
</div>
	
	

<h1><?=$this->session->flashdata('info') ?></h1>
	
<script src="<?= base_url().'static/js/site.js'?>"></script>
<?
if( null ==! $this->session->flashdata('message')  ) :?>
<div class="alert 
<?= null ==! $this->session->flashdata('info')? 'alert-info'  : 'alert-danger'?>" 

 style="position: fixed;z-index: 10000;width: 100%;top:0;left:0">

	<div style="text-align: center;">
		<?php echo $this->session->flashdata('message');?>
	</div>

</div>
<? endif ;?>
