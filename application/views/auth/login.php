<style type="text/css">
	.ui-dialog {font-family:Arial; font-size:12px;}

</style>
<script type="text/javascript">
	$(document).ready(function()
	{
		enable_user_dialog("<?php echo site_url($this->router->fetch_class().'/signup_user');?>" , "<?php echo base_url("assets/images/default-profile-pic.png");?>" , 0);
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
    <a href="/auth/login" class="btn btn-primary" data-toggle="modal" data-target="#dialog_form" data-remote="false">Sign Up</a>
  </div>

<?php echo form_close();?>

<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>