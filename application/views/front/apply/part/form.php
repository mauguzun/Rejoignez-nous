
<?
foreach($control as $value) :?>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js">
</script>
<script src="<?= base_url()?>css/locales/bootstrap-datepicker.<?= $this->session->userdata('lang') ?>.min.js" >
	</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" />


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