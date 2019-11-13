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


		


<div class="container">
<!-- Simple Invoice - START -->

<div class="panel-body">
<!--app-->
<div class="table-responsive">
	<table class="table table-condensed">

		<tbody>
			<tr>
				<td colspan="2" class="head" >

					# <?= $query['id']?>
				</td>
			</tr>



			<?
			if($query['offer_id']) :?>
			<tr>
				<td colspan="2" class="head">
					<a  href="<?= base_url().'/offer/'.$query['offer_id']?>">

						<?= base_url().'/offer/'.$query['offer_id']?>
					</a>
				</td>
			</tr>
			<? endif;?>



						
		</tbody>
	</table>
</div>

<div class="page_break">
</div>


