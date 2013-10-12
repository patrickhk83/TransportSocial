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
