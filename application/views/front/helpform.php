
<form id="help_form" action="<?= $url?>">



<div class="form-group">
	<label><?= lang('first_name')?></label>
	<input  required="require" name="name" type="text" value="<?= isset($candidate['first_name']) ?  $candidate['first_name']:  NULL ?>"   class="form-control" placeholder="<?= lang('first_name')?>"/>
</div>

<div class="form-group">
	<label><?= lang('subjects')?></label>
	<input  required="require" name="subject" type="text"    class="form-control" placeholder="<?= lang('subjects')?>"/>
</div>

<div class="form-group">
	<label><?= lang('email')?></label>
	<input  value="<?= $email ?>" required="require" name="email" type="email"  class="form-control" placeholder="<?= lang('email')?>"/>
</div>

<div class="form-group">
	<label><?= lang('you_question_go_here')?></label>
	<textarea name="comment" class="form-control" required="require" placeholder="<?= lang('you_question_go_here')?>" ></textarea>
</div>

<div class="form-group">
	<button class="btn btn-outline-success my-2 my-sm-0" type="submit"  id="send_help" style="float: right;">
		Save        </button>
</div>
</form>


<script>
	$('#help_form').on('submit',function(e){
		
		e.preventDefault();
		

	    let send = $.post($('#help_form').attr('action'),
	    	$('#help_form').serializeArray()
	    );
	    
	    send.then(e=>{
	      	 let result = JSON.parse(e);
	      	  $('#help_form').html("<label>"+result.resp+"</label>")
	    });
	    
	    
	
	
		
	})
</script>