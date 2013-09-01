<?php /** views/dovecote_timeline.php */ ?>

<h3>Recent Happenings:</h3>
<ol>
<?php foreach ($items as $item): ?>
	<li><?php echo $item->title; ?></li>
<?php endforeach; ?>
</ol>