<div class="row">
<div class="col-md-4 menu">
	<div class="inner-menu">
		<h3 style="padding:21px; margin-left:10px;">CANDIDATE SPACE</h3>
		<ul class="menu-candidate">



			<?
			foreach($user_menu as $url=>$value) :?>


			
			<li
            	<?= ($url == $page )? 'style="background-color:white;border-color: #105497;  border: 1px solid #105497;"' : null ?>

                class="list-item-menu"

                >

				<span
                <?= ($url == $page )? 'style="color:#105497;"' : null ?>
                 onclick="location.replace('<?= base_url().$url ?>')">
					<b><?= lang($value) ?></b></span>
			</li>
			

			<? endforeach ;?>


			<!-- <li class="list-item-menu" style="background-color:white;
			/* border-color: #105497; */
			border: 1px solid #105497;"><span style="color:#105497;"><b>Profile</b></span></li>
			<li class="list-item-menu"><span><b>My applications</b></span></li>
			<li class="list-item-menu"><span><b>My password</b></span></li>
			<li class="list-item-menu"><span><b>Sign out</b></span></li>-->
		</ul>
	</div>
</div>
