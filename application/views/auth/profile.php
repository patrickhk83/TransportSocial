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
<h1 class="heading"><?php echo $user_data->first_name." ".$user_data->last_name;?></h1>
<input type="button" class="btn btn-primary" value="Edit profile" id="signup_btn" name="signup_btn" data-toggle="modal">
<div class="photo"><img id="pppp" class="thumb200" src="<?php echo $default_character;?>" /></div>
<div class="occupation">
	<p>
		<?php echo $user_data->company. '|' .$country;?>
	</p>
</div>

<?php if(!empty($user_data->about_me)) ?>
	<h1 class="heading"><?php echo lang('my_profile_about_me');?></h1>
	<p class="content"><?php echo $user_data->about_me;?></p>
<?php endif; ?>
<?php if(!empty($user_data->hobbies)): ?>
		<h1 class="heading"><?php echo lang('my_profile_hobbies');?></h1>
		<p class="content"><?php echo $user_data->hobbies;?></p>
<?php endif; ?>
<?php if(!empty($user_data->musics)): ?>
		<h1 class="heading"><?php echo lang('my_profile_musics');?></h1>
		<p class="content"><?php echo $user_data->musics;?></p>
<?php endif; ?>
<?php if(!empty($user_data->movies)): ?>
		<h1 class="heading"><?php echo lang('my_profile_movies');?></h1>
		<p class="content"><?php echo $user_data->movies;?></p>
	<?php endif; ?>
<?php if(!empty($user_data->books)): ?>
		<h1 class="heading"><?php echo lang('my_profile_books');?></h1>
		<p class="content"><?php echo $user_data->books;?></p>
<?php endif; ?>

<h1 class="heading"><?php echo lang('my_profile_my_photos'); ?></h1>
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