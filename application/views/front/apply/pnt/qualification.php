<table class="lang_table" width="100%">



	<?
	if(isset($data)) :?>

	<?
	foreach($data as $onedata):?>
	<tr class="one_row">
		<td><?= $onedata['aircaft_type[]']?></td>
		<td><?= $onedata['last_online_check[]']?></td>
		<td><?= $onedata['last_simulator_control[]']?></td>
		<td><?= $onedata['last_flight[]']?></td>
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
		<td><?= $control['last_online_check[]']?></td>
		<td><?= $control['last_simulator_control[]']?></td>
		<td><?= $control['last_flight[]']?></td>
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


