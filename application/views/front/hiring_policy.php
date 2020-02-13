<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.min.css">
</link>



<div id="content" role="main">

	<div class="breadcrumbs eap-breadcrumbs">
		<a href="<?= base_url()?>" >
			<span>
				<?= lang('Careers') ?>
			</span>
		</a>&gt;
		<span class="current-page">
			<?= lang('our_recruitment_policy')?>
			<span>
			</span>
		</span>
	</div>
	<h1 class="post-title">
		<?= lang('our_recruitment_policy')?>
	</h1><br>

	<br>
	<ul class="accord">
		<li class="main-accord">

			<!--			<h5>	<?= lang('our_recruitment_policy')?></h5>-->

			<div class="row">

				<div class="col-md-4">
					<div class="my_breadcrumb" id="img1"    style="cursor:pointer;   padding-bottom: 21px;  height:200px; background:url(<?=  $img.$query['general_picture']?>) ;
					background-size: cover; background-color:#F8F8F8;">

						<br>
						<br>
						<br>
						<div>
						</div>

					</div>
				</div>

				<div class="col-md-4">
					<div class="my_breadcrumb" id="img2"   style="cursor:pointer; padding-bottom: 21px;  height:200px; 
					 background:url(<?=  $img.$query['pnt_picture']?>) ;
					background-size: cover; background-color:#F8F8F8;">
						<br>
						<br>
						<br>
						<div>
						</div>

					</div>
				</div>


				<div class="col-md-4">
					<div class="my_breadcrumb" id="img3"     style="cursor:pointer; padding-bottom: 21px;  height:200px;  
					background:url(<?=  $img.$query['mecahic_picture']?>) ;
					background-size: cover; background-color:#F8F8F8;">
						<br>
						<br>
						<br>
						<div>
						</div>

					</div>
				</div>


			</div>
		</li>


		<li>
			<input type="checkbox" checked>
			<i>
			</i>
			<h5>
				<?= lang('integration')?>
			</h5>
			<div>
				<?= ($query['integration']) ?>
			</div>
		</li>
		<!--<li>
			<input type="checkbox" checked>
			<i>
			</i>
			<h5>
				<?= lang('course')?>
			</h5>
			<div>
				<?= ($query['course']) ?>
			</div>
		</li>-->
		<li>
			<input type="checkbox" checked>
			<i>
			</i>
			<h5>
				<?= lang('diversity')?>
			</h5>
			<div>
				<?= ($query['diversity']) ?>
			</div>
		</li>
		<li>
			<input type="checkbox" checked>
			<i>
			</i>
			<h5>
				<?= lang('recruiting')?>
			</h5>
			<div>
				<?= ($query['recruiting']) ?>
			</div>
		</li>
	</ul>


</div><!-- #content -->
<div id="sidebar-right">
</div>
</div><!-- #primary -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js">

</script>
<script>

	$('#img1').magnificPopup(
		{
			items:
			{
				src: "<?=  $img.$query['general_picture']?>"
			},
			type: 'image' // this is default type
		});
	$('#img2').magnificPopup(
		{
			items:
			{
				src: "<?=  $img.$query['pnt_picture']?>"
			},
			type: 'image' // this is default type
		});
	$('#img3').magnificPopup(
		{
			items:
			{
				src: "<?=  $img.$query['mecahic_picture']?>"
			},
			type: 'image' // this is default type
		});

</script>