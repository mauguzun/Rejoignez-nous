<select class="form-control" id="fake_<?= $name ?>"  name="fake_<?= $name ?>" id="<?= $name?>">



    <?
    foreach ($options as $key=>$value):?>
    <option value="<?= $key?>">
        <?= $value ?>
    </option>
    <? endforeach;?>

</select>

<br />
<input id="<?= $name ?>" value="<?= (isset($default)) ? $default: NULL ;?>" hidden="true" data-calendar="true" name="<?= $name ?>" data-calendar="true" class="form-control"  />




<script>

    $('#fake_<?= $name ?>').change(function(){
            let value = $(this).val();
            let data_input = $('#<?= $name ?>');

           

            if(value == 0){
                data_input.removeAttr('hidden');
            }else{
                data_input.attr('value',value);
                data_input.attr('hidden','true');
            }

        })




</script>