<script type="text/javascript">
  $(document).ready(function(){
    enable_search_airport("<?php echo site_url($this->router->fetch_class().'/suggest_airport');?>");
  });
</script>
<form action="<?php echo site_url($this->router->fetch_class().'/searchByRoute'); ?>" method="post">
  <?php if(validation_errors()) { ?>
    <div class="alert alert-danger">
      <?php echo validation_errors(); ?>
    </div>
  <?php } ?>
  <div class="form-group">
    <label for="departureAirportCode">Departure Airport</label>
    <?php echo form_input(array('name'=>'departureAirportCode' , 'id'=>'departureAirportCode' , 'class'=>'form-control' , 'value'=>''));?>
  </div>
  <div class="form-group">
    <label for="arrivalAirportCode">Arrival Airport</label>
    <?php echo form_input(array('name'=>'arrivalAirportCode' , 'id'=>'arrivalAirportCode' , 'class'=>'form-control' , 'value'=>''));?>
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

