<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Airport_Model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function getAll() {
    $this->db->select('name, iata');
    $this->db->where('iata !=', '');
    $this->db->order_by('name asc');
    $result = $this->db->get('airports')->result();

    return $result;
  }
}

