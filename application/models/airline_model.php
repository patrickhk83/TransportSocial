<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Airline_Model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function getAll() {
    $this->db->select('name, iata');
    $this->db->where('iata !=', '');
    $this->db->order_by('name asc');
    $result = $this->db->get('airlines')->result();

    return $result;
  }
  
  
    /**
   * //Added by David Ming 2013/10/5
   * get airline name and iata from db
   * @param unknown $search
   * @param number $limit
   * @return Ambigous <multitype:string , multitype:>
   */
  public function get_search_suggestions_airline($search , $limit=30)
  {
  	$suggestions = array();

  	$this->db->from('airlines');
  	$this->db->where("(name LIKE '%".$this->db->escape_like_str($search)."%' or
		iata LIKE '%".$this->db->escape_like_str($search)."%')");
  	$this->db->order_by("name", "asc");
  	$by_name = $this->db->get();
  	foreach($by_name->result() as $row)
  	{
  		$suggestions[]=$row->name."(".$row->iata.")";
  	}

  	//only return $limit suggestions
  	if(count($suggestions) > $limit)
  	{
  		$suggestions = array_slice($suggestions, 0,$limit);
  	}
  	return $suggestions;

  }
}
