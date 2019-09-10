<div class="col-md-8 info">
            <div class="inner-info" style="padding-bottom: 20px !important; margin-bottom:30px;">
                <h4><?php echo lang('email_forgot_password_link') ;?></h4>
                 <p class="sub-string" style="margin-top:30px;"><?php echo lang('edit_user_subheading');?>
            </p>
             <div class="form-group">
             
             
<?php echo form_open(uri_string());?>
                        <label for="exampleInputPassword1">*<?php echo lang('create_user_validation_password_label', 'password');?> </label>
                        <?php echo form_input($old_password);?>
                      </div>
                       <div class="form-group">
                        <label for="exampleInputPassword1">* <?php echo lang('edit_user_password_label', 'password');?> <br /></label>
                        <?php echo form_input($password);?>
                      </div>
                       <div class="form-group">
                        <label for="exampleInputPassword1">* <?php echo lang('edit_user_password_confirm_label', 'password');?> <br /></label>
                       <?php echo form_input($password_confirm);?>
                      </div>
                      <br>
                      <button class="btn btn-outline-success my-2 my-sm-0 my-button my-button" type="submit"><?=  lang('edit_user_submit_btn') ?></button>
            </div>
            
             <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

   
           
            
            
        </div>