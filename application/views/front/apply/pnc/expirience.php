<table class="lang_table" width="100%">



	<?
	if(isset($data)) :?>

	<?
	foreach($data as $onedata):?>
	<tr class="one_row">
		<td><?= $onedata['function[]']?></td>
		<td><?= $onedata['duration[]']?></td>
		<td><?= $onedata['company[]']?></td>
		<td>
			<i class="fas fa-plus"></i></td>
		<td>
			<i class="fas fa-minus"></i></td>
	</tr>

	<? endforeach ?>

	<?
	else :?>

	<tr class="one_row">
		<td><?= $control['function[]']?></td>
		<td><?= $control['duration[]']?></td>
		<td><?= $control['company[]']?></td>
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

<script>



	$('input[data-change=true]').on('keyup', function()
		{

			let names = ['duration[]','company[]'];
			let value = $(this).val().trim().toLowerCase();
			if(value == 'aucune')
			{

				for(var i = 0 ; names[i] ;i++)
				{
					$(this).parent().parent().find('input[name="'+names[i]+'"]').fadeIn();
					$(this).parent().parent().find('input[name="'+names[i]+'"]').attr('required','required')
				}


			}else
			{
				for(var i = 0 ; names[i] ;i++)
				{
					$(this).parent().parent().find('input[name="'+names[i]+'"]').fadeOut();
					$(this).parent().parent().find('input[name="'+names[i]+'"]').removeAttr('required')
				}
			}
		});


	
</script>