<html>
<head>
  <title>List of Articles</title>
</head>
<body>
  <div id="main">
    <?php foreach ($query->result() as $row): ?>
      <h1><?php echo $row->title; ?></h1>
      <p><?php echo $row->content; ?></p>
    <?php endforeach; ?>
  </div>
</body>
</html>
