
<script>
	$("*[data-url-modal]").click(function(){
		$.getJSON($(this).attr('data-url-modal')).then((result)=>{
			
			 if(result.error === undefined){
                        $('#footerModalText').html(result.text);
                        $("#footerModal").modal()
              }
		})
})
</script>



