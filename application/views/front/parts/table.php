
<table id="example" class="table table-striped table_row" style="width:100%">
	<thead>
		<tr>
			<?
			foreach($headers as $heaeder):?>
			<th>
				<?= lang($heaeder)?>
			</th>
			<? endforeach ;?>
		</tr>
	</thead>
	<tbody>


		<tr>
			<?
			foreach($query as $value):?>
			<?
			foreach($headers as $heaeder):?>
			<?
			if($heaeder == 'type'):?>
			<th> <?= lang( $value[$heaeder])?></th>
			<?
			else :?>

			<th> <?= $value[$heaeder]?></th>
			<? endif; ?>

			<? endforeach ;?>
		</tr>
		<? endforeach ;?>

	</tbody>



</table>














