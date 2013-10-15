		<?php echo form_open_multipart(site_url("$controller_name/signup_user") , array('id'=>'customer_form'));?>
<div id="dialog_form" class="modal fade"  role="dialog" style="font-family:Arial; font-size:12px;" aria-hidden="true">
	<div class="modal-dialog">

		<div class="modal-content">
			<div class="modal-header">
				<a class="close" data-dismiss="modal">x</a>
				<h4>Sign Up Now For a Account</h4>
			</div>
			<div class="modal-body" style="height:920px;">

					<div id="required_fields_message"><?php echo lang('create_user_fields_required_message'); ?></div>
					<ul id="error_message_box"></ul>
					<fieldset id="user_login_info">
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
								<select class="form-control" name="country" id="country" style="width:135px;">
									<option value=""></option>
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
							<div class='form_field'>
							    <div class="input-group date" data-date-format="d-m-yyyy">
									<?php
										echo form_input(array('name'=>'birthday' ,
																'id'=>'birthday' ,
																'placeholder'=>'dd-mm-yyyy' ,
																'readonly'=>'true' ,
																'value'=>'' ,
																'data-datepicker'=>'datepicker' , 'class'=>'form-control'));
									?>
      							</div>
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
					<fieldset  id="user_photo_info">
						<legend><?php echo lang("create_user_my_photo_info"); ?></legend>
						<div class="field_row clearfix">
							<label class="radio-inline">
								<input type="radio" name="radio1" value="1" checked>Photo1
       						</label>
							<div class="fileupload-buttonbar">
								<div class="col-lg-7">
									<span class="btn btn-success fileinput-button" ng-class="{disabled: disabled}">
		 								<span class="fileinput-button">
											<i class="glyphicon glyphicon-plus"></i>
											<span>Browse...</span>
												<input type="file" name="files1" id="files1" ng-disabled="disabled">
										</span>
									</span>
								</div>
							</div>
							<div id="list1">
								<img class="thumb" src="<?php echo base_url("assets/images/default-profile-pic.png");?>">
							</div>
						</div>
						<div class="field_row clearfix">
							<label class="radio-inline">
								<input type="radio" name="radio1" value="2">Photo2
       						</label>
       						<div class="fileupload-buttonbar">
								<div class="col-lg-7">
									<span class="btn btn-success fileinput-button" ng-class="{disabled: disabled}">
		 								<span class="fileinput-button">
											<i class="glyphicon glyphicon-plus"></i>
											<span>Browse...</span>
												<input type="file" name="files2" id="files2" ng-disabled="disabled">
										</span>
									</span>
								</div>
							</div>
							<div id="list2">
								<img class="thumb" src="<?php echo base_url("assets/images/default-profile-pic.png");?>">
							</div>
						</div>

						<div class="field_row clearfix">
							<label class="radio-inline">
								<input type="radio" name="radio1" value="3">Photo3
       						</label>
							<div class="fileupload-buttonbar">
								<div class="col-lg-7">
									<span class="btn btn-success fileinput-button" ng-class="{disabled: disabled}">
		 								<span class="fileinput-button">
											<i class="glyphicon glyphicon-plus"></i>
											<span>Browse...</span>
												<input type="file" name="files3" id="files3" ng-disabled="disabled">
										</span>
									</span>
								</div>
							</div>
							<div id="list3">
								<img class="thumb" src="<?php echo base_url("assets/images/default-profile-pic.png");?>">
							</div>
						</div>

						<div class="field_row clearfix">
							<label class="radio-inline">
								<input type="radio" name="radio1" value="4">Photo4
       						</label>
							<div class="fileupload-buttonbar">
								<div class="col-lg-7">
									<span class="btn btn-success fileinput-button" ng-class="{disabled: disabled}">
		 								<span class="fileinput-button">
											<i class="glyphicon glyphicon-plus"></i>
											<span>Browse...</span>
												<input type="file" name="files4" id="files4" ng-disabled="disabled">
										</span>
									</span>
								</div>
							</div>
							<div id="list4">
								<img class="thumb" src="<?php echo base_url("assets/images/default-profile-pic.png");?>">
							</div>
						</div>

						<div class="field_row clearfix">
							<label class="radio-inline">
								<input type="radio" name="radio1" value="5">Photo5
       						</label>
							<div class="fileupload-buttonbar">
								<div class="col-lg-7">
									<span class="btn btn-success fileinput-button" ng-class="{disabled: disabled}">
		 								<span class="fileinput-button">
											<i class="glyphicon glyphicon-plus"></i>
											<span>Browse...</span>
												<input type="file" name="files5" id="files5" ng-disabled="disabled">
										</span>
									</span>
								</div>
							</div>
							<div id="list5">
								<img class="thumb" src="<?php echo base_url("assets/images/default-profile-pic.png");?>">
							</div>
						</div>

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
		<?php echo form_close();?>
