<?php
class Useropt_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function save_photo($user_id, $path)
	{
		$data = array(
			'user_id' => $user_id,
			'path' => $path
		);
		$this->db->insert('users_photos' , $data);
		return $this->db->insert_id();
	}

	public function get_countries($country_code = null)
	{
		$this->db->from('countries');
		if(isset($country_code)) {
			$this->db->where('country_code', $country_code);
		}
		return $this->db->get()->result();
	}

	public function get_photos($user_id, $photoId = null)
	{
		$this->db->from('users_photos');
		$this->db->where('user_id' , $user_id);
		if(isset($photoId)) {
			$this->db->where('id' , $photoId);
			return $this->db->get()->row();
		}
		else {
			return $this->db->get()->result();
		}


	}
}
?>
