

            <div class="inner-info register_screen" style="padding-bottom: 20px !important; margin-bottom:30px; max-width:500px;">
                <h4>
                    <?php echo lang('forgot_password_heading');?>
                </h4>
                <br>
                	<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
                
               <?php echo form_open("auth/forgot_password");?>
                <div class="form-group">
                    <?php echo form_input($identity);?>
                </div>
                

                <br>
                <center>
                    <button class="btn btn-outline-success my-2 my-sm-0 my-butto"  type="submit">
                        <?= lang('forgot_password_submit_btn'); ?>
                    </button>
                </center>

               
            