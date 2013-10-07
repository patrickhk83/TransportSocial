<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Airline_Model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

    /**
   * get airline name and iata from db
   * @param unknown $search
   * @param number $limit
   * @return Ambigous <multitype:string , multitype:>
   */
  public function get_search_suggestions_airline($search , $limit=30)
  {
  	$suggestions = array();

  	$this->db->from('airlines');
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
