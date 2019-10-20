<div class="card">
	<div   
	class="card-header"
	@click="open('<?= $name?>')" 
	:class="headerClass('<?= $name ?>')"
	>
		<h2 class="mb-0">
			<button class="btn btn-link" type="button">
				<?= lang($name)?>        
			</button>
		</h2>
	</div>
<div :class="showPanel('<?= $name?>')" class="collapse"  >