
  	<script type="text/javascript">
		$(document).ready(function(){
			enable_search_airport("<?php echo site_url("$controller_name/suggest_airport");?>");

		});
	</script>
  <form action="<?php echo site_url("$controller_name/searchByAirport"); ?>" method="post">
    <?php if(validation_errors()) { ?>
      <div class="alert alert-danger">
        <?php echo validation_errors();  ?>
      </div>
    <?php } ?>
    <div class="form-group">
      <label for="arrivalAirportCode">Airport Code</label>
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
      <label for="hour">Hour of Day</label>
      <select class="form-control" name="hour" id="hour">
      	<option value="0">0000-0600</option>
      	<option value="6">0600-1200</option>
      	<option value="12">1200-1800</option>
      	<option value="18">1800-0000</option>
      </select>
    </div>
    <div class="form-group">
      <label class="radio-inline">
        <input type="radio" name="direction" value="arr">Arriving
      </label>
      <label class="radio-inline">
        <input type="radio" name="direction" value="dep">Departing
      </label>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Search">
    </div>
  </form>
