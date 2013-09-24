<html>
<head>
  <title></title>
</head>
<body>
  <form action="/flight/searchByRoute" method="post">
    <?php if(validation_errors()) { ?>
      <div class="alert alert-danger">
        <?php echo validation_errors(); ?>
      </div>
    <?php } ?>
    <div class="form-group">
      <label for="departureAirportCode">Departure Airport Code</label>
      <input type="text" class="form-control" id="departureAirportCode" name="departureAirportCode">
    </div>
    <div class="form-group">
      <label for="arrivalAirportCode">Arrival Airport Code</label>
      <input type="text" class="form-control" id="arrivalAirportCode" name="arrivalAirportCode">
    </div>
    <div class="form-group">
      <label for="Date">Date</label>
      <div class="input-group date"  data-date-format="d-m-yyyy">
        <input type="text" placeholder="dd-mm-yyyy" class="form-control" name="date" value="<?php echo set_value('date', date('j-n-Y')); ?>" readonly>
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
      </div>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Search">
    </div>
  </form>
</body>
</html>
