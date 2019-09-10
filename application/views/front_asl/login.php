
<div id="content" role="main">


    <div class="breadcrumbs eap-breadcrumbs">
        <a href="<?= base_url()?>" >
            <span>
                <?= lang('Careers') ?>
            </span>
        </a>  &gt;
        <a href="#" >
            <span class="current-page">
             
                    <?php echo lang('login_heading');?>

                </span>
            
        </a>
    </div>
    <h1 class="post-title">
        <?php echo lang('login_heading');?>
    </h1><br>

    <!--
    <? if (isset($message)) :?>
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-info-circle">
        </i>
       <? echo $message;?>
    <!--</div>
    <?
   // else :?>-->

    <div class="alert alert-primary" role="alert">
        <i class="fas fa-info-circle">
        </i>
        <? echo lang('login_subheading');?>
    </div>

<!--    <?endif ; ?>
-->
    <?php echo form_open("auth/login",[ "style"=>"margin-bottom: 270px"]);?>
    <div class="form-group">


        <?php echo form_input($identity);?>

    </div>
    <div class="form-group">

        <?php echo form_input($password);?>
    </div>


    <div class="form-group">

        <a href="forgot_password">
            <?php echo lang('login_forgot_password');?>
        </a>
    </div>

    <div class="form-group">
        <button class="btn btn-primary" type="submit" style="padding-left:20px; padding-right:20px;">
            <?= lang('login_submit_btn')?>
        </button>

    </div>

    <div class="form-group">
        <a href="<?= base_url() ?>auth/create_user">
            <?= lang('index_create_user_link')?>
        </a>
    </div>
    <?php echo form_close();?>






</div><!-- #content -->
<div id="sidebar-right">
</div>
</div><!-- #primary -->