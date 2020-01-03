<script>

 $('*[data-edit').click(function(){
 	
     	 $.post($(this).attr('href')).then(e=>{
                    $('#footerModalText').html(e);
                    $("#footerModal").modal()
                    setShit();
                    });
     	return false;
});

</script>