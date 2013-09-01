<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airport_model extends MY_Model {


  public function __construct()
  {
    parent::__construct('airports');
  }

  public function getAll()
  {
    $user = $this->rest->get('all', $this->appInfo);

    echo print_r($this->rest->debug());
  }

}

/* End of file article.php */
/* Location: ./application/models/article.php */
