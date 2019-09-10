<div class="col-md-8 info">
    <div class="inner-info" style="padding-bottom: 0px !important; margin-bottom:30px;">
        <h4>
            <?= lang('some_important_infomation')?>
        </h4>
        <b class="sub-string" >
        	<?= lang('some_header') ?>
        </b>
		<br />
		<br />
		<br />
		<? foreach($messages as $value): ?>
        <div class="row">
            <div class="col-md-12">
                <p class="sub-string" style="margin-top:10px;">
					<?= $value ?>
                </p>
            </div>
        </div>
        
        <? endforeach ;?>
       

    </div>



</div>