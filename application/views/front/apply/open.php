<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js">
</script>
<script src="http://careers.aslairlines.com/css/locales/bootstrap-datepicker.en.min.js">
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css">



<div id="content" role="main">




<div class="breadcrumbs eap-breadcrumbs">
    <a href="<?= base_url()?>" >
        <span>
            <?= lang('Careers') ?>
        </span>
    </a>  &gt;
    <a href="<?= base_url().'offers' ?>" >
        <span >
            <?= lang('our_offers') ?>
        </span>
    </a>  &gt; 

    <a href="#" >
        <span class="current-page">
            <?= $title  ?>
        </span>
    </a>



</div>
<h1 class="post-title">
    <?= $title?>
</h1>


<div class="custom_offer_bg">


<?
if (isset($_GET['q'])):?>
<div class="alert alert-danger" role="alert">
    <i class="fas fa-info-circle">
    </i>
    <?= lang('some_important_infomation')?>

</div>
<? endif;?>


<?
if (isset($message)) :?>
<div class="alert alert-danger" role="alert">
    <i class="fas fa-info-circle">
    </i>
    <?php echo $message;?>
</div>
<?
else :?>

<!--<div class="alert alert-primary" role="alert"><i class="fas fa-info-circle"></i>
<?= lang('in_law');?>
</div>-->

<? endif ; ?>


<?
if (isset($app) && $app && $app['filled'] == 1 ) :?>

<div class="alert alert-success"  >
    <i class="fas fa-info-circle">
    </i> <?= lang('you_are_applied')?>
</div>




<?
else :?>


<div class="alert alert-primary"  style="background-color:#fef2cd" >
    <i class="fas fa-info-circle">
    </i> <?= lang('press_save_to_progres')?>
</div>


<? endif ; ?>


<?
if (isset($app) && $app && $app['filled'] == 1 ) :?>

<a class="btn btn-primary"  href="<?= $printme ?>" role="button">
    <i class="fa fa-print">
    </i> <?= lang('print')?>
</a>
<? endif ; ?>

<h5 align=center>
    <label style="font-size: 25px;" >
        <?= lang(strtolower($step)) ?>
    </label>

</h5>
<div class="modal-header">
    <?
    foreach ($pagination as $key=>$value) :?>
    <?= $value ?>
    <? endforeach ;?>

</div>



<br>
<form method="post" class="AVAST_PAM_nonloginform">