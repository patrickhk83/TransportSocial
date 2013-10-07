<script type="text/javascript">
	$(document).ready(function(){
  	enable_search_flight("<?php echo site_url($this->router->fetch_class().'/suggest_flight');?>");
	});
</script>
<form action="<?php echo site_url($this->router->fetch_class().'/searchByFlight'); ?>" method="post">
  <?php if(validation_errors()) { ?>
    <div class="alert alert-danger">
      <?php echo validation_errors(); ?>
    </div>
  <?php } ?>
  <div class="form-group">
    <label for="carrierCode">Carrier Code</label>
    <?php echo form_input(array('name'=>'carrierCode' , 'id'=>'carrierCode' , 'class'=>'form-control' , 'value'=>''));?>
  </div>
  <div class="form-group">
    <label for="FlightNo">Flight Number</label>
    <input type="text" class="form-control" id="flightNo" name="flightNo">
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
