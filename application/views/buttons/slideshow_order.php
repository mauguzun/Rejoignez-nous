
<? $id = uniqid() ?>


<span class="btn-group dropright">
	<a           data-toggle="collapse"
                 href="#<?= $id ?>"
                 role="button"
                 aria-expanded="false"
                 aria-controls="collapseExample"
                 class="text-muted"
                 >
		<span  data-title="<?= $id ?>" >   <?= empty($title) ? '-' : $title?></span>
	</a>

	<div class="collapse" id="<?=$id ?>" style=" position: absolute !important;
  z-index: 20; background: #165395 ; padding: 20px;  border: 1px solid white;box-shadow: 5px 5px 5px rgba(68, 68, 68, 0.6);" >
		<div  data-url=""  class="card card-body" >


			<ul>
				<?
				for($i=1 ;$i < $count +1; $i++ ) :?>

				<li> <a 
				 data-link="<?= $id ?>"
				 data-status='true'
				 href="<?= base_url().'shared/slideshow/ajaxstatus/'.$application_id.'/'.$i?>"> 
				 <?= $i?></a></li>



				<? endfor ;?>
			</ul>
		</div>
	</div>


</span>
