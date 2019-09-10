<div id="content" role="main">

	<div class="breadcrumbs eap-breadcrumbs"><a href="<?= base_url()?>" ><span><?= lang('Careers') ?></span> </a>  &gt; 
		<span class="current-page">	<?= lang('our_recruitment_policy')?><span></span></span></div>
	<h1 class="post-title">	<?= lang('our_recruitment_policy')?></h1><br>

	<br>
	<ul class="accord">
		<li>
			<input type="checkbox">
			<i class="fas fa-search"></i>
			<h5>	<?= lang('our_recruitment_policy')?></h5>

			<div class="row">

				<div class="col-md-4">
					<div class="my_breadcrumb"    style="padding-bottom: 21px;  height:200px; background:url(<?=  $img.$query['general_picture']?>) ;
					background-size: cover; background-color:#F8F8F8;">
						<center><h5 style="font-size:16px; color:#fff;">Step 1</h5>
							<br>
							<br>
							<br>
							<div></div>
						</center>
					</div>
				</div>

				<div class="col-md-4">
					<div class="my_breadcrumb"    style="padding-bottom: 21px;  height:200px;  background:url(<?=  $img.$query['pnt_picture']?>) ;
					background-size: cover; background-color:#F8F8F8;">
						<center><h5 style="font-size:16px; color:#fff;">Step 1</h5>
							<br>
							<br>
							<br>
							<div></div>
						</center>
					</div>
				</div>

				
				<div class="col-md-4">
					<div class="my_breadcrumb"    style="padding-bottom: 21px;  height:200px;  background:url(<?=  $img.$query['mecahic_picture']?>) ;
					background-size: cover; background-color:#F8F8F8;">
						<center><h5 style="font-size:16px; color:#fff;">Step 1</h5>
							<br>
							<br>
							<br>
							<div></div>
						</center>
					</div>
				</div>


			</div>
		</li>


		<li>
			<input type="checkbox" checked>
			<i></i>
			<h5><?= lang('integration')?></h5>
			<p>	<?= strip_tags($query['integration']) ?></p>
		</li>
		<li>
			<input type="checkbox" checked>
			<i></i>
			<h5><?= lang('course')?></h5>
			<p>	<?= strip_tags($query['course']) ?></p>
		</li>
		<li>
			<input type="checkbox" checked>
			<i></i>
			<h5><?= lang('diversity')?></h5>
			<p>	<?= strip_tags($query['diversity']) ?></p>
		</li>
		<li>
			<input type="checkbox" checked>
			<i></i>
			<h5><?= lang('recruiting')?></h5>
			<p>	<?= strip_tags($query['recruiting']) ?></p>
		</li>
	</ul>


</div><!-- #content -->
<div id="sidebar-right">
</div>
</div><!-- #primary -->