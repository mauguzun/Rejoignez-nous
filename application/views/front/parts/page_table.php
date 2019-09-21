


<div id="content" role="main" style="min-height:100vh;">
	<div class="breadcrumbs eap-breadcrumbs">
	<a href="<?= base_url()?>">
		<span><?= lang('Careers')?></span>
	</a>&gt;
	<a href="#">
		<span class="current-page"><?= $title ?></span>
	</a>
	
	
	
		</div>
	<h1 class="post-title"><?= $title ?></h1><br>


<?= isset($allert) ? $allert : null ;?>

	<table id="example" class="table table-hover" >
		<thead>
			<tr>
				<?
				foreach($headers as $heaeder):?>
				<th scope="col">
					<b><?= lang($heaeder)?></b>
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
				<td>
					<?= $value[$heaeder]?>
				</td>
				<? endforeach ;?>
			</tr>
			<? endforeach ;?>

		</tbody>



	</table>

</div><!-- #content -->
<div id="sidebar-right">
</div>
</div><!-- #primary -->








