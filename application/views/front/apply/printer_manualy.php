<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>
			<?= $query['first_name']?> <?= $query['last_name']?>
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- Latest compiled and minified CSS -->
		<style>
			<?=  file_get_contents('css/print.css'); ?>
		</style>
	</head>
	<body>


		<? $data =
		[

			'profile'=>[
				'first_name'=>'first_name',
				'last_name'=>'last_name',
			

			],
			
			/*'_languages'=>[
			'french_level'=>'french_level',
			'english_level'=>'english_level',
			]
			*/
		];

		?>


		<div class="container">
			<!-- Simple Invoice - START -->

			<div class="panel-body">
				<!--app-->
				<div class="table-responsive">
					<table class="table table-condensed">

						<tbody>
							<tr>
								<td colspan="2" class="head" >
										
									# <?= $query['application_id']?>
								</td>
							</tr>
							
								
								
								<? if ($query['offer_id']) :?>
								<tr>
								<td colspan="2" class="head">
								<a  href="<?= base_url().'/offer/'.$query['offer_id']?>">
									
									<?= base_url().'/offer/'.$query['offer_id']?>
								</a>
								</td>
									</tr>
								<? endif;?>
									
								
							<?
							foreach($data as $key=>$arr): ?>
							<?
							if(   $key == 'education') :?>
							<tr>
								<td colspan="2" class="">

									<div class="page_break">
									</div>

								</td>
							</tr>
							<? endif ;?>
							<tr>
								<td colspan="2" class="head">

									<strong>
										<?= lang($key) ?>

									</strong>


								</td>
							</tr>
							<?
							foreach($arr as $lang=>$value):?>
							<tr>
								<td>
									<strong>
										<?= lang($lang)?>
									</strong>
								</td>
								<td class="">
									<?= $query[$value] ?>
								</td>
							</tr>

							<? endforeach;?>
							<? endforeach ;?>

					

							

						</tbody>
					</table>
				</div>

				<div class="page_break">
				</div>


			
			

			
			<div class="table-responsive">
				<table class="table table-condensed">

					<tbody>
						<tr>
							<td colspan="2" class="text-center head" >
								<strong>
									<?= lang('misc') ?>
								</strong>
							</td>
						</tr>


						<?
						$miss = [
							'handicaped'=>'handicaped',
							'salary'=>'salary',
							'aviability'=>'aviability',
							'medical_restriction'=>'medical_restriction'
						];


						foreach($miss as $lang=>$value):?>
						<tr>
							<td>
								<strong>
									<?= lang($lang)?>
								</strong>
							</td>

							<td style="word-wrap: break-word;">
								<?= $query[$value] ?>
							</td>
						</tr>

						<? endforeach;?>

						<?
						if(isset($query['employ_center'])) :?>
						<tr>
							<td><b><?= lang('employ_center') ?></b></td>
							<td><?= $query['employ_center']?></td>
						</tr>
						<? endif ;?>
						<?
						if(isset($query['medical_date'])) :?>
						<tr>
							<td><b><?= lang('end_date_last_medical_visit') ?></b></td>
							<td><?= $query['medical_date']?></td>
						</tr>
						<? endif ;?>
					</tbody>
				</table>
			</div>
		</div>
		<br />
		<hr/>
		<strong><?= lang('get_files_for_app')?></strong>
		<br />
		<br />
		
		 <?
			$path = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=".base_url()."user/zipapp/".$query['aid'];
            $file   = file_get_contents($path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($file);
            ?>
           
            <img src="<?= $base64 ?>" alt="">
		
		</div>




	</body>
</html>
