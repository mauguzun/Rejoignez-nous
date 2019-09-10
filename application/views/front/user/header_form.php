
<div id="content" role="main">


<div class="breadcrumbs eap-breadcrumbs">
    <a href="<?= base_url()?>" >
        <span>
            <?= lang('Careers') ?>
        </span>
    </a>  &gt;
    <a href="#" >
        <span class="current-page"> <?= $title?><span>
    </a> 
</div>
<h1 class="post-title">
    <?= $title?>
</h1>






<?
if (isset($message)) :?>
<div class="alert alert-danger" role="alert">
    <i class="fas fa-info-circle">
    </i>
    <?php echo $message;?>
</div>
<?
else :?>

<div class="alert alert-primary" role="alert">
    <i class="fas fa-info-circle">
    </i>
    <?= lang('in_law');?>
</div>

<? endif ; ?>


<?
if (isset($_GET['q'])):?>

<div class="alert alert-danger" role="alert">
    <i class="fas fa-info-circle">
    </i>
    <?= lang('some_important_infomation')?>
</div>

<? endif;?>


<?
if (isset($table)) :?>
<div class="inner-info">
    <?= $table ?>
</div>

<? endif ;?>


<?php echo form_open_multipart($url,['id'=>'form']);?>

