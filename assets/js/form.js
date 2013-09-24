$(document).ready(function() {
  var date = new Date();
  $('.date').datepicker({
    startDate: date.toString('d-m-yyyy'),
    orientation: "bottom left",
    autoclose: 'true'
  });
});
