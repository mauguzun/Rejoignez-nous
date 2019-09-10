
<? if($logined ) :?>

<div class="col-md-8 info " >
<?  endif ;?>

    <? foreach ($query as $value):?>
    
    <a href="<?= base_url().'offer/'.$value['id']?>" >
  	  <div class="inner-info block" style="padding-bottom: 0px !important; margin-bottom:30px;">
        <h6>
            <?= $value['title']?>
            
            <? if(isset($applications) && is_array($applications) && in_array($value['id'],$applications)):?>
             
             
           <!--  <span class="badge badge-dark"><?= lang('you_are_applied')?></span>-->
            <? endif; ?>
        </h6>
        <div class="row">
            <div class="col-md-3">
                <p class="sub-string" style="margin-top:10px;">
                    <?= $value['start_date']?>
                </p>
            </div>
            <div class="col-md-9">
                <p class="sub-string" style="margin-top:10px;">
                    <?= $value['location']?>
                </p>
            </div>

        </div>
        
    </div>

	</a>
    <? endforeach ;?>
<? if($logined) :?>
</div>
<?  endif ;?>