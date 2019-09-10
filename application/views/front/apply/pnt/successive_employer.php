<table class="lang_table" width="100%">


	<?
	if(isset($data)) :?>

	<?
	foreach($data as $onedata):?>
	<tbody class="one_row">
		<tr >
			<td><?= $onedata['start[]']?></td>
			<td width="20%" ><?= $onedata['end[]']?></td>
			<td width="20%"><?= $onedata['employer[]']?></td>
			<td width=""><?= $onedata['function[]']?></td>

			<td>
				<i class="fas fa-plus"></i></td>
			<td>
				<i class="fas fa-minus"></i></td>
		</tr>
		<tr>
			<td colspan="5" class="add_info" style="display: none" >

				<label>*</label>
				<?= $onedata['name[]']?>
				<label>*</label>
				<?= $onedata['email[]']?>
				<label>*</label>
				<?= $onedata['country_id[]']?>
				<?= $onedata['city[]']?>

				<?= $onedata['zip[]']?>
				<?= $onedata['address[]']?>
				<label>*</label>
				<?= $onedata['phone[]']?>
				<?= $onedata['phone_2[]']?>
				<label>*</label>
				<?= $onedata['why_left[]']?>

			</td>

		</tr>
	</tbody>


	<? endforeach ?>

	<?
	else :?>

	<tbody class="one_row">
		<tr >
			<td><?= $control['start[]']?></td>
			<td width="20%" ><?= $control['end[]']?></td>
			<td width="20%"><?= $control['employer[]']?></td>
			<td width=""><?= $control['function[]']?></td>

			<td>
				<i class="fas fa-plus"></i></td>
			<td>
				<i class="fas fa-minus"></i></td>
		</tr>
		<tr>
			<td colspan="5" class="add_info" style="display: none"  >

				<label>*</label>
				<input   name="name[]" class="form-control" data-required='1'
				autofocus placeholder="<?= lang('first_name')?>" />
				<label>*</label>
				<input type="email[]" name="email" class="form-control " data-required='1'
				placeholder="<?= lang('email')?>" />
				<label>*</label>
				<?= $control['country_id[]']?>
				<input type="city[]" name="" class="form-control" placeholder="<?= lang('city')?>" />

				<input name="zip[]" class="form-control"   placeholder="<?= lang('zip')?>" />
				<input name="address[]" class="form-control"   placeholder="<?= lang('address')?>" />
				<label>*</label>
				<input type="tel" name="phone[]" class="form-control" data-required='1'  autofocus placeholder="<?= lang('phone')?>" />
				<input type="tel" name="phone_2[]" class="form-control "  autofocus placeholder="<?= lang('phone')?>" />
				<label>*</label>
				<textarea  name="why_left[]" class="form-control" data-required='1'  placeholder="<?= lang('why_left')?>"></textarea>

			</td>

		</tr>
	</tbody>
	<? endif; ?>



</table>
<br /><br /><br /><br />


<style>
	i
	{
		cursor: pointer;
	}
	td
	{
		padding: 2px;
	}
	.one_row
	{
		border: 1px solid #edeeef;
		display: block;
		float: left;
	}
	.add_info
	{
		padding-top: 50px;
		background: #fdfdfd;
	}
	.add_info input ,.add_info select
	{
		margin-bottom: 10px;
	}
</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js">
</script>
<script src="<?= base_url()?>css/locales/bootstrap-datepicker.<?= $this->session->userdata('lang') ?>.min.js" >
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css" />

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>

<script>

	$('body').on("focusout",'*[name="employer[]"]',function()
		{
			if($(this).val().trim().length  > 0 )
			{
				$(this).parent().parent().parent().find('.add_info').slideDown();
				$(this).parent().parent().parent().find('[data-required]').attr('required','required')
			}else
			{
				$(this).parent().parent().parent().find('[data-required]').removeAttr('required')
				$(this).parent().parent().parent().find('.add_info').slideUp();
			}

		})


	$('body').on('click', '.fa-plus', function()
		{
			$('*[data-calendar]').datepicker('destroy');
			$($(this).parent().parent().parent()).clone(true).find("input:text").val("").end().insertAfter('.one_row:last');
			initCalendar()
		});


	$('.fa-minus').click(function()
		{
			if($('.one_row').length >1 )
			$($(this).parent().parent().parent()).remove();
		})



	function initCalendar()
	{
		
		$('*[data-calendar]').datepicker(
			{
				todayBtn: "linked",
				clearBtn: true,
				daysOfWeekHighlighted: [6,0],
				autoclose: true,
				format: 'dd/mm/yyyy',
				weekStart:1,
				language: "<?= $this->session->userdata('lang') ?>"
			});

	}
	initCalendar();


</script>

