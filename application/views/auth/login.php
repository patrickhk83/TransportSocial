<style type="text/css">
	.ui-dialog {font-family:Arial; font-size:12px;}

</style>
<script type="text/javascript">
	$(document).ready(function()
	{
		enable_user_dialog("<?php echo site_url("$controller_name/signup_user");?>" , "<?php echo base_url("assets/images/default-profile-pic.png");?>" , 0);
		document.getElementById('files1').addEventListener('change' , handleFileSelect1 , false);
		document.getElementById('files2').addEventListener('change' , handleFileSelect2 , false);
		document.getElementById('files3').addEventListener('change' , handleFileSelect3 , false);
		document.getElementById('files4').addEventListener('change' , handleFileSelect4 , false);
		document.getElementById('files5').addEventListener('change' , handleFileSelect5 , false);
	});

</script>

<p><?php echo lang('login_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/login");?>

  <div class="form-group">
    <?php echo lang('login_identity_label', 'identity');?>
    <?php echo form_input($identity);?>
  </div>

  <div class="form-group">
    <?php echo lang('login_password_label', 'password');?>
    <?php echo form_input($password);?>
  </div>

  <div class="form-group">
    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"')?>
  </div>


  <div class="form-group">
    <input type="submit" class="btn btn-primary" value="Login">
    <input type="button" class="btn btn-primary" value="Sign up" id="signup_btn" name="signup_btn" data-toggle="modal">
  </div>

<?php echo form_close();?>

<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>

<?php
	$data['countries'] = $countries;
	$data['controller_name'] = $controller_name;
	$this->load->view("auth/create_user" , $data);

?>
