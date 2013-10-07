<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flight_Model extends MY_Model {

  public function __construct()
  {
    parent::__construct('flightstatus');
    $this->config['extendedOptions'] = 'useInlinedReferences';
  }
  /**
   * Retrieve a single flight by the flight number
   * @param  [array] $request - Post values from the submitted form
   * @return [array] A single flight
   */
  public function getFlightByNumber($request) {
    $result = $this->apiCall('flight/status/'.
      $request['carrierCode'].'/'.
      $request['flightNo'].'/dep/'.
      $this->_date($request['date'])
    );

    return $result;
  }

  public function getFlightById($flightId) {
    $result = $this->apiCall('flight/status/'.$flightId);
    return $result;
  }

  /**
   * Retrieve a collection of flights by a specific airport
   * @param  [array] $request - Post values from the submitted form
   * @return [array] A collection of flights
   */
  public function getFlightsByAirport($request) {
    $result = $this->apiCall('airport/status/'.
      $request['arrivalAirportCode'].'/'.
      $request['direction'].'/'.
      $this->_date($request['date']).'/'.
      $request['hour']
    );

    return $result;
  }

  /**
   * Retrieve a collection of flights by a specific route
   * @param  [array] $request - Post values from the submitted form
   * @return [array] A collection of flights
   */
  public function getFlightsByRoute($request) {
    $result = $this->apiCall('route/status'.
      $request['departureAirportCode'].'/'.
      $request['arrivalAirportCode'].
      '/dep/'.
      $this->_date($request['date'])
    );

    return $result;
  }

  /**
   * Retrieve all saved flights for a specific user
   * @param  [string] $userId
   * @return [array] A collection of saved flights
   */
  public function getAllSavedFlights($userId) {
    $this->db->distinct();
    $this->db->select('flight.*, airlines.*, d.iata as d_iata, a.iata as a_iata, d.name as d_name, a.name as a_name');
    $this->db->from('flight');
    $this->db->join('flight_user', 'flight_user.flightId = flight.flightId');
    $this->db->join('airlines', 'flight.carrierFsCode = airlines.iata');
    $this->db->join('airports as d', 'flight.departureAirportCode = d.iata');
    $this->db->join('airports as a', 'flight.arrivalAirportCode = a.iata');
    $this->db->where('flight_user.userId', $userId);
    $this->db->group_by('flight.flightNumber');
    return $this->_prepareFlightObjects($this->db->get()->result());
  }

  /**
   * Convert Database Results into a collection of Flight objects
   * @param  [object] $flights - Saved flights from the database
   * @return [object] A collection of flight objects
   */
  public function _prepareFlightObjects($flights) {
    $savedFlights = array();
    foreach($flights as $flight) {
      $savedFlight = new stdClass();
      $savedFlight->flightId = $flight->flightId;
      $savedFlight->flightNumber = $flight->flightNumber;
      $savedFlight->carrier = new stdClass();
      $savedFlight->carrier->fs = $flight->iata;
      $savedFlight->carrier->name = $flight->name;
      $savedFlight->arrivalAirport->fs = $flight->iata;
      $savedFlight->arrivalAirport->name = $flight->a_name;
      $savedFlight->departureAirport = new stdClass();
      $savedFlight->departureAirport->fs = $flight->d_iata;
      $savedFlight->departureAirport->name = $flight->d_name;
      $savedFlight->arrivalDate = new stdClass();
      $savedFlight->arrivalDate->dateLocal = $flight->arrivalTime;
      $savedFlight->departureDate = new stdClass();
      $savedFlight->departureDate->dateLocal = $flight->departureTime;
      $savedFlights[] = $savedFlight;
    }

    return $savedFlights;
  }

  /**
   * Delete a single saved flight
   * @param  [string] $flightNumber
   * @param  [string] $userId
   * @return [boolean] If deletion was successful or not
   */
  public function deleteFlight($flightId, $userId) {
    $this->db->where('flightId', $flightId);
    $this->db->where('userId', $userId);
    $this->db->delete('flight_user');

    return ($this->db->affected_rows() ? true : false);
  }

  /**
   * Save a single flight
   * @param  [string] $request - Date, FlightNumber, CarrierCode
   * @param  [string] $userId
   * @return [boolean] If saving flight was successful or not
   */
  public function saveFlight($flightId, $userId, $privacy) {
    $flight = $this->getFlightById($flightId)->flightStatus;

    $savedFlight = new stdClass();
    $savedFlight->flightId = $flight->flightId;
    $savedFlight->flightNumber = $flight->flightNumber;
    $savedFlight->carrierFsCode = $flight->carrier->fs;
    $savedFlight->arrivalAirportCode = $flight->arrivalAirport->fs;
    $savedFlight->departureAirportCode = $flight->departureAirport->fs;
    $savedFlight->arrivalTime = $flight->arrivalDate->dateLocal;
    $savedFlight->departureTime = $flight->departureDate->dateLocal;

    $flightUser = array(
      'userId' => $userId,
      'flightId' => $savedFlight->flightId,
      'privacy' => $privacy
    );

    if(!$this->_recordExists(array('flightId' => $savedFlight->flightId), 'flight')) {
      $this->db->insert('flight', $savedFlight);
    }

    if(!$this->_recordExists($flightUser, 'flight_user')) {
      $this->db->insert('flight_user',$flightUser);
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * Prepare Date for the api yyyy/mm/dd
   * @param  [array] $date
   * @return [string]
   */
  public function _date($date) {
    return
      $date['year'].'/'.
      $date['month'].'/'.
      $date['day'];
  }

  /**
   * Check if records exist in the database
   * @param  [array] $fieldValues - Field name and values
   * @param  [string] $table
   * @return [boolean] If reocrd exists or not
   */
  public function _recordExists($fieldValues, $table)
  {
    $this->db->where($fieldValues);
    $query = $this->db->get($table);

    return ($query->num_rows() > 0 ? true : false);
  }

  /**
   * Check which flights are saved or not
   * @param  [object]  $flights - A collection of flights
   * @param  [string]  $userId
   * @return [object] A collection of flights
   */
  public function _isSaved($flights, $userId) {
    $userFlights = $this->_getUserFlights($userId);
    foreach($flights as $flight) {
      $flight->isSaved = false;
      if(count((array)$userFlights) > 0) {
        foreach($userFlights as $userFlight) {
          if($flight->flightId == $userFlight->flightId) {
            $flight->isSaved = true;
            break;
          }
        }
      }
    }
    return $flights;
  }

  public function _getUserFlights($userId = null) {
    $this->db->select('flightId, userId, privacy');
    if(isset($userId)) {
      $this->db->where('userId', $userId);
    }
    return $this->db->get('flight_user')->result();
  }

  public function _appendPassengersToFlight($flights, $userId = null) {
    $userFlights = $this->_getUserFlights();
    foreach($flights as $flight) {
      $flight->totalPassengers = array();
      foreach($userFlights as $userFlight) {
        if($this->_isAllowedToViewPassenger($userId, $userFlight)) {
          if($flight->flightId == $userFlight->flightId) {
            array_push($flight->totalPassengers, $this->ion_auth->user($userFlight->userId)->row());
          }
        }
      }
    }
    return $flights;
  }

  public function _isAllowedToViewPassenger($userId, $userFlight) {
    if($userFlight->privacy == ONLY_YOU && $userFlight->userId == $userId) {
      return true;
    }
    else if($userFlight->privacy == OTHER_USERS && isset($userId)) {
      return true;
    }
    else {
      return false;
    }
  }
}

