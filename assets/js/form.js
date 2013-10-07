$(document).ready(function() {
  var date = new Date();
  $('.date').datepicker({
    startDate: date.toString('d-m-yyyy'),
    orientation: "bottom left",
    autoclose: 'true'
  });
});

/**
 * Enable autocomplete of Airport Code field
 * @param suggest_url
 */

function enable_search_airport(suggest_url)
{
	$("#arrivalAirportCode, #departureAirportCode").autocomplete({minLength: 1,
	  	source: function( request, response ) {
	  		$.ajax({
	  			type : "POST" ,
	  			url:  suggest_url,
	  			dataType: "json" ,
	  			data: {term:request.term} ,
	  			error : function(request, status, error) {
	  		         alert("code");
	  		        },
	  			success: function(data) {
	  				response(data);
	  			}
	  		});
	  	}
	  });
}

/**
 * Enable autocomplete of Carrier Code
 * @param suggest_url
 */

function enable_search_flight(suggest_url)
{
	$("#carrierCode").autocomplete({minLength: 1,
	  	source: function( request, response ) {
	  		$.ajax({
	  			type : "POST" ,
	  			url:  suggest_url,
	  			dataType: "json" ,
	  			data: {term:request.term} ,
	  			error : function(request, status, error) {
	  		         alert("code");
	  		        },
	  			success: function(data) {
	  				response(data);
	  			}
	  		});
	  	}
	  });
}
