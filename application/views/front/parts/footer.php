</article>
<!--Support button -->
<!--<div class="wsk-float">
	<a href="#help" class="pulse-button">
		<span class="needhelpbutton">Need help?</span>
	</a>
</div>-->
<div class="footer">
	<div class="col-md-12">
		<div class="row">
			<div class="col-sm">


				<a  target="_blank" href="<?=  $privacy 	?>">
				<?= lang('privacystatements')?>   
				  <i class="far fa-file-pdf"></i></a>
			</div>
			<div class="col-sm">
<!--				<a href="#help" ><?= lang('need_help') ?></a>
-->			</div>
			<div class="col-sm">
				<a target="_blank" href="http://www.aslairlines.fr/plan-du-site/" ><?= lang('sitemap') ?></a>
			</div>
			<div class="col-sm">
				<a href="http://www.aslairlines.fr" target="_blank" title="Asl">
					<img width="100px;" src="http://www.aslairlines.fr/wp-content/themes/eap/images/logo-footer.jpg" alt="ASL Logotype">
				</a>

			</div>
		</div>
	</div>
</div>
<div class="modal fade bs-example-modal-lg" id="footerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="footerModalText">
				<?= isset($modal)? $modal : null ;?>
			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
</script>

<!--
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
<script>
	$('.your-class').slick(
		{
			slidesToShow: 1,
			adaptiveHeight: true,
			slidesToScroll: 1,
			autoplay: true,
			dots: true,
			arrows: false,
			mobileFirst: true,
			autoplaySpeed: 2000,
		});
</script>-->
<? $this->view('popup/modal.php') ;?>
<script src="<?= base_url().'static/js/site.js'?>"></script>

  
<?
if ( null ==! $this->session->flashdata('message')) :?>
<div class="alert alert-danger" style=" position: fixed;z-index: 10000;width: 100%;top:0;left:0">
   
    <div style="text-align: center;">
        <?php echo $this->session->flashdata('message');?>
    </div>

</div>
<? endif ;?>
</body>
</html>