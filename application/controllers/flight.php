<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flight extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Flight_Model', 'flight');
  }

  public function index() {
    $this->searchByAirport();
  }

  /**
   * Adds the required files for the date picker
   */
  public function addDatePickerFiles() {
    $this->template->add_js('assets/js/bootstrap-datepicker.js');
    $this->template->add_js('assets/js/form.js');
    $this->template->add_css('assets/css/datepicker.css');
  }

  /**
   * Search for flight by flight number
   */
  public function searchByFlight() {
    if(isMethod('post')) {
      $this->form_validation->set_rules('carrierCode', 'Carrier Code', 'required|trim');
      $this->form_validation->set_rules('flightNo', 'Flight Number', 'required|trim|numeric');
      $this->form_validation->set_rules('date', 'Date','required|trim|callback__isDate');

      if($this->form_validation->run() != false) {
        $request = array (
		  'carrierCode' => $this->get_iata_code($this->input->post('carrierCode')),
          'flightNo' => $this->input->post('flightNo'),
          'date' => $this->_splitDate($this->input->post('date'))
        );

        $result = $this->flight->getFlightByNumber($request);
        $this->_renderFlightResults($result);
        return;
      }
    }
    $this->addDatePickerFiles();
    $this->template->write('title', 'Search Flight by Flight Number');
    $this->template->write_view('content', 'flight/searchByFlight', TRUE);
    $this->template->render();
  }

  /**
   * Search for flights by airport
   */
  public function searchByAirport() {
    if(isMethod('post')) {
      $this->form_validation->set_rules('arrivalAirportCode', 'Arrival Airport Code', 'required|trim');
      $this->form_validation->set_rules('direction', 'Direction', 'required|trim');
      $this->form_validation->set_rules('date', 'Date','required|trim|callback__isDate');
      $this->form_validation->set_rules('hour', 'Hour', 'required|trim|numeric');

      if($this->form_validation->run() != false) {
        $request = array (
		  'arrivalAirportCode' => $this->get_iata_code($this->input->post('arrivalAirportCode')),
          'direction' => $this->input->post('direction'),
          'date' => $this->_splitDate($this->input->post('date')),
          'hour' => $this->input->post('hour')
        );

        $result = $this->flight->getFlightsByAirport($request);
        $this->_renderFlightResults($result);
        return;
      }
    }
    $this->addDatePickerFiles();
    $this->template->write('title', 'Search Flights by Airport');
    $this->template->write_view('content', 'flight/searchByAirport', TRUE);
    $this->template->render();
  }

  /**
   * Search for flights by route
   */
  public function searchByRoute() {

    if(isMethod('post')) {
      $this->form_validation->set_rules('departureAirportCode', 'Departure Airport Code', 'required|trim');
      $this->form_validation->set_rules('arrivalAirportCode', 'Arrival Airport Code', 'required|trim');
      $this->form_validation->set_rules('date', 'Date','required|trim|callback__isDate');

      if($this->form_validation->run() != false) {
        $request = array (
          'arrivalAirportCode' => $this->input->post('arrivalAirportCode'),
          'departureAirportCode' => $this->input->post('departureAirportCode'),
          'date' => $this->_splitDate($this->input->post('date'))
        );

        $result = $this->flight->getFlightsByRoute($request);
        $this->_renderFlightResults($result);
        return;
      }
    }
    $this->addDatePickerFiles();
    $this->template->write('title', 'Search Flights by Route');
    $this->template->write_view('content', 'flight/searchByRoute', TRUE);
    $this->template->render();
  }

  /**
   * Save a flight
   * @param  [string] $flightNo
   * @param  [string] $carrierCode
   * @param  [string] $date
   */
  public function saveFlight($flightId) {
    if($this->flight->saveFlight($flightId, $this->user->id, $this->input->post('privacy'))) {
      $this->session->set_flashdata('message', 'The flight has been saved successfully');
      $this->session->set_flashdata('message_class', 'alert-success');
    }
    else {
      $this->session->set_flashdata('message', 'You have already saved this flight before');
      $this->session->set_flashdata('message_class', 'alert-danger');
    }
    redirect('/flight/savedFlights/'.$this->user->id, 'refresh');
  }

  public function setPrivacy($flightId) {
    $data['flightId'] = $flightId;
    $this->template->write('title', 'Set Privacy Settings');
    $this->template->write_view('content', 'flight/privacy', $data, TRUE);
    $this->template->render();

  }

  /**
   * Delete a flight
   * @param  [string] $flightNo
   * @param  [string] $userId
   */
  public function deleteFlight($flightId) {
    if($this->flight->deleteFlight($flightId, $this->user->id)) {
      $this->session->set_flashdata('message', 'You have successfully deleted the saved flight');
      $this->session->set_flashdata('message_class', 'alert-success');
    } else {
      $this->session->set_flashdata('message', 'You were unable to delete the saved flight');
      $this->session->set_flashdata('message_class', 'alert-danger');
    }
    redirect('/flight/savedFlights/'.$this->user->id, 'refresh');
  }

  /**
   * Get all saved flights
   * @param  [string] $userId
   */
  public function savedFlights($userId) {
    if(isset($this->user->id) && $this->user->id == $userId) {
      $userId = (isset($this->user) ? $this->user->id : null);
      $flights = $this->flight->_appendPassengersToFlight($this->flight->getAllSavedFlights($userId), $userId);
      $data['flights'] = $this->flight->_isSaved($flights, $userId);
      $data['message'] = $this->session->flashdata('message');
      $data['message_class'] = $this->session->flashdata('message_class');
      $this->template->add_js('/assets/js/information.js');
      $this->template->write('title', 'Saved Flights');
      $this->template->write_view('content', 'flight/result', $data, TRUE);
      $this->template->render();
    }
    else {
      redirect('/');
    }
  }

  public function _getAllAirports() {
    $this->load->model('Airport_Model', 'airport');
    return $this->airport->getAll();
  }

  public function _getAllAirlines() {
    $this->load->model('Airline_Model', 'airline');
    return $this->airline->getAll();
  }

  /**
   * Split the full date into Day, Month, and Year
   * @param  [string] $date - full date
   * @return [array] month, day, year
   */
  public function _splitDate($date) {
    $date = explode('-', $date);
    $date = array(
      'day' => $date[0],
      'month' => $date[1],
      'year' => $date[2]
    );
    return $date;
  }

  /**
   * Render the flight result views
   * @param  [array] $result
   */
  public function _renderFlightResults($result) {
    $userId = (isset($this->user) ? $this->user->id : null);
    $result = $this->flight->_appendPassengersToFlight($result->flightStatuses, $userId);
    if(isset($this->user)) {
      $data['flights'] = $this->flight->_isSaved($result, $this->user->id);
    }
    else {
      $data['flights'] = $result;
    }
    $this->template->write('title', 'Flight Results');
    $this->template->write_view('content', 'flight/result', $data, TRUE);
    $this->template->render();
  }

  /**
   * Check if the enter date is valid
   * @param  [array]  $date
   * @return boolean
   */
  public function _isDate($date) {
    $date = $this->_splitDate($date);
    return checkdate($date['month'], $date['day'], $date['year']);
  }

   /**
   *
   * get Airport Code autocomplete result
   * @param  void
   * @return json
   */

  public function suggest_airport()
  {
  	$q = $this->input->post('term');
  	$this->load->model('Airport_Model', 'airport');
  	$suggestions = $this->airport->get_search_suggestions_airport($q , 30);

  	echo json_encode($suggestions);
  }


  /**
   *
   * get Carrier Code autocomplete result
   * @param  void
   * @return json
   */
  public function suggest_flight()
  {
  	$q = $this->input->post('term');
  	$this->load->model('Airline_Model', 'airline');
  	$suggestions = $this->airline->get_search_suggestions_airline($q , 30);
  	echo json_encode($suggestions);
  }

  public function get_iata_code($string) {
	$iata = explode('(' , $string);
	$iata = explode(')' , $iata[1]);
	return $iata[0];
  }

}

