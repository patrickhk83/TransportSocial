<form action="/flight/saveFlight/<?php echo $flightId; ?>" method="post">
  <?php if(validation_errors()) { ?>
    <div class="alert alert-danger">
      <?php echo validation_errors();  ?>
    </div>
  <?php } ?>
  <div class="form-group">
    <p>Before you save your flight, select one of the option to determine who sees you attending this flight.</p>
    <label class="radio-inline">
      <input type="radio" name="privacy" value="0">Only Friends
    </label>
    <label class="radio-inline">
      <input type="radio" name="privacy" value="1">All Users
    </label>
    <label class="radio-inline">
      <input type="radio" name="privacy" value="2">Only You
    </label>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" value="Save">
  </div>
</form>
