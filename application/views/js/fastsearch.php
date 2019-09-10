

<input
type="text"
multiple
class="demo"
multiple
data-initial-value='<?= $data ?>'
data-url="<?= $url ?>"
value='<?= implode(',',$selected )?>'
name="<?= $name ?>" />

<div style="color:red;text-align:center;"  data-error="<?= $name ?>" class="col-md-12">

</div>

<!--<script src="https://rawgit.com/dbrekalo/fastselect/master/dist/fastselect.standalone.min.js"></script>
--><script>

	callFunctions.push(function()
		{
			try
			{
				$('input[name="<?= $name ?>"]').fastselect();
			}
			catch(e)
			{
				alert(e)
			}

		});





</script> 