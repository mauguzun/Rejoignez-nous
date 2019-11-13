

<div class="table-responsive">

	<div class="head" >

		<?= $title ?>
	</div>
	<table class="table table-condensed">

		<tbody>
		
			<? foreach($query as $key=>$value):?>
			<tr>
				<td width="50%"><?= lang($key)?></td>
				<td><?= $value?></td>	
			</tr>
			<? endforeach ;?>


						
		</tbody>
	</table>
</div>

<div class="page_break">
</div>
