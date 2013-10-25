<?php echo form_open_multipart(site_url($this->router->fetch_class()."/signup_user") , array('id'=>'customer_form'));?>
<div id="dialog_form" class="modal fade"  role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h4>Sign Up Now For a Account</h4>
            </div>
            <div class="modal-body">
                <div id="required_fields_message"><?php echo lang('create_user_fields_required_message'); ?></div>
                <ul id="error_message_box"></ul>
                    <div class="row">
                        <fieldset class="col-md-12">
                            <div class='form-group'>
                                <?php echo form_label(lang('create_user_fname_label') , 'first_name',array('class'=>'required')); ?>
                                <?php echo form_input(array('class' => 'form-control', 'class' => 'form-control', 'name' => 'first_name' , 'id' => 'first_name' , 'value' => ''));?>
                            </div>
                            <div class='form-group'>
                                <?php echo form_label(lang('create_user_lname_label') , 'last_name',array('class'=>'required')); ?>
                                <?php echo form_input(array('class' => 'form-control', 'name' => 'last_name' , 'id' => 'last_name' , 'value' => ''));?>
                            </div>
                            <div class='form-group'>
                                <?php echo form_label(lang('create_user_email_label') , 'email' , array('class'=>'required')); ?>
                                <?php echo form_input(array('class' => 'form-control', 'name' => 'email' , 'id' => 'email' , 'value' => '')); ?>
                            </div>
                            <div class='form-group'>
                                <?php echo form_label(lang('create_user_password_label') , 'password'); ?>
                                <?php echo form_password(array('class' => 'form-control', 'name'=>'passwords' , 'id'=>'passwords'));?>
                            </div>
                            <div class='form-group'>
                                <?php echo form_label(lang('create_user_password_confirm_label') , 'repeat_password'); ?>
                                <?php echo form_password(array('class' => 'form-control', 'name'=>'repeat_password' , 'id'=>'repeat_password'));?>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn" data-dismiss="modal" aria-hidden="true" value="Close">
                    <input type="button" class="btn btn-primary" value="Submit" id="submit_btn" name="submit_btn">
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close();?>
