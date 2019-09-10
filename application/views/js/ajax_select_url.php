
<input
type="text"
<?= isset($multiple ) && $multiple ? 'multiple' : null ?>

data-initial-value='<?= $data ?>'
data-url="<?= $url ?>"
value='<?= $selected ? implode(',',$selected ):NULL ; ?>'
name="<?= $name ?>" />
<div style="color:red;text-align:center;"  data-error="<?= $name ?>" class="col-md-12">

</div>

<!--<script src="https://rawgit.com/dbrekalo/fastselect/master/dist/fastselect.standalone.min.js"></script>
--><script>

	callFunctions.push(function()
		{
			try
			{
				$('*[name="<?= $name ?>"]').fastselect();
			}
			catch(e)
			{
				alert(e)
			}

		});





</script> 