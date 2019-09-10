

<div class="row">
    <div class="col-lg-12" >

        <!-- Marketing campaigns -->
        <b>
            With selected
        </b>
        <button class="btn btn-primary square" id="download">
            <i class="far fa-file-archive">
            </i>
        </button>
        <button class="btn btn-primary square" id="print">
            <i class="fa fa-print">
            </i>
        </button>



        <!-- /marketing campaigns -->
    </div>
</div>












<script>
    $('#download').click(function(){
            let print = [];
            $('input[type="checkbox"]:checked').each(function(){
                    print.push($(this).attr('id'));
                })
            if (print.length > 0){
                $('[data-zip]').each((i,e)=>{
                        if (print.includes( e.cloneNode(true).getAttribute('data-zip') )) {
                            e.click();
                        }
                    })
            }else{
                alert("pls select some row");
            }
        })

    $('#print').click(function(){
            let print = [];
            $('input[type="checkbox"]:checked').each(function(){
                    print.push($(this).attr('id'));
                })
            if (print.length > 0){
            	
            	$('[data-print]').attr('download','download');
                $('[data-print]').each((i,e)=>{
                        if (print.includes( e.cloneNode(true).getAttribute('data-print') )) {
                            //open tab              
                            e.click();                
                        }
                    })
                $('[data-print]').removeAttr('download');
            }else{
                alert("pls select some row");
            }
        })
	
	$("#main").click(function(){
		
		  
		   $(".table-checkbox").prop('checked', $(this).prop('checked'));
   		
	})
</script>
<style>
    .square{
        width: 50px;
    }
</style>

