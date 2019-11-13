

<div class="table-responsive">

	<div class="head" >

		<?= $title ?>
		
	</div>
	<table class="table table-condensed">

		<tbody>
			<tr>
				<? foreach($query[0] as $k=>$v):?>
				<th width="<?= 100 /  count($query[0]) ?>%"><?= $k ?></th>	
				<? endforeach ;?>
			</tr>
			<? foreach($query as $row):?>
			<tr>
				<? foreach($row as $k=>$v):?>
				<td><?= $v ?></td>
				<? endforeach;?>
			</tr>
			<? endforeach ;?>


						
		</tbody>
	</table>
</div>


<div class="page_break">
</div
