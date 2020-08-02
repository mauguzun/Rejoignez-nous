
<div id="content" role="main">
    <div class="breadcrumbs eap-breadcrumbs">
        <a href="<?= base_url()?>" >
            <span>
                <?= lang('Careers') ?>
            </span>
        </a>&gt;
        <a href="<?= base_url().'auth/login' ?>" >
            <span>
                <?php echo lang('login') ;?>
            </span>&gt;
        </a>
        <a href="#" >
            <span class="current-page" style="color: #484848 !important;">
                <?php echo lang('email_forgot_password_link') ;?>
                <span>
                </span>
            </span>
        </a>
    </div>
    <h1 class="post-title">
        <?php echo lang('email_forgot_password_link') ;?>
    </h1><br>
    <div class="alert alert-primary" role="alert">
        <i class="fas fa-info-circle">
        </i>
        <?php echo lang('edit_user_subheading');?>
    </div><br>
    <?php echo form_open(uri_string());?>

    <div class="form-group">
        <label for="exampleInputEmail1">
            <?php echo lang('create_user_validation_password_label', 'password');?>
        </label>
        <?php echo form_input($old_password);?>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">
            * <?php echo lang('edit_user_password_label', 'password');?> <br />
        </label>
        <?php echo form_input($password);?>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">
            * <?php echo lang('edit_user_password_confirm_label', 'password');?> <br />
        </label>
        <?php echo form_input($password_confirm);?>
    </div>
    <br>

    <br>

    <div class="form-group">
        <button class="btn btn-primary" type="submit" style="padding-left:20px; padding-right:20px;">
            Update
        </button>

    </div>

    </form>





</div><!-- #content -->
</div><!-- #primary -->