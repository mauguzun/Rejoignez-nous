


<div class="custom_footer-wrap clearfix">
	<footer id="colophon" role="contentinfo"><div class="bloc-outils-footer"></div>
		<div class="col-three clearfix">
			<div class="col-center">
				<a target="_blank" class="logo-asl-footer" href="http://www.aslaviationgroup.com/">
					<img src="http://www.aslairlines.fr/wp-content/themes/eap/images/logo-footer.jpg" alt="ASL Logotype">
				</a>
			</div>
			<div class="col-right">
				<a target="_new" href="" class="newsletter-link">Subscribe to our newsletter</a>
				<h3>Follow-us on :</h3>

				<ul class="links-social">
					<li><a href="https://www.facebook.com/ASL-Airlines-France-549515051885360/" target="_blank" class="sprite-facebook">Follow us on Facebook</a></li>
					<li><a href="https://twitter.com/ASLAirlinesFr" target="_blank" class="sprite-twitter">Follow us on Twitter</a></li>
					<li><a href="http://www.youtube.com/user/EUROPEAIRPOSTFR" target="_blank" class="sprite-youtube">Follow us on Youtube</a></li>
					<li><a href="https://www.instagram.com/aslairlinesfrance/" target="_blank" class="sprite-instagram">Follow us on Instagram</a></li>
				</ul>
			</div>
		</div>


		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
		</script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
		</script>


		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>

		<?
		if( null ==! $this->session->flashdata('message')  ) :?>
		<div class="alert alert-danger" style="position: fixed;z-index: 10000;width: 100%;top:0;left:0">

			<div style="text-align: center;">
				<?php echo $this->session->flashdata('message');?>
			</div>

		</div>
		<? endif ;?>


		<script src="<?= base_url().'static/js/site.js'?>"></script>
		<div class="site-info">
			<span>© <?= time("Y")?> ASL Airlines</span>
			<span class="separateur-footer">-</span>
			<a href="<?=  $privacy 	?>"><?= lang('privacystatements')?>   </a>				<span class="separateur-footer">-</span>
			<a href="http://www.aslairlines.fr/en/site-map/"><?= lang('sitemap') ?></a>				<span class="separateur-footer">-</span>
			<a target="_blank" href="vmware-view://horizon.europeairpost.fr/">Gaïa</a>
			<span class="separateur-footer">-</span>
			<a target="_blank" href="http://www.aslairlines.fr/wp-content/uploads/2013/04/190219-GAL-CONDITIONS-OF-CARRIAGE-2019.pdf">General conditions of carriage</a>
			<span class="separateur-footer">-</span>
			<a target="_blank" href="http://fo-emea.ttinteractive.com/EuropeAirpost/racine_site/agv_fiche_contact.asp?id_sessionlangue=2">Travel agency</a>

		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div>



