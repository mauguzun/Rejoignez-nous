<div id="content" role="main">

    <div class="breadcrumbs eap-breadcrumbs">
        <a href="<?= base_url()?>" >
            <span>
                <?= lang('Careers') ?>
            </span>
        </a>  &gt;
        <a href="<?= base_url().'offers'?>" >
            <span  >
                <?= lang('our_offers') ?>
            </span>
        </a>  &gt;
        <a href="" >
            <span  class="current-page">
                <?= $query['title']?>
            </span>
        </a>  
    </div>
    <h1 class="post-title">
        <?= $query['title']?>
    </h1><br>
    <!--<h5 class="job_app_head">
        Info
    </h5>-->
    <div class="row">
        <div class="col-md-6">
            <?= lang('location')?> : <?= $query['location']?>
        </div>
        <div class="col-md-6">
            <?= lang('date')?>: <?= $query['pub_date']?>
        </div>
    </div><br>
    <?
    if ($query['type'] != 2) :?>
    <div class="row">
        <div class="col-md-12">
            <?= lang('period')?> :<?= $query['period']?>
        </div>
    </div>
    <? endif ;?>
    <br>
    <br>
    <h5 class="job_app_head">
        <?= lang('mission')?>
    </h5>
    <p style="line-height: 1.3;">
        <?= $query['mission']?><br>
    </p><br>

    <h5 class="job_app_head">
        <?= lang('profile')?>
    </h5>
    <?= $query['profile']?>
    <br>


    <br>
    <center>
        <a href="<?= $url?>">
            <button type="button" class="btn btn-primary btn-lg">
                <?= lang('apply')?>
            </button>
        </a>
    </center>
    <br>






</div><!-- #content -->
<div id="sidebar-right">
</div>
</div><!-- #primary -->