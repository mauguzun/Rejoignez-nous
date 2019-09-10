
<? $data =
[

	'profile'=>[
		'user_civility'=>'civility',
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


<div class="col-lg-12">
<div class="panel panel-flat">
	<!-- Simple Invoice - START -->

	<div class="panel-body">
		<!--app-->
		<div class="table-responsive">
			<table class="table table-condensed">

				<tbody>
					

					<?
					if($query['offer_id']) :?>
					<tr>
						<td colspan="2" class="head">
							<a  target="_blank" href="<?= base_url().'/offer/'.$query['offer_id']?>">

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

	
		<?
		if( isset($query['application_cfs'])) :?>

		<div class="table-responsive">
			<table class="table table-condensed">

				<tbody>
					<tr>
						<td colspan="2" class="text-center head" >
							<strong>
								<?= lang('cfs') ?>
							</strong>
						</td>
					</tr>

					<tr>
						<td><?= lang('safety_training_certificate_date')?></td>
						<td><?= $query['application_cfs']['safety_training_certificate_date']?></td>
					</tr>
					<tr>
						<td><?= lang('safety_training_certificate_organization')?></td>
						<td><?= $query['application_cfs']['safety_training_certificate_organization']?></td>
					</tr>


				</tbody>
			</table>
		</div>
		<!--pnt application_cfs-->
		<? endif ;?>

		<!--- eu_nationality cfs --->

		<?
		if( isset($query['eu_nationality'])) :?>

		<div class="table-responsive">
			<table class="table table-condensed">

				<tbody>
					<tr>
						<td colspan="2" class="text-center head" >
							<strong>
								<?= lang('eu_nationality') ?>
							</strong>
						</td>
					</tr>

					<tr>
						<td><?= lang('eu_nationality')?></td>
						<td><?= $query['eu_nationality']?></td>
					</tr>
					<tr>
						<td><?= lang('can_work_eu')?></td>
						<td><?= $query['can_work_eu']?></td>
					</tr>


				</tbody>
			</table>
		</div>
		<!--pnt exp-->
		<? endif ;?>

		<!--  --->

		<!--hr exp-->

		<table class="table table-condensed">

			<tbody>
				<?
				if(isset($query['hr_expirience'])) :?>
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
				if(isset( $query['pnc_exp']) ):?>
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
		if( isset($query['mec_expirience'])) :?>
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
			<table class="table table-condensed">

				<tbody>
					<tr>
						<td colspan="2" class="text-center head" >
							<strong>
								<?= lang('aeronautical_baccalaureate') ?>
							</strong>
						</td>
					</tr>
					<tr>
						<td>
							<strong><?= lang('licenses_b1')?></strong>
						</td>
						<td>
							<?= $query['licenses_b1'] ?>
						</td>
					</tr>
					<tr>
						<td>
							<strong><?= lang('licenses_b2')?></strong>
						</td>
						<td>
							<?= $query['licenses_b2'] ?>
						</td>
					</tr>

					<tr>
						<td>
							<strong><?= lang('school')?></strong>
						</td>
						<td>
							<?= $query['school'] ?>
						</td>
					</tr>
					<tr>
						<td>
							<strong><?= lang('aeronautical_baccalaureate')?></strong>
						</td>
						<td>
							<?= $query['aeronautical_baccalaureate'] ?>
						</td>
					</tr>
					<tr>
						<td>
							<strong><?= lang('complementary_mention_b1')?></strong>
						</td>
						<td>
							<?= $query['complementary_mention_b1'] ?>
						</td>
					</tr>
					<tr>
						<td>
							<strong><?= lang('complementary_mention_b2')?></strong>
						</td>
						<td>
							<?= $query['complementary_mention_b2'] ?>
						</td>
					</tr>





				</tbody>
			</table>
		</div>
		<!--pnt exp-->
		<? endif ;?>

		<?
		if( isset($query['pnt_exp'] )) :?>
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
					<!---->
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
					<!---->
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
					<a href=""></a>
				</tbody>
			</table>
		</div>

		<? endif ;?>


		<!--misc-->
		<?
		if( isset($query['pnt_total_flight_hours'])) :?>

		<div class="table-responsive">
			<table class="table table-condensed">

				<tbody>
					<tr>
						<td colspan="6" class="text-center head" >
							<strong>
								<?= lang('total_flight_hours') ?>
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
					foreach($query['pnt_total_flight_hours'] as $value):?>

					<tr>
						<td>
							<?= $value['aircaft_type'] ?>
						</td>
						<td>
							<?= $value['cdb_hours'] ?>
						</td>
						<td>
							<?= $value['opl_hours']?>
						</td>
						<td>

							<?= $value['total_hours']?>

						</td>
						<td>

							<?= $value['last_flight']?>

						</td>
						<td>

							<?= $value['company']?>

						</td>

					</tr>

					<? endforeach;?>
				</tbody>
			</table>
		</div>
		<? endif ;?>

		<!--pnt inst exp-->
		<?
		if( isset($query['pnt_exp_inst'])) :?>

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



		<?
		if( isset($query['pnt_qualification'])) :?>

		<div class="table-responsive">
			<table class="table table-condensed">

				<tbody>
					<tr>
						<td colspan="6" class="text-center head" >
							<strong>
								<?= lang('qualification_type') ?>
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
								<?= lang('last_online_check') ?>
							</strong>
						</td>
						<td>
							<strong>
								<?= lang('last_simulator_control') ?>
							</strong>
						</td>
						<td>
							<strong>
								<?= lang('last_flight') ?>
							</strong>
						</td>


					</tr>

					<?
					foreach($query['pnt_qualification'] as $value):?>

					<tr>
						<td>
							<?= $value['aircaft_type'] ?>
						</td>
						<td>
							<?= $value['last_online_check'] ?>
						</td>
						<td>
							<?= date_to_input($value['last_simulator_control']) ?>
						</td>
						<td>
							<strong>
								<?= date_to_input($value['last_flight']) ?>
							</strong>
						</td>


					</tr>

					<? endforeach;?>
				</tbody>
			</table>
		</div>
		<? endif ;?>

		<?
		if( isset($query['pnt_completary']['motivation_asl'])) :?>

		<div class="table-responsive">
			<table class="table table-condensed">

				<tbody>
					<tr>
						<td colspan="6" class="text-center head" >
							<strong>
								<?= lang('complementary_informations') ?>
							</strong>
						</td>
					</tr>
					<tr>
						<td>
							<strong>
								<?= lang('motivation_asl') ?>
							</strong>
						</td>
						<td>
							<?= $query['pnt_completary']['motivation_asl'] ?>
						</td>

					</tr>
					<tr>
						<td>
							<strong>
								<?= lang('Involved in incidents') ?>
							</strong>
						</td>
						<td>
							<?= $query['pnt_completary']['involved_in_incidents'] ?>
						</td>

					</tr>


				</tbody>
			</table>
		</div>
		<? endif ;?>



	

	<div class="page_break">
	</div>

	<?
	if(isset($query['function'])) :?>


	
	<div class="table-responsive">


		<table class="table table-condensed">
			<tbody>
				<tr>
					<td colspan="4" class="text-center head">
						<strong>
							<?= lang('position') ?>
						</strong>
					</td>
				</tr>
				<tr>
					<td><strong><?= lang('function')?></strong></td>
					<td><?= $query['function']['function']?></td>
				</tr><tr>
					<td><strong><?= lang('type')?></strong></td>
					<td><?= $query['function']['type']?></td>
				</tr><tr>
					<td><strong><?= lang('activity')?></strong></td>
					<td><?= $query['function']['activities']?></td>
				</tr>

			</tbody>
		</table>




	</div>
	<? endif; ?>
<!--aa-->
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
					'comment'=>'comment',
					
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
</div>
<style>
	.head
	{
		background: #fafafa;
		text-align: center;
		padding-top: 40px;
		padding-bottom: 40px;
		color:#165395;
		text-transform : uppercase;

	}
	td
	{
		white-space: normal !important;
	}
	.page_break{
		height: 20px;
		
	}
</style>




