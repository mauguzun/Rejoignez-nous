

<?
foreach($control as $value) :?>
<div class="form-group">
	<?= $value ?>
</div>

<? endforeach;?>


<br />
<br />


<!--
<table class="lang_table" width="100%">


	
	<?
	if(isset($data)) :?>

	<?
	foreach($data as $onedata):?>
	<tr class="one_row">
		<td><?= $onedata['activity[]']?></td>
		<td>
			<i class="fas fa-plus"></i></td>
		<td>
			<i class="fas fa-minus"></i></td>
	</tr>

	<? endforeach ?>

	<?
	else :?>

	<tr class="one_row">
		<td><?= $activity?></td>
		<td>
			<i class="fas fa-plus"></i></td>
		<td>
			<i class="fas fa-minus"></i></td>
	</tr>

	<? endif; ?>



</table><br /><br /><br /><br />

-->

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


