<script>


$('#function').keyup(function(){


        if($('#function').val() != 'Aucune' ){

            $("#hidden").html('<?= isset($hidden)?str_replace("\n","",$hidden):NULL;?>') ;
        }else if ($('#employer').val().trim().length  == 0 ){
            $("#hidden").html(' ') ;

        }  
    })

</script>  