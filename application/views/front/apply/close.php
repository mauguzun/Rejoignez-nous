



<div class="row">


	<div class="col-md-6">
		<? if($app): ?>
		<center> <a class="btn btn-outline-danger" onclick="return confirm('Are you sure?');" href="<?= $delete ?>" role="button">
				<i class="far fa-trash-alt"></i> Delete	</a></center>
		<? endif; ?>
	</div>
 
	<div class="col-md-6">
		<div class="form-group">

			<center>
				<button class="btn btn-primary" title=" <?= lang('press_save_to_progres')?>" id="save" type="submit">
					<?= lang('save')?>		<i class="fas fa-arrow-right"></i> </button>

			</center></div>
	</div>
</div>





</form>

</div>


</div><!-- #content -->
<div id="sidebar-right">
</div>
</div><!-- #primary -->
