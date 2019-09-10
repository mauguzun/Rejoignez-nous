<div class="col-md-8 info">

    <div class="inner-info">
        <h3>

            <?= $title?>
        </h3>
        <p class="sub-string" style="margin-bottom:10px;margin-top:10px;">
        <?= lang('in_law');?>
        </p>


<?
if(isset($_GET['q'])):?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
	<strong><?= lang('some_important_infomation')?></strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<? endif;?>

        <?
        if (isset($table)) :?>
        <div class="inner-info">
            <?= $table ?>
        </div>

        <? endif ;?>


        <?php echo form_open_multipart($url,['id'=>'form']);?>
        <div class="row">
            <div class="col-md-12">


                <?
                foreach ($control as $value) :?>
                <div class="form-group">

                    <?= $value ?>
                </div>

                <? endforeach;?>

                <span id="hidden">
                    <?
                    if (isset($hidden_select_selected) && $hidden_select_selected != $hidden_select_value  ) : ?>
                    <?= $hidden ;?>
                    <? endif ;?>
                </span>
            </div>
        </div>
        <button class="btn btn-outline-success my-2 my-sm-0 my-button" type="submit" style="float: right;">
            <?= lang('save')?>
        </button>
        
        

        <?php echo form_close();?>
        
        <? if(isset($delete_account)) :?>
        
        <br />
        <br />
       
       <?= $delete_account ?>
        <? endif ?>
    </div>
</div>





<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/sum">
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js">
</script>
<script src="<?= base_url()?>css/locales/bootstrap-datepicker.<?= $this->session->userdata('lang') ?>.min.js" >
	</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" />




<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js">
</script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>

<script>


    $('*[data-form-url]').click(function(){

            let $form = $('#form');
            $form.attr('action',$(this).attr('data-form-url'));

            var validator = $form.validate(options);
            if (validator.form()) {
                $form.submit();
            }
        })

    <? if (isset($hidden) && isset($hidden_select_value)) :?>
    $('*[data-hidden]').change(function(){

            if($(this).val() != "<?= $hidden_select_value ?>"){
                $("#hidden").html('<?= isset($hidden)?str_replace("\n","",$hidden):NULL;?>') ;
            }else{
                $("#hidden").html("") ;
            }

        })
    <? endif ;?>

    $('*[data-calendar]').datepicker({
            todayBtn: "linked",
            clearBtn: true,
            daysOfWeekHighlighted: [6,0],
            autoclose: true,
            format: 'dd/mm/yyyy',
            weekStart:1,
            language: "<?= $this->session->userdata('lang') ?>"
        });

    /* $('textarea').summernote({
    maxTextLength:2500
    });*/

</script>