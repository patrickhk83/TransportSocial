<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public $type = '';

    function __construct($type = null) {
      parent::__construct();
      $this->type = $type;
      $this->initialize();
    }

    /**
     * Initialize the base url for the RESTful API
     * @return [type]
     */
    function initialize() {
      $this->rest->initialize(array(
        'server' => 'https://api.flightstats.com/flex/'.$this->type.'/rest/v2/json/'
      ));
    }

    /**
     * Make a request to the RESTful api
     * @param  [string] $function - the REST function that needs to be called
     * @return [object] A collection of information related to the $function
     */
    function apiCall($function) {
      return $this->rest->get($function, array(
        'appId' => 'bf28d4a0',
        'appKey' => 'a7ca1c2a0eab46e9d097f4aa39168ac7',
        'extendedOptions' => 'useInlinedReferences'
      ));
    }
}

