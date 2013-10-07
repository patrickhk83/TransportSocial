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

   /**
   * //Added by David Ming 2013/10/5
   * get airport name and iata from db
   * @param string $search
   * @param number $limit
   * @return Ambigous <multitype:string , multitype:>
   */

  public function get_search_suggestions_airport($search , $limit = 30)
  {
  	$suggestions = array();

    $this->db->from('airports');
    $this->db->where('iata !=', '');
    $this->db->like('name', $search);
    $this->db->or_like('iata', $search);
    $this->db->order_by("name", "asc");
    $this->db->limit($limit);
    $result = $this->db->get()->result();
    foreach($result as $row)
    {
      $suggestions[]=$row->name."(".$row->iata.")";
    }
    return $suggestions;

  }
}

