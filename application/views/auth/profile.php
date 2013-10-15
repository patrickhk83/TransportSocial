<style type="text/css">
	.thumb200 {
		height:200px;
		border:1px solid #000;
		margin: 10px 5px 0 0;
	}

	h1#p_title {
		font-size:48px;
	}

	#p_title {
		color: #50852C;
		font-weight:normal;
	}

	.p_header {
		font-size:34px;
		font-weight: normal;
		color: #50852C;
	}

	p {
		margin-left: 30px;
		font-size: 20px;
		font-weight: normal;
		color: #AAAAAA;
	}

</style>

<script type="text/javascript">
	$(document).ready(function()
	{
		//$("#pppp").fancybox();

		enable_user_dialog("<?php echo site_url("$controller_name/get_user_dialog_info");?>" , "<?php echo base_url("assets/images/default-profile-pic.png");?>" , <?php echo $user_data->id;?>);
		document.getElementById('files1').addEventListener('change' , handleFileSelect1 , false);
		document.getElementById('files2').addEventListener('change' , handleFileSelect2 , false);
		document.getElementById('files3').addEventListener('change' , handleFileSelect3 , false);
		document.getElementById('files4').addEventListener('change' , handleFileSelect4 , false);
		document.getElementById('files5').addEventListener('change' , handleFileSelect5 , false);
	});

</script>
<h1 id="p_title"><?php echo $user_data->first_name." ".$user_data->last_name;?></h1>
<input type="button" class="btn btn-primary" value="Edit profile" id="signup_btn" name="signup_btn" data-toggle="modal">
<div id="photo"><img id="pppp" class="thumb200" src="<?php echo $default_character;?>" /></div>
<div id="occupation">
	<p><?php echo $user_data->company; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $country;?></p>

</div>
<?php
	if($user_data->about_me != '')
	{
?>
		<div class="p_header">
			<h1><?php echo lang('my_profile_about_me');?></h1>
		</div>
		<div class="contents">
			<p><?php echo nl2br($user_data->about_me);?></p>
		</div>
<?php
	}

	if($user_data->hobbies != '')
	{
?>
		<div class="p_header">
			<h1><?php echo lang('my_profile_hobbies');?></h1>
		</div>
		<div class="contents">
			<p><?php echo nl2br($user_data->hobbies);?></p>
		</div>
<?php
	}

	if($user_data->musics != '')
	{
?>
		<div class="p_header">
			<h1><?php echo lang('my_profile_musics');?></h1>
		</div>
		<div class="contents">
			<p><?php echo nl2br($user_data->musics);?></p>
		</div>
<?php
	}

	if($user_data->movies != '')
	{
?>
		<div class="p_header">
			<h1><?php echo lang('my_profile_movies');?></h1>
		</div>
		<div class="contents">
			<p><?php echo nl2br($user_data->movies);?></p>
		</div>
<?php
	}

	if($user_data->books != '')
	{
?>
		<div class="p_header">
			<h1><?php echo lang('my_profile_books');?></h1>
		</div>
		<div class="contents">
			<p><?php echo nl2br($user_data->books);?></p>
		</div>
<?php
	}
?>

<div class="p_header">
	<h1><?php echo lang('my_profile_my_photos'); ?></h1>
</div>

<div>
	<img class="thumb200" src="<?php echo $photo1; ?>" />
	<img class="thumb200" src="<?php echo $photo2; ?>" />
	<img class="thumb200" src="<?php echo $photo3; ?>" />
	<img class="thumb200" src="<?php echo $photo4; ?>" />
	<img class="thumb200" src="<?php echo $photo5; ?>" />
</div>

<?php
	$data['countries'] = $countries;
	$data['controller_name'] = $controller_name;
	$this->load->view("auth/create_user" , $data);

?>