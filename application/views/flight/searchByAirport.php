<html>
<head>
  <title></title>
</head>
<body>
  <form action="/flight/searchByAirport" method="post">
    <?php if(validation_errors()) { ?>
      <div class="alert alert-danger">
        <?php echo validation_errors();  ?>
      </div>
    <?php } ?>
    <div class="form-group">
      <label for="arrivalAirportCode">Airport Code</label>
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
      <label for="hour">Hour of Day</label>
      <input type="text" class="form-control" name="hour" value="<?php echo set_value('hour'); ?>">
    </div>
    <div class="form-group">
      <label class="radio-inline">
        <input type="radio" name="direction" value="arriving">Arriving
      </label>
      <label class="radio-inline">
        <input type="radio" name="direction" value="departing">Departing
      </label>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Search">
    </div>
  </form>
</body>
</html>