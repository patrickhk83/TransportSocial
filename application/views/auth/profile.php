<script type="text/javascript">
	$(document).ready(function()
	{
		enable_user_dialog("<?php echo site_url($this->router->fetch_class().'/edit_user/'.$user->id);?>" , "<?php echo base_url("assets/images/default-profile-pic.png");?>" , <?php echo $user->id;?>);
	});
</script>
<h1 class="heading"><?php echo $user->first_name." ".$user->last_name;?></h1>
<a href="/auth/edit_user/<?php echo $user->id; ?>" class="btn btn-primary" data-toggle="modal" data-target="#dialog_form" data-remote="false">Edit Profile</a>
<div class="photo"><img class="thumb" src="<?php echo $profile_pic;?>" /></div>
<div class="occupation">
	<p>
		<?php echo $user->company. '|' .$country;?>
	</p>
</div>
<?php if(!empty($user->about_me)): ?>
	<h1 class="heading"><?php echo lang('my_profile_about_me');?></h1>
	<p class="content"><?php echo $user->about_me;?></p>
<?php endif; ?>
<?php if(!empty($user->hobbies)): ?>
		<h1 class="heading"><?php echo lang('my_profile_hobbies');?></h1>
		<p class="content"><?php echo $user->hobbies;?></p>
<?php endif; ?>
<?php if(!empty($user->musics)): ?>
		<h1 class="heading"><?php echo lang('my_profile_musics');?></h1>
		<p class="content"><?php echo $user->musics;?></p>
<?php endif; ?>
<?php if(!empty($user->movies)): ?>
		<h1 class="heading"><?php echo lang('my_profile_movies');?></h1>
		<p class="content"><?php echo $user->movies;?></p>
	<?php endif; ?>
<?php if(!empty($user->books)): ?>
		<h1 class="heading"><?php echo lang('my_profile_books');?></h1>
		<p class="content"><?php echo $user->books;?></p>
<?php endif; ?>

<?php if (count($photos)): ?>
<h1 class="heading"><?php echo lang('my_profile_my_photos'); ?></h1>
	<div>
		<?php foreach ($photos as $photo): ?>
			<img class="thumb" src="<?php echo $photo->path; ?>" />
		<?php endforeach; ?>
	</div>
<?php endif ?>
