<script>


$('#employer').keyup(function(){


        if($('#employer').val().trim().length > 1  ){

            $("#hidden").html('<?= isset($hidden)?str_replace("\n","",$hidden):NULL;?>') ;
        }else if ($('#employer').val().trim().length  == 0 ){
            $("#hidden").html(' ') ;

        }
    })

</script>  