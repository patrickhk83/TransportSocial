<html>
  <head>
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?php echo site_url('/assets/css/style.css'); ?>">
    <?php if ($_styles) { echo $_styles; } ?>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="<?php echo site_url('/assets/js/tooltip.js'); ?>"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

	<!-- Added by David Ming 2013/10/5 -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" />
<!-- Added by David Ming 2013/10/5 -->
	<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>


    <?php if ($_scripts) { echo $_scripts; } ?>
  </head>
  <body>
    <div class="container">
      <div class="header">
        <?php echo $header; ?>
        <ul class="nav nav-pills">
          <li <?php isActive('flight/searchByAirport') ?>>
            <?php echo anchor('flight/searchByAirport', 'By Airport'); ?>
          </li>
          <li <?php isActive('flight/searchByRoute') ?>>
            <?php echo anchor('flight/searchByRoute', 'By Route'); ?>
          </li>
          <li <?php isActive('flight/searchByFlight') ?>>
            <?php echo anchor('flight/searchByFlight', 'By Flight'); ?>
          </li>
          <?php if(isset($user)) { ?>
            <li <?php isActive('flight/savedFlights/'.$user->id); ?>>
              <?php echo anchor('flight/savedFlights/'.$user->id, 'Saved Flights'); ?>
            </li>
            <li <?php isActive('auth/profile/'.$user->id); ?>>
            	<?php echo anchor('auth/profile/'.$user->id , 'My Profile'); ?>
            </li>
            <li>
              <?php echo anchor('auth/logout', 'Logout'); ?>
            </li>
          <?php } else { ?>
            <li <?php isActive('auth/login') ?>>
              <?php echo anchor('auth/login', 'Login'); ?>
            </li>
          <?php } ?>

        </ul>
      </div>
      <div class="main">
        <div class="panel panel-default">
          <div class="content panel-body">
            <h2><?php echo $title; ?></h2>
              <div class="post">
                <?php echo $content; ?>
              </div>
            </div>
          </div>
        </div>
      <div class="footer">
        <?php echo $footer; ?>
      </div>
    </div>
  </body>
</html>
