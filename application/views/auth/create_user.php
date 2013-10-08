<div id="dialog_form" title="Sign Up Now For a Account" style="font-family:Arial; font-size:12px;">
	<?php echo form_open('#' , array('id'=>'customer_form'));?>
		<div id="required_fields_message"><?php echo lang('create_user_fields_required_message'); ?></div>
		<ul id="error_message_box"></ul>
		<fieldset id="user_login_info">
<!-- 		<legend><?php echo lang("create_user_login_info"); ?></legend>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_user_name') , 'username',array('class'=>'required')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'username' , 'id' => 'username' , 'value' => ''));?></div>
			</div>
-->
			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_fname_label') , 'fname',array('class'=>'required')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'fname' , 'id' => 'fname' , 'value' => ''));?></div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_lname_label') , 'lname',array('class'=>'required')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'lname' , 'id' => 'lname' , 'value' => ''));?></div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_email_label') , 'email' , array('class'=>'required')); ?>
				<div class='form_field'>
					<?php echo form_input(array('name' => 'email' , 'id' => 'email' , 'value' => '')); ?>
				</div>
			</div>

			<?php $password_label_attributes = array('class'=>'required' , 'id' => 'label_password'); ?>
			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_password_label') , 'password',$password_label_attributes); ?>
				<div class='form_field'><?php echo form_password(array('name'=>'passwords' , 'id'=>'passwords'));?></div>
			</div>

			<?php $repeat_password_label_attributes = array('class'=>'required' , 'id' => 'label_repeat_password'); ?>
			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_password_confirm_label') , 'repeat_password',$repeat_password_label_attributes); ?>
				<div class='form_field'><?php echo form_password(array('name'=>'repeat_password' , 'id'=>'repeat_password'));?></div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_user_location') , 'country',array('class'=>'required')); ?>
				<div class='form_field'>
					<select class="form-control" name="country" id="country" style="width:142px;">
						<option value="">Select country</option>
						<?php
							foreach($countries as $country)
							{
								echo "<option value='".$country->country_code."'>".$country->country_name."</option>";
							}
						?>
					</select>
				</div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_birthday') , 'birthday',array('class'=>'wide')); ?>
				<div class='form_field' data-date-format="d-m-yyyy">
					<?php echo form_input(array('name'=>'birthday' , 'id'=>'birthday' , 'placeholder'=>'dd-mm-yyyy' , 'readonly'=>'true' , 'value'=>''));?>
				</div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_occupation') , 'occupation',array('class'=>'wide')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'occupation' , 'id' => 'occupation' , 'value' => ''));?></div>
			</div>
		</fieldset>

		<fieldset  id="user_optional_info">
			<!-- <legend><?php echo lang("create_user_optional_info"); ?></legend> -->

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_about_me') , 'about_me',array('class'=>'wide')); ?>
				<div class='form_field'>
					<?php echo form_textarea(array('name'=>'about_me' , 'id'=>'about_me' , 'value'=>'' , 'rows'=>'7' , 'cols'=>'20'));?>
				</div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_hobbies') , 'hobbies',array('class'=>'wide')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'hobbies' , 'id' => 'hobbies' , 'value' => ''));?></div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_music') , 'musics',array('class'=>'wide')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'musics' , 'id' => 'musics' , 'value' => ''));?></div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_movies') , 'movies',array('class'=>'wide')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'movies' , 'id' => 'movies' , 'value' => ''));?></div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_books') , 'books',array('class'=>'wide')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'books' , 'id' => 'books' , 'value' => ''));?></div>
			</div>
<!--
			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_skype') , 'skype',array('class'=>'wide')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'skype' , 'id' => 'skype' , 'value' => ''));?></div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_facebook') , 'facebook',array('class'=>'wide')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'facebook' , 'id' => 'facebook' , 'value' => ''));?></div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_twitter') , 'twitter',array('class'=>'wide')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'twitter' , 'id' => 'twitter' , 'value' => ''));?></div>
			</div>

			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_linkedIn') , 'linkedIn',array('class'=>'wide')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'linkedIn' , 'id' => 'linkedIn' , 'value' => ''));?></div>
			</div>


			<div class="field_row clearfix">
				<?php echo form_label(lang('create_user_google') , 'google',array('class'=>'wide')); ?>
				<div class='form_field'><?php echo form_input(array('name' => 'google' , 'id' => 'google' , 'value' => ''));?></div>
			</div>
 -->
		</fieldset>
		<input type="hidden" id="person_id" value="0">
	<?php echo form_close();?>
</div>