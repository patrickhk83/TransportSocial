<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
      parent::__construct();
      $this->LoadUser();
    }

    /**
     * Load the user information from database
     */
    public function LoadUser() {
      if($this->ion_auth->logged_in()) {
        $this->user = $this->ion_auth->user()->row();
        $data['user'] = $this->user;
        $this->load->vars($data);
      }
    }
}

