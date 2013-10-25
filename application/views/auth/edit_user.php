<?php echo form_open_multipart(site_url($this->router->fetch_class()."/edit_user/".$user->id) , array('id'=>'customer_form'));?>
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
                            <?php echo form_input(array('class' => 'form-control', 'class' => 'form-control', 'name' => 'first_name' , 'id' => 'first_name' , 'value' => set_value('first_name', $user->first_name)));?>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_lname_label') , 'lname',array('class'=>'required')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'last_name' , 'id' => 'last_name' , 'value' => set_value('last_name', $user->last_name)));?>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_email_label') , 'email' , array('class'=>'required')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'email' , 'id' => 'email' , 'value' => set_value('email', $user->email))); ?>
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
                                <option>Select a Country</option>
                                <?php foreach($countries as $country): ?>
                                    <option value="<?php echo $country->country_code; ?>" <?php set_select('country', $country->country_code, ($country->country_code == $user->country)); ?>><?php echo $country->country_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_birthday') , 'birthday',array('class'=>'wide')); ?>
                            <div class="input-group date" data-date-format="d-m-yyyy">
                              <input type="text" placeholder="dd-mm-yyyy" class="form-control date" id="birthday" name="birthday" value="<?php echo set_value('birthday', $user->birthday); ?>" readonly="">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_occupation') , 'occupation',array('class'=>'wide')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'occupation' , 'id' => 'occupation' , 'value' => set_value('occupation', $user->occupation)));?>
                        </div>
                    </fieldset>
                    <fieldset class="col-md-6">
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_about_me') , 'about_me',array('class'=>'wide')); ?>
                            <?php echo form_textarea(array('class' => 'form-control', 'name' => 'about_me' , 'id'=>'about_me' , 'value'=>'' , 'rows'=>'7' , 'cols'=>'20'));?>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_hobbies') , 'hobbies',array('class'=>'wide')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'hobbies' , 'id' => 'hobbies' , 'value' => set_value('hobbies', $user->hobbies)));?>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_music') , 'musics',array('class'=>'wide')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'musics' , 'id' => 'musics' , 'value' => set_value('musics', $user->musics)));?>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_movies') , 'movies',array('class'=>'wide')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'movies' , 'id' => 'movies' , 'value' => set_value('movies', $user->movies)));?>
                        </div>
                        <div class='form-group'>
                            <?php echo form_label(lang('create_user_books') , 'books',array('class'=>'wide')); ?>
                            <?php echo form_input(array('class' => 'form-control', 'name' => 'books' , 'id' => 'books' , 'value' => set_value('books', $user->books)));?>
                        </div>
                    </fieldset>
                </div>
                <fieldset  id="user_photo_info">
                    <legend><?php echo lang("create_user_my_photo_info"); ?></legend>
                    <label class="radio-inline">
                    <input type="radio" name="radio1" value="1" checked>Profile Pic
                    </label>
                    <div class="row">
                        <div class="col-md-6 file-wrapper">
                            <span class="btn btn-success fileinput-button"  >
                                <span class="fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Browse...</span>
                                    <input type="file" class="profile-pic" name="profile-pic" id="profile-pic">
                                </span>
                            </span>
                        </div>
                        <img class="thumb" src="<?php echo $profile_pic; ?>">
                    </div>
                </fieldset>
                <?php echo form_hidden('id', $user->id);?>
                <?php echo form_hidden($csrf); ?>
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
