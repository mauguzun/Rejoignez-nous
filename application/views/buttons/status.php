
<? $id = uniqid() ?>


<span class="btn-group dropright">
	<a           data-toggle="collapse"
                 href="#<?= $id ?>"
                 role="button"
                 aria-expanded="false"
                 aria-controls="collapseExample"
                 class="text-muted"
                 >
		<span  data-title="<?= $id ?>" >
			<?= empty($title) ? '-' : lang($title)?>
		</span>
	</a>

	
	<div class="collapse" id="<?=$id ?>" style=" position: absolute !important;
  z-index: 20; background: #fff ; padding: 20px;  border: 1px solid white;box-shadow: 5px 5px 5px rgba(68, 68, 68, 0.6);" >
		<div  data-url=""  class="card card-body" >


			<ul>
				<?

				foreach($statuses as $key=>$value) :?>

				<?
				if($key == 6): ?>
				<li>
					<a

				 data-link="<?= $id ?>"
				 data-id="<?= $key ?>"
				 data-application-id="<?= $application_id ?>"

				 data-status='true'
				 href="<?= base_url().'shared/applications/ajaxstatus/'.$application_id.'/'.$key?>">
						<?= lang($value) ?><!--$keyz-->
					</a>
				</li>

				<? endif; ?>

				<? endforeach ;?>
			</ul>
		</div>

		<div data-function="<?= $id ?>" class="pls_hide" style="display: none">
			<label>
				Re-asing function
			</label>
			<div data-function-list="<?= $id ?>">

			</div>
		</div>
	</div>


</span>
