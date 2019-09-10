<table class="lang_table" width="100%">



	<?
	if(isset($data)) :?>

	<?
	foreach($data as $onedata):?>
	<tr class="one_row">
		<td><?= $onedata['start[]']?></td>
		<td><?= $onedata['end[]']?></td>
		<td><?= $onedata['school_name[]']?></td>
		<td><?= $onedata['qualification_obtained[]']?></td>
		<td>
			<i class="fas fa-plus"></i></td>
		<td>
			<i class="fas fa-minus"></i></td>
	</tr>

	<? endforeach ?>

	<?
	else :?>

	<tr class="one_row">
		<td width="20%"><?= $control['start[]']?></td>
		<td width="20%" ><?= $control['end[]']?></td>
		<td><?= $control['school_name[]']?></td>
		<td><?= $control['qualification_obtained[]']?></td>
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

