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
        <p>Departure Time: <?php echo date('d/m/Y h:m', strtotime($flight->departureDate->dateLocal)); ?></p>
        <p>Arrival Time: <?php echo date('d/m/Y h:m', strtotime($flight->arrivalDate->dateLocal)); ?></p>
      </div>

      <?php if($flight->totalPassengers > 0): ?>
        <p>
          <?php foreach($flight->totalPassengers as $passenger): ?>
            <a href="/auth/edit_user/<?php echo $passenger->id; ?>" data-toggle="tooltip" title="<?php echo $passenger->username; ?>">
              <img src="/assets/images/default-profile-pic.png" width="20" height="20">
            </a>
          <?php endforeach; ?>
        </p>
      <?php endif; ?>

      <?php if(isset($user)): ?>
        <div>
          <?php if(!$flight->isSaved): ?>
            <a class="btn btn-primary" href="/flight/setPrivacy/<?php echo $flight->flightId; ?>">Save</a>
          <?php else: ?>
            <a class="btn btn-primary" href="/flight/deleteFlight/<?php echo $flight->flightId; ?>">Delete</a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
  </div>
<?php else: ?>
  <p>Sorry, it appears that no flights were found!</p>
<?php endif; ?>

