<div id="content" role="main">

	
	
	<div class="alert alert-primary" role="alert" v-if="first"  >
		<div class="card-body">
			<p class="card-text">
				<?= lang('Would you like to apply for a position as a Commercial Flight Attendant or Technical Flight Attendant')?>
			</p>

			<a    href="<?= base_url()?>/apply/new/unsolicated" class="btn btn-danger"><?= lang('no')?></a>
			<a tabindex="0" href="#" @click="first = false" class="btn btn-primary"><?= lang('yes')?></a>
		</div>
	</div>
	
	<div class="alert alert-primary" role="alert"  v-if="!first">
		<div class="card-body">
			<p class="card-text">
			
				<ul>
					<li>
						<b>
							<a href="<?= base_url()?>/apply/new/uns_pnt">
								<?= lang('Technical Flight Attendanto')?>
							</a></b>	
						
					</li>
					<li>
						<b>
							<a href="<?= base_url()?>/apply/new/uns_pnc">
								<?= lang('Commercial Flight Attendant')?>
							</a>
						</b>	
					</li>
				</ul>
				
				

			</p>
			
			<a href="#" @click="first = true" class="btn btn-success"><?= lang('back')?></a>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
	let page =  new Vue({
			el: "#content",
			data: {
				first:true
		
			}});
</script>