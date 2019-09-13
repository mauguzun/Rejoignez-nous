<table class="lang_table" width="100%">


	
	
	<tr class="">
		<td><input  type="text" disabled="true" class="form-control" value="French level"/></td>
		<td><?=  $control['french_level'] ?></td>
	</tr>
	<tr class="">
		<td><input  type="text" disabled="true" class="form-control" value="English level"/></td>
		<td><?=  $control['english_level'] ?></td>
	</tr>
	<?
	if(isset($data)) :?>

	<?
	foreach($data as $onedata):?>
	<tr class="one_row">
		<td><?= $onedata['language[]']?></td>
		<td><?= $onedata['level_id[]']?></td>
		<td>
			<i class="fas fa-plus"></i></td>
		<td>
			<i class="fas fa-minus"></i></td>
	</tr>

	<? endforeach ?>

	<?
	else :?>

	<tr class="one_row">
		<td><?= $control['language[]']?></td>
		<td><?= $control['level_id[]']?></td>
		<td>
			<i class="fas fa-plus"></i></td>
		<td>
			<i class="fas fa-minus"></i></td>
	</tr>

	<? endif; ?>



</table>
<br /><br /><br /><br />
<?= $control['data-list']?>


<style>
	i
	{
		cursor: pointer;
	}
	td
	{
		padding: 5px;
	}
</style>

