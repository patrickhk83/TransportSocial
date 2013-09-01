<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class airport extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Airport_Model', 'airport');
    }

    function all() {
      $airports = $this->airport->getAll();
    }
}

