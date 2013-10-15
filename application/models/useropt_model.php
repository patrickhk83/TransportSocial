<?php
class Useropt_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function photos_db($data)
	{
		$this->db->from('users_photos');
		$this->db->where('user_id' , $data['user_id']);
		$result = $this->db->get();
		if($result->num_rows() == 1)
		{
			$this->db->where('user_id' , $data['user_id']);
			return $this->db->update('users_photos' , $data);

		}
		else if($result->num_rows() == 0)
		{
			return $this->db->insert('users_photos' , $data);

		}
		else return false;
	}


	public function get_user_info($user_id)
	{
		$this->db->from('users');
		$this->db->where('id' , $user_id);
		$results = $this->db->get()->row();
		return $results;
	}

	public function get_photo_name($user_id)
	{
		$this->db->from('users_photos');
		$this->db->where('user_id' , $user_id);
		$res = $this->db->get()->row();
		return $res;
	}

	public function get_user_country_name($country_code)
	{
		$this->db->from('countries');
		$this->db->where('country_code' , $country_code);
		$res = $this->db->get()->row();
		return $res->country_name;
	}

	/**
	 Get all countries information
	 */
	public function get_countries()
	{
		$this->db->from('countries');
		$this->db->order_by('country_name' , 'asc');
		$query = $this->db->get()->result();
		return $query;
	}

	public function get_user_photos($user_id)
	{
		$this->db->from('users_photos');
		$this->db->where('user_id' , $user_id);
		$results = $this->db->get()->row();
		return $results;
	}
}
?>
