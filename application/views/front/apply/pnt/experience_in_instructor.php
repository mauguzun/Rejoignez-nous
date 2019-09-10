<table class="lang_table" width="100%">



	<?
	if(isset($data)) :?>

	<?
	foreach($data as $onedata):?>
	<tr class="one_row">
		<td><?= $onedata['aircaft_type[]']?></td>
		<td width="10%" ><?= $onedata['approval_number[]']?></td>
		<td width="20%"><?= $onedata['date_of_issue[]']?></td>
		<td width="20%"><?= $onedata['validity_date[]']?></td>
		<td ><?= $onedata['company[]']?></td>
	
		<td>
			<i class="fas fa-plus"></i></td>
		<td>
			<i class="fas fa-minus"></i></td>
	</tr>

	<? endforeach ?>

	<?
	else :?>

	<tr class="one_row">
		<td><?= $control['aircaft_type[]']?></td>
		<td width="10%" ><?= $control['approval_number[]']?></td>
		<td width="20%"><?= $control['date_of_issue[]']?></td>
		<td width="20%"><?= $control['validity_date[]']?></td>
		<td ><?= $control['company[]']?></td>
		<td>
			<i class="fas fa-plus"></i></td>
		<td>
			<i class="fas fa-minus"></i></td>
	</tr>

	<? endif; ?>



</table>
<br /><br /><br /><br />


<style>
	i
	{
		cursor: pointer;
	}
	td
	{
		padding: 2px;
	}
</style>
<?= $control['data-list']?>


