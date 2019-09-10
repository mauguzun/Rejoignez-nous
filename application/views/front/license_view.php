
<script src="<?= base_url()?>css/locales/bootstrap-datepicker.<?= $this->session->userdata('lang') ?>.min.js" >
	</script>
<div class="col-md-8 info">

    <div class="inner-info">
        <h3>
            <?= $title ?>
        </h3>
        <p class="sub-string" style="margin-bottom:10px;margin-top:10px;">
<?= lang('in_law')?>
        </p>

        <?
        if (isset($special_buttons)) :?>
        <div class="dropdown"  style="width: 100%;">
            <button class="btn btn-secondary " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= lang('other_options') ?>
                <span class="badge">
                    <?= count($special_buttons) ?>
                </span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                <?
                foreach ($special_buttons as $key=>$value):?>
                <a  href="<?= base_url().'user/'.$key?>" class="dropdown-item"  >
                    <?= lang($value) ?>
                </a>

                <? endforeach ; ?>
            </div>
        </div>
        <? endif;?>
        <br><br><br>




        <?php echo form_open_multipart($url,['id'=>'form']);?>
        <div class="row">
            <div class="col-md-12">

               

                <br /><br /><br />
                <?
                foreach (['cpl','atpl','irme'] as $index ):?>


                <div style="margin-bottom:10px;border-bottom:1px silver dotted;" class="custom-control custom-checkbox mr-sm-2">
                    <input

                    <?= isset($query["{$index}_end"]) ? 'checked' : null ;?>
                    data-name="<?= $index?>" value="1"  id="_<?= $index ?>"  type="checkbox" class="custom-control-input con" id="1">
                    <label  class="custom-control-label" for="_<?= $index ?>">
                        <b>
                            <?= $index?> <?= lang('section')?>
                        </b>
                    </label>
                </div>





                <input data-calendar="true"  placeholder="start"  value="<?= isset($query["{$index}_start"]) ? $query["{$index}_start"] : ""  ?>"   id="<?= $index?>_start"  type="text"  class="form-control"/>
                <br />
                <input  data-calendar="true" value="<?= isset($query["{$index}_end"]) ? $query["{$index}_end"] : ""  ?>"  id="<?= $index?>_end"  type="text" placeholder="end" class="form-control"/>

                <br /><br />
                <?
                if ($index == 'cpl') :?>
                <strong>
                    <?= lang('mcc_theoretical_atpl_subheader')?>
                </strong>
                <br />
                <?
                foreach (['mcc','theoretical_atpl'] as $ad):?>
                <div class="custom-control custom-checkbox mr-sm-2">
                    <input  <?= isset($query[$ad]) && $query[$ad] == 1 ?  "checked" : null  ?>   value="1" name="<?= $ad ?>"  type="checkbox" class="custom-control-input" id="<?= $ad?>">
                    <label class="custom-control-label" for="<?= $ad?>">
                        <?= lang($ad) ?>
                    </label>
                </div>
                <? endforeach; ?>
                <br />    <br />
                <? endif ;?>



                <? endforeach ?>

            </div>
        </div>
         <b id="error" style="color: red;margin-bottom:20px;width: 100%;display: block;">
                </b>

        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="float: right;">
            <?= lang('save')?>
        </button>

        <?php echo form_close();?>
    </div>
</div>





<!-- include summernote css/js -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/sum">
</script>

<script src="<?= base_url()?>css/locales/bootstrap-datepicker.<?= $this->session->userdata('lang') ?>.min.js" >
	</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js">
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" />






<script>

    let checkme = {
        cpl : false,atpl : false,irme : false
    };

    let pickers = ["start","end"];

    $('.con:checkbox:checked').each(function(){
            let name =$(this).attr('data-name');
            checkme[name] = true;
            pickers.forEach(el=>{

                    let elementname = "#" + name + "_" + el ;
                    $(elementname).attr('required','required')
                    $(elementname).attr('name', name + "_" + el );
                })
        })


    $error = $("#error");
    $('form').submit(function(){


            if(checkme.cpl == true && checkme.irme == false && checkme.atpl == false){
                if ($('#mcc').is(':checked') == false && $('#theoretical_atpl').is(':checked') == false){
                    $error.text('<?= lang("You must have obtained the theoretical ATPL and / or the MCC in order to practice the profession to which you are applying")?>');
                   // $('html, body').animate({ scrollTop: error.offset().top }, 'slow');

                    return false;
                }
            }
            else if (checkme.irme == true && checkme.cpl == false && checkme.atpl == false){
                $error.text('<?= lang("You must have obtained the IRME to be able to practice the profession to which you are applying")?>')
              // $('html, body').animate({ scrollTop: error.offset().top }, 'slow');
                return false;
            }
            else if (checkme.irme == false && checkme.cpl == false && checkme.atpl == true){
                $error.text('<?= lang("You must have obtained CPL or ATPL to be able to practice the profession to which you are applying")?>')
               // $('html, body').animate({ scrollTop: error.offset().top }, 'slow');
                return false;
            }
            else if (checkme.irme == false && checkme.cpl == false && checkme.atpl == false){
                $error.text('<?= lang("You must select one of option")?>')
                 //$('html, body').animate({ scrollTop:  $("#error").offset().top }, 'slow');
                return false;
            }


        })



    $('.con').click(function(){

            let name = $(this).attr('data-name');
            checkme[name] = !checkme[name]

            console.log(name)

            if($(this).is(':checked')){
                pickers.forEach(el=>{

                        let elementname = "#" + name + "_" + el ;
                        $(elementname).attr('required','required')
                        $(elementname).attr('name', name + "_" + el );
                    })
            }else{
                pickers.forEach(el=>{
                        let elementname = "#" + name + "_" + el + "";
                        $(elementname).val(' ');
                        $(elementname).removeAttr('name' );
                    })
            }

        })



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