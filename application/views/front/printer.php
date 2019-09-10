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


			*
			{
				box-sizing: border-box;
				font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
				font-size: 11px;
			}
			.page_break
			{
				page-break-before: always;
			}
			table
			{
				border-spacing: 0px;
				border-collapse: collapse;
				width: 100%;
				max-width: 100%;
				margin-bottom: 15px;
				background-color: transparent; /* Change the background-color of table here */
				text-align: left; /* Change the text-alignment of table here */
			}

			th
			{
				font-weight: bold;
				padding: 10px;
			}

			td
			{
				padding: 10px;
				text-transform: capitalize;
			}

			/* Stylized */

			/* Adding Striped Effect for odd rows */

			tr
			{
				background-color: transparent; /* Change the default background-color of rows here */
			}


			tr th
			{
				background-color: #dddddd; /* Change the background-color of heading here */
			}

			tr
			{
				border-top: 1px solid #cccccc;
				border-bottom: 1px solid #cccccc;
			}

			th, td
			{
				border: none;
			}

			.head
			{
				background: #fafafa;
				text-align: center;
				padding-top: 20px;
				padding-bottom: 20px;

			}
			td
			{
				white-space: normal !important;
			}
		</style>
	</head>
	<body>


		<? $data =
		[

			'profile'=>[
				'user_civility'=>'civility',
				'first_name'=>'first_name',
				'last_name'=>'last_name',
				'email'=>'email',
				'edit_user_birthday'=>'birthday',

				'address'=>'address',
				'zip'=>'zip',
				'city'=>'city',
				'country'=>'country',
				'phone'=>'phone',

			],
			'education'=>[
				'create_offer_studies'=>'studies',
				'create_offer_university'=>'university',
				'education_level'=>'education_level',

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

							<?
							foreach($data as $key=>$arr): ?>
							<?
							if($key == 'education') :?>
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

							<tr>
								<td colspan="2" class="head">

									<strong>
										<?= lang('languages') ?>
									</strong>
								</td>
							</tr>

							<tr>
								<td>
									<strong>
										<?= lang('english_level')?>
									</strong>
								</td>
								<td class="">
									<?= $query['english_level']?>
								</td>
							</tr>
							<tr>
								<td>
									<strong>
										<?= lang('french_level')?>
									</strong>
								</td>
								<td class="">
									<?= $query['french_level']?>
								</td>
							</tr>

							<?
							foreach($query['more_lang'] as $lang=>$level) :?>
							<tr>
								<td>
									<strong>
										<?= $lang?>
									</strong>
								</td>
								<td class="">
									<?= $level?>
								</td>
							</tr>

							<? endforeach ;?>

						</tbody>
					</table>
				</div>

				<div class="page_break">
				</div>


				<table class="table table-condensed">

					<tbody>
						<?
						if($query['hr_expirience']) :?>
						<tr>
							<td colspan="3" class="text-center head" >
								<strong>
									<?= lang('_hrexpiricne') ?>
								</strong>
							</td>
						</tr>
						<tr>


							<td>
								<?= lang('area') ?>
							</td>
							<td>
								<?= lang('duration') ?>
							</td>
							<td>
								<?= lang('managerial') ?>
							</td>


						</tr>

						<?
						foreach($query['hr_expirience'] as $value):?>

						<tr>


							<td>
								<?= $value['area'] ?>
							</td>
							<td>
								<?= $value['duration'] ?>
							</td>
							<td>
								<?= $value['managerial'] ?>
							</td>


						</tr>

						<? endforeach;?>
						<? endif ;?>
						<?
						if($query['pnc_exp']):?>
						<tr>
							<td colspan="3" class="text-center head" >
								<strong>
									<?= lang('_pnc_expirience') ?>
								</strong>
							</td>
						</tr>

						<tr>


							<td>
								<?= lang('function') ?>
							</td>
							<td>
								<?= lang('duration') ?>
							</td>
							<td>
								<?= lang('company') ?>
							</td>


						</tr>

						<?
						foreach($query['pnc_exp'] as $value):?>

						<tr>


							<td>
								<?= $value['function'] ?>
							</td>
							<td>
								<?= $value['duration'] ?>
							</td>
							<td>
								<?= $value['company'] ?>
							</td>


						</tr>
						<? endforeach ?>
						<? endif ;?>
					</tbody>
				</table>


				<!--mec exp-->
				<?
				if($query['mec_expirience']) :?>
				<div class="page_break">
				</div>
				<div class="table-responsive">
					<table class="table table-condensed">

						<tbody>
							<tr>
								<td colspan="2" class="text-center head" >
									<strong>
										<?= lang('mechanic_offer_aeronautical_experience') ?>
									</strong>
								</td>
							</tr>

							<?
							foreach($query['mec_expirience'] as $lang=>$value):?>

							<tr>
								<td>
									<strong>
										<?= lang($lang) ?>
									</strong>
								</td>
								<td>
									<?= $value ?>
								</td>


							</tr>

							<? endforeach;?>
						</tbody>
					</table>
				</div>
				<!--pnt exp-->
				<? endif ;?>
				<?
				if($query['pnt_exp']) :?>
				<div class="page_break">
				</div>
				<div class="table-responsive">
					<table class="table table-condensed">

						<tbody>
							<tr>
								<td colspan="6" class="text-center head" >
									<strong>
										<?= lang('pnt_expirience') ?>
									</strong>
								</td>
							</tr>
							<tr>
								<td>
									<strong>
										<?= lang('aircaft_type') ?>
									</strong>
								</td>
								<td>
									<strong>
										<?= lang('cdb_hours') ?>
									</strong>
								</td>
								<td>
									<strong>
										<?= lang('opl_hours') ?>
									</strong>
								</td>
								<td>
									<strong>
										<?= lang('total_hours') ?>
									</strong>
								</td>
								<td>
									<strong>
										<?= lang('last_flight') ?>
									</strong>
								</td>
								<td>
									<strong>
										<?= lang('company') ?>
									</strong>
								</td>
							</tr>

							<?
							foreach($query['pnt_exp'] as $value):?>

							<tr>
								<td>
									<?= $value['aircaft_type'] ?>
								</td>
								<td>
									<?= $value['cdb_hours'] ?>
								</td>
								<td>
									<?= $value['opl_hours'] ?>
								</td>
								<td>
									<strong>
										<?= $value['total_hours'] ?>
									</strong>
								</td>
								<td>
									<?= date_to_input( $value['last_flight']) ?>
								</td>
								<td>
									<?= $value['company'] ?>
								</td>


							</tr>

							<? endforeach;?>
						</tbody>
					</table>
				</div>

				<? endif ;?>


				<!--misc-->


				<!--pnt inst exp-->
				<?
				if($query['pnt_exp_inst']) :?>
				<div class="page_break">
				</div>
				<div class="table-responsive">
					<table class="table table-condensed">

						<tbody>
							<tr>
								<td colspan="6" class="text-center head" >
									<strong>
										<?= lang('pnt_exp_inst') ?>
									</strong>
								</td>
							</tr>
							<tr>
								<td>
									<strong>
										<?= lang('aircaft_type') ?>
									</strong>
								</td>
								<td>
									<strong>
										<?= lang('approval_number') ?>
									</strong>
								</td>
								<td>
									<strong>
										<?= lang('date_of_issue') ?>
									</strong>
								</td>
								<td>
									<strong>
										<?= lang('validity_date') ?>
									</strong>
								</td>

								<td>
									<strong>
										<?= lang('company') ?>
									</strong>
								</td>
							</tr>

							<?
							foreach($query['pnt_exp_inst'] as $value):?>

							<tr>
								<td>
									<?= $value['aircaft_type'] ?>
								</td>
								<td>
									<?= $value['approval_number'] ?>
								</td>
								<td>
									<?= date_to_input($value['date_of_issue']) ?>
								</td>
								<td>
									<strong>
										<?= date_to_input($value['validity_date']) ?>
									</strong>
								</td>

								<td>
									<?= $value['company'] ?>
								</td>


							</tr>

							<? endforeach;?>
						</tbody>
					</table>
				</div>
				<? endif ;?>



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
							'edit_salary'=>'salary',
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
					</tbody>
				</table>
			</div>
		</div>







	</body>
</html>
