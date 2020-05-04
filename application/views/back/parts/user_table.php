<div class="content">
    <div class="row">
        <div class="col-lg-12">

            <!-- Marketing campaigns -->
            <div class="panel panel-flat">
                <div class="panel-heading" style="background-color:white; color:#105497; border:0px;">
                    <b>
                        <?= $title ?>
                    </b>

                    <div class="heading-elements">
                        <div class="row">
                            <?
                            if ($result_count && is_array($result_count)) :?>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= lang('number_of_records_per_page') ?>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="rows_count" style="width: 65px;">
                                            <? foreach($result_count as $numbers):?>
                                              <option><?= $numbers ?></option>
                                            <? endforeach ;?>
                                         
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <? endif ;?>

                            <?
                            if ($buttons) :?>
                            <?
                            foreach ($buttons as $link=>$text):?>

                            <div class="col-md-6">

                                <a  href="<?= $link?>" class="btn btn-primary" >
                                    <b>
                                        <?= lang($text) ?>
                                    </b>
                                </a>
                            </div>
                            <? endforeach ;?>

                            <? endif ;?>

                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <?
                                foreach (array_keys($fields) as $title):?>

                                <th class="col-md-2">
                                    <?= $title ?>
                                </th>

                                <? endforeach ;?>

                            </tr>
                        </thead>
                        <tbody>
                        
                       
                            <?
                            foreach ($query as $row) :?>
                          
                            <tr>
                                <?
                                foreach ($fields as $column=>$value): ?>
                                <td>
                                    
                                <? if($column == 'action'):?>
                                	
                                	<? foreach($value as $oneaction):?>
                                		<a href="<?= $link_to_controller.$oneaction.'/'.$row[$primary] ?>" class="text-muted">
                                        <i class="fas fa-<?= $oneaction ?>">
                                        
                                        </i>
                                   		 </a>
                                		 &nbsp;&nbsp;&nbsp;
                                	<? endforeach;?>
                                	
                                <? elseif ($column != 'action' && is_array($value)) :?>
                                	<? foreach($value as $onecolumn):?>
                                		<?= $row[$onecolumn]?>
                                	<? endforeach;?>
                                	
                                	
                                <? else :?>
                                 <span class="text-muted">
                                 
                                        <?= $row[$value]; ?>
                                 </span>
                                <? endif; ?>
                                   
                                </td>

                                <? endforeach;?>
                            </tr>
                            <? endforeach ;?>


                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /marketing campaigns -->
        </div>
    </div>


</div>


<script>
	$("#rows_count").change(function(){
		 //alert( this.value );
		 
		 location.reload('<?= $link_to_controller ?>')
	})

</script>