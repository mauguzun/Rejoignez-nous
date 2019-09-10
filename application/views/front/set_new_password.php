

            <div class="inner-info register_screen" style="padding-bottom: 20px !important; margin-bottom:30px; max-width:500px;">
               
               

                <h4>
                    <?php echo lang('reset_password_heading');?>
                </h4>
                <br>
                <?php echo form_open('auth/reset_password/' . $code);?>
                <div class="form-group">
                    <?php echo form_input($new_password);?>
                </div>
                <div class="form-group">
                    <?php echo form_input($new_password_confirm);?>
                </div>
               
               	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>
                <br>
               
                    <button class="btn btn-outline-success my-2 my-sm-0 my-button"  type="submit">
                        <?= lang('reset_password_submit_btn') ?>
                    </button>


              
                <?php echo form_close();?>
                
            </div>






      
</html>