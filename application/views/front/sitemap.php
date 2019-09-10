<div class="col-md-12 info">





	<div class="inner-info" style="padding-bottom: 20px !important; margin-bottom:30px;">
		<h4 style="center">
			<?= lang('sitemap')?>
		</h4>
		<div class="row">

			<div class="col-md-4">
				<strong><?= lang('general')?></strong>
				<hr />
				<nav>
					<ul class="nav flex-column">
						<?
						foreach($general as $key=>$value):?>
						<li class="nav-item">
						<a href="<?= base_url().$key?>">
						<?= lang($value)  ?></a></li>
						<?  endforeach;?>
					</ul>
				</nav>

			</div>

			<div class="col-md-4">
				<strong><?= lang('news')?></strong>
				<hr />
				<nav>
					<ul class="nav flex-column">
						<?
						foreach($news as $value):?>
						<li class="nav-item"><a href="<?= base_url().'/news/'.$value['id'] ?>">
						<?= $value['title']  ?>
							
						</a></li>
						<?  endforeach;?>
					</ul>
				</nav>

			</div>


			<div class="col-md-4">
				<strong><?= lang('our_offers')?></strong>
				<hr />
				<nav>
					<ul class="nav flex-column">
						<?
						foreach($offers as $value):?>
						<li class="nav-item"><a href="<?= base_url().'/offer/'.$value['id'] ?>">
						<?= $value['title']  ?>
							
						</a></li>
						<?  endforeach;?>
					</ul>
				</nav>

			</div>

			<br />
			<br />
			<br />
			<br />
		</div>
		<br />
		<br />
		<br />
		<br />

	</div>





</div>

</div>