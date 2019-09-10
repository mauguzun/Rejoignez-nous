
<? 

$id = uniqid();

$files = explode (',',$files);

 ?>


<span class="btn-group dropright">
	<a           data-toggle="collapse"
                 href="#<?= $id ?>"
                 role="button"
                 aria-expanded="false"
                 aria-controls="collapseExample"
                 class="text-muted"
                 >
		<span  data-title="<?= $id ?>" >  
		  <i class="fa fa-eye"></i> <small title="count">( <?= count($files) ?> )</small>
		  
		
		</span>
	</a>

	<div class="collapse" id="<?=$id ?>" style=" position: absolute !important;
  z-index: 20; background: #fff ; padding: 20px;  border: 1px solid white;box-shadow: 5px 5px 5px rgba(68, 68, 68, 0.6);" >
		<div  data-url=""  class="card card-body" >


			<ul>
				<?
				foreach($files as $file) :?>

				<li> <a 
			
				 target="_blank"
				 href="<?=  base_url().'user_uploads/cv/'.$file ?>"> 
				 <?= $file ?></a></li>



				<? endforeach ;?>
			</ul>
		</div>
	</div>


</span>
