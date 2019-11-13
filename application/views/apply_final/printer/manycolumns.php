

<div class="table-responsive">

	<div class="head" >

		<?= $title ?>
	</div>
	<table class="table table-condensed">
		
		
		<? foreach($query as $row):?>
		<tbody>
		
			<? foreach($row as $key=>$value):?>
			<tr>
				<td width="50%"><?= lang($key)?></td>
				<td><?= $value?></td>	
			</tr>
			<? endforeach ;?>

			<tr>
				<td colspan="2"></td>
			</tr>
						
		</tbody>
		<? endforeach ;?>
	</table>
</div>

<div class="page_break">
</div>
