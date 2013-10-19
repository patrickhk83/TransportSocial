<?php echo form_open_multipart(site_url("$controller_name/signup_user") , array('id'=>'customer_form'));?>
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
                    <fieldset class="col-md-6">
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_fname_label') , 'fname',array('class'=>'required')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'class' => 'form-control', 'name' => 'fname' , 'id' => 'fname' , 'value' => ''));?>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_lname_label') , 'lname',array('class'=>'required')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'lname' , 'id' => 'lname' , 'value' => ''));?>
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
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_user_location') , 'country',array('class'=>'required')); ?>
                            <select class="form-control" name="country" id="country">
                                <option value=""></option>
                                <?php
                                     foreach($countries as $country)
                                    {
                                        echo "<option value='".$country->country_code."'>".$country->country_name."</option>";
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_birthday') , 'birthday',array('class'=>'wide')); ?>
                            <div class="input-group date" data-date-format="d-m-yyyy">
                            	<input type="text" placeholder="dd-mm-yyyy" class="form-control" id="birthday" name="birthday" value="<?php echo set_value('birthday', date('j-n-Y')); ?>" readonly="">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_occupation') , 'occupation',array('class'=>'wide')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'occupation' , 'id' => 'occupation' , 'value' => ''));?>
                        </div>
                    </fieldset>
                    <fieldset class="col-md-6">
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_about_me') , 'about_me',array('class'=>'wide')); ?>
                            <?php echo form_textarea(array('class' => 'form-control', 'name' => 'about_me' , 'id'=>'about_me' , 'value'=>'' , 'rows'=>'7' , 'cols'=>'20'));?>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_hobbies') , 'hobbies',array('class'=>'wide')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'hobbies' , 'id' => 'hobbies' , 'value' => ''));?>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_music') , 'musics',array('class'=>'wide')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'musics' , 'id' => 'musics' , 'value' => ''));?>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_movies') , 'movies',array('class'=>'wide')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'movies' , 'id' => 'movies' , 'value' => ''));?>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_books') , 'books',array('class'=>'wide')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'books' , 'id' => 'books' , 'value' => ''));?>
                        </div>
                    </fieldset>
                </div>
                <fieldset  id="user_photo_info">
                    <legend><?php echo lang("create_user_my_photo_info"); ?></legend>
                    <?php foreach(range(1,5) as $i): ?>
                        <label class="radio-inline">
                        <input type="radio" name="radio1" value="1" checked>Photo<?php echo $i; ?>
                        </label>
                        <div class="row">
                            <div class="col-md-6">
                                <span class="btn btn-success fileinput-button" ng-class="{disabled: disabled}">
                                <span class="fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Browse...</span>
                                <input type="file" name="files<?php echo $i; ?>" id="files<?php echo $i; ?>" ng-disabled="disabled">
                                </span>
                                </span>
                            </div>
                            <div id="list<?php echo $i; ?>">
                                <img class="thumb" src="<?php echo base_url("assets/images/default-profile-pic.png");?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
                <input type="hidden" id="person_id" value="0">
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