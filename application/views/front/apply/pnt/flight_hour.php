<table class="lang_table" width="100%">



	<?
	if(isset($data)) :?>

	<?
	foreach($data as $onedata):?>
	<tr class="one_row">
		<td><?= $onedata['aircaft_type[]']?></td>
		<td><?= $onedata['company[]']?></td>
		<td width="10%"><?= $onedata['cdb_hours[]']?></td>
		<td width="10%"><?= $onedata['opl_hours[]']?></td>
		<td width="10%" ><?= $onedata['total_hours[]']?></td>
		<td width="20%"><?= $onedata['last_flight[]']?></td>
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
		<td><?= $control['company[]']?></td>
		<td width="10%"><?= $control['cdb_hours[]']?></td>
		<td width="10%"><?= $control['opl_hours[]']?></td>
		<td width="10%" ><?= $control['total_hours[]']?></td>
		<td width="20%"><?= $control['last_flight[]']?></td>
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


