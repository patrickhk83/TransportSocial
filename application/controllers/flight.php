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
          'carrierCode' => $this->input->post('carrierCode'),
          'flightNo' => $this->input->post('flightNo'),
          'date' => $this->_splitDate($this->input->post('date'))
        );

        $result = $this->flight->getFlightByNumber($request);
        $this->_renderFlightResults($result);
        return;
      }
    }
    $data['airlines'] = $this->_getAllAirlines();
    $this->addDatePickerFiles();
    $this->template->write('title', 'Search Flight by Flight Number');
    $this->template->write_view('content', 'flight/searchByFlight', $data, TRUE);
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
          'arrivalAirportCode' => $this->input->post('arrivalAirportCode'),
          'direction' => $this->input->post('direction'),
          'date' => $this->_splitDate($this->input->post('date')),
          'hour' => $this->input->post('hour')
        );

        $result = $this->flight->getFlightsByAirport($request);
        $this->_renderFlightResults($result);
        return;
      }
    }
    $data['airports'] = $this->_getAllAirports();
    $this->addDatePickerFiles();
    $this->template->write('title', 'Search Flights by Airport');
    $this->template->write_view('content', 'flight/searchByAirport', $data, TRUE);
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
    $data['airports'] = $this->_getAllAirports();
    $this->addDatePickerFiles();
    $this->template->write('title', 'Search Flights by Route');
    $this->template->write_view('content', 'flight/searchByRoute', $data, TRUE);
    $this->template->render();
  }

  /**
   * Save a flight
   * @param  [string] $flightNo
   * @param  [string] $carrierCode
   * @param  [string] $date
   */
  public function saveFlight($flightNo, $carrierCode, $date) {
    $request = array(
      'flightNo' => $flightNo,
      'carrierCode' => $carrierCode,
      'date' => $this->_splitDate($date)
    );
    if($this->flight->saveFlight($request, $this->user->id)) {
      $this->session->set_flashdata('message', 'The flight has been saved successfully');
      $this->session->set_flashdata('message_class', 'alert-success');
    }
    else {
      $this->session->set_flashdata('message', 'You have already saved this flight before');
      $this->session->set_flashdata('message_class', 'alert-danger');
    }
    redirect('/flight/savedFlights/'.$this->user->id, 'refresh');
  }

  /**
   * Delete a flight
   * @param  [string] $flightNo
   * @param  [string] $userId
   */
  public function deleteFlight($flightNo, $userId) {
    if($this->flight->deleteFlight($flightNo, $userId)) {
      $this->session->set_flashdata('message', 'You have successfully deleted the saved flight');
      $this->session->set_flashdata('message_class', 'alert-success');
    } else {
      $this->session->set_flashdata('message', 'You were unable to delete the saved flight');
      $this->session->set_flashdata('message_class', 'alert-danger');
    }
    redirect('/flight/savedFlights/'.$userId, 'refresh');
  }

  /**
   * Get all saved flights
   * @param  [string] $userId
   */
  public function savedFlights($userId) {
    $data['flights'] = $this->flight->_isSaved($this->flight->getAllSavedFlights($userId), $userId);
    $data['message'] = $this->session->flashdata('message');
    $data['message_class'] = $this->session->flashdata('message_class');
    $this->template->write('title', 'Saved Flights');
    $this->template->write_view('content', 'flight/result', $data, TRUE);
    $this->template->render();
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
    $data['flights'] = $this->flight->_isSaved($result->scheduledFlights, $this->user->id);
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

}

