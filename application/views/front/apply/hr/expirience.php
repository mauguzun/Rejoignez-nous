<table class="lang_table" width="100%">

	

	<?
	if(isset($data)) :?>

	<?
	foreach($data as $onedata):?>
	<tr class="one_row">
		<td><?= $onedata['area[]']?></td>
		<td><?= $onedata['duration[]']?></td>
		<td><?= $onedata['managerial[]']?></td>
		<td>
			<i class="fas fa-plus"></i></td>
		<td>
			<i class="fas fa-minus"></i></td>
	</tr>

	<? endforeach ?>

	<?
	else :?>

	<tr class="one_row">
		<td><?= $control['area[]']?></td>
		<td><?= $control['duration[]']?></td>
		<td><?= $control['managerial[]']?></td>
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
	td{
		padding: 5px;
	}
</style>

