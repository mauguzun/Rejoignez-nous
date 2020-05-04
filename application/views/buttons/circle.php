
<? $id = uniqid() ?>


<span class="btn-group dropright cyrcle_drop">
	<a           data-toggle="collapse"
                 href="#<?= $id ?>"
                 role="button"
                 aria-expanded="false"
                 aria-controls="collapseExample"
                 class="text-muted"
                 >
		<i data-id='<?= $url ?>' style="color:<?= $this->colors->get_color($color_id) ?>" class="fa fa-circle">

		</i>
	</a>

	<div class="collapse cyrcle_thing" id="<?=$id ?>"  style=" position: absolute !important;
  z-index: 20; background: #fff ; padding: 20px; border: 1px solid white; box-shadow: 5px 5px 5px rgba(68, 68, 68, 0.6);">
		<div  data-url="<?= $url ?>"  class="card card-body">

			<?
			foreach($this->colors->get_colors() as $value=>$onecolor):?>
			<i data-circle="true" data-value='<?= $value?>' style="color:<?= $onecolor ?>" class="fa fa-circle ">

			</i>



			<? endforeach ;?>

		</div>
	</div>

<script>
	$(".cyrcle_drop").click(function(){
		$(".cyrcle_thing").css("display","none");
		$(this).children(".cyrcle_thing").css("display","initial");
	});
</script>
</span>
