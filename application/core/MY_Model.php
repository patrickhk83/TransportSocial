<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public $appInfo = '';
    public $type = '';

    function __construct($type = null) {
      parent::__construct();
      $this->type = $type;
      $this->initialize();
    }

    function initialize() {
      $this->rest->initialize(array(
        'server' => 'https://api.flightstats.com/flex/'.$this->type.'/rest/v1/json/'
      ));
      $this->appInfo = array(
        'appId' => 'bf28d4a0',
        'appKey' => 'a7ca1c2a0eab46e9d097f4aa39168ac7'
      );
    }
}

