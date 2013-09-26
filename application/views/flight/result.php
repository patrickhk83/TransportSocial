<?php if(!empty($message)) { ?>
  <div class="alert <?php echo $message_class;?>">
    <?php echo $message; ?>
  </div>
<?php } ?>

<?php if(count($flights) > 0): ?>
  <div class="list-group">
  <?php foreach($flights as $flight): ?>
    <li class="list-group-item">
    <div class="flightNumber">
      <?php echo $flight->carrier->fs; ?>
      <?php echo $flight->flightNumber; ?>
    </div>
    <div class="carrier">
      <?php echo $flight->carrier->name; ?>
    </div>
    <div class="route">
      <?php echo $flight->arrivalAirport->name.' to '.$flight->departureAirport->name; ?>
    </div>

    <div class="times">
      <p>Departure Time: <?php echo date('d/m/Y h:m', strtotime($flight->departureTime)); ?></p>
      <p>Arrival Time: <?php echo date('d/m/Y h:m', strtotime($flight->arrivalTime)); ?></p>
    </div>
    <?php if(isset($user)) { ?>
      <?php if(!$flight->isSaved) { ?>
        <a class="btn btn-primary" href="/flight/saveFlight/<?php echo $flight->flightNumber.'/'.$flight->carrier->fs.'/'.date('j-n-Y', strtotime($flight->departureTime)); ?>">Save</a>
      <?php } else { ?>
        <a class="btn btn-primary" href="/flight/deleteFlight/<?php echo $flight->flightNumber.'/'.$user->id; ?>">Delete</a>
      <?php } ?>
    <?php } ?>
    </li>
  <?php endforeach; ?>
  </div>
<?php else: ?>
  <p>Sorry, it appears that no flights were found!</p>
<?php endif; ?>

