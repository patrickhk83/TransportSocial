<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flight_Model extends MY_Model {

  public function __construct()
  {
    parent::__construct('schedules');
  }
  /**
   * Retrieve a single flight by the flight number
   * @param  [array] $request - Post values from the submitted form
   * @return [array] A single flight
   */
  public function getFlightByNumber($request) {
    $result = $this->apiCall('flight/'.
      $request['carrierCode'].'/'.
      $request['flightNo'].'/departing/'.
      $this->_date($request['date'])
    );

    return $result;
  }

  /**
   * Retrieve a collection of flights by a specific airport
   * @param  [array] $request - Post values from the submitted form
   * @return [array] A collection of flights
   */
  public function getFlightsByAirport($request) {
    $result = $this->apiCall(
      $this->_determineDirection($request['direction']).'/'.
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
    $result = $this->apiCall('from/'.
      $request['departureAirportCode'].'/to/'.
      $request['arrivalAirportCode'].
      '/departing/'.
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
    $this->db->join('flight_user', 'flight_user.flightNumber = flight.flightNumber');
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
      $savedFlight->flightNumber = $flight->flightNumber;
      $savedFlight->carrier = new stdClass();
      $savedFlight->carrier->fs = $flight->iata;
      $savedFlight->carrier->name = $flight->name;
      $savedFlight->arrivalAirport = new stdClass();
      $savedFlight->arrivalAirport->fs = $flight->iata;
      $savedFlight->arrivalAirport->name = $flight->a_name;
      $savedFlight->departureAirport = new stdClass();
      $savedFlight->departureAirport->fs = $flight->d_iata;
      $savedFlight->departureAirport->name = $flight->d_name;
      $savedFlight->arrivalTime = $flight->arrivalTime;
      $savedFlight->departureTime = $flight->departureTime;
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
  public function deleteFlight($flightNumber, $userId) {
    $this->db->where('flightNumber', $flightNumber);
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
  public function saveFlight($request, $userId) {
    $flight = $this->getFlightByNumber($request)->scheduledFlights[0];

    $savedflight = new stdClass();
    $savedflight->flightNumber = $flight->flightNumber;
    $savedflight->carrierFsCode = $flight->carrier->fs;
    $savedflight->arrivalAirportCode = $flight->arrivalAirport->fs;
    $savedflight->departureAirportCode = $flight->departureAirport->fs;
    $savedflight->arrivalTime = $flight->arrivalTime;
    $savedflight->departureTime = $flight->departureTime;

    $flightUser = array(
      'userId' => $userId,
      'flightNumber' => $savedflight->flightNumber
    );

    if(!$this->_recordExists(array('flightNumber' => $savedflight->flightNumber), 'flight')) {
      $this->db->insert('flight', $savedflight);
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
   * Determine if arriving or departing
   * @param  [string] $direction - Arriving or Departing
   * @return [string]
   */
  public function _determineDirection($direction) {
    return ($direction == 'arriving' ? 'to' : 'from');
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
    $this->db->select('flightNumber');
    $this->db->where('userId', $userId);
    $userFlights = $this->db->get('flight_user')->result();
    foreach($flights as $flight) {
      if(count((array)$userFlights) > 0) {
        foreach($userFlights as $userFlight) {
          if($flight->flightNumber == $userFlight->flightNumber) {
            $flight->isSaved = true;
            break;
          } else {
            $flight->isSaved = false;
          }
        }
      } else {
        $flight->isSaved = false;
      }
    }

    return $flights;
  }
}

