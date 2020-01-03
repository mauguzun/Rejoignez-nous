
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css"
/>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js">
</script>


<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js">
</script>

<div class="col-lg-12">

    <!-- Marketing campaigns -->
    <div class="panel panel-flat">
        <div class="panel-heading" style="background-color:white; color:#105497; border:0px;">
            <h6 class="panel-title">
                <b>
                    <?php echo $title;?>
                </b>

            </h6>
        </div>
        <?php echo form_open_multipart($url,['id'=>'form']);?>
        <div class="table-responsive">
            <div class="col-md-12">

                <div class="row">
                    <br>
                    <?
                    foreach ($control as $key => $value) :?>
                    <div class="col-md-12">

                        <div class="form-group">
                            <?= $value ?>

                        </div>
                        <div style="color:red;text-align:center;"  data-error="<?=  $key ?>" class="col-md-12">

                        </div>
                    </div>
                    <? endforeach ;?>


                </div>

            </div>
        </div>



        <div class="panel-heading" style="background-color:white; color:#105497; border:0px;">
            <br>
            <div id="up_error" class="error">

            </div>

            <div class="heading-elements">

                <?
                foreach ($buttons as $text=>$url):?>

                <button data-form-url="<?= $url ?>"  class="btn btn-primary" >
                    <b>
                        <?= lang($text) ?>
                    </b>
                </button>&nbsp;&nbsp;
                <? endforeach ?>





                <?
                if (isset($cancel)) :?>

                <a href="<?= $cancel ?>" class="btn btn-primary" >
                    <b>
                        <?= lang('cancel') ?>
                    </b>
                </a>&nbsp;&nbsp;

                <? endif ?>

            </div>
            <br>
        </div>
        <?php echo form_close();?>
    </div>
</div>



<?
if (isset($required)) :?>
<script>

    /*
    var required = <?php echo json_encode($required); ?>;
    console.log(required)*/;
setSumer();
				
	
    $('form').submit(function(){
            var required = <?php echo json_encode($required); ?>;
            console.log(required);
            for(let i in required){
                if($("#"+required[i]).val().length < 2){

				
                    $('[data-error="'+required[i]+'"]').html('required')
                    $('html, body').animate({ scrollTop: $('[data-error="'+required[i]+'"]').offset().top }, 'slow');
                    return false;
                }

            }

        })


</script>
<? endif; ?>