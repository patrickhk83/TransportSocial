<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function upload($fieldname) {
    $config['upload_path'] = "./uploads/";
    $config['allowed_types'] = "gif|jpg|png";
    $config['max_width'] = '4000';
    $config['max_size'] = '10000';
    $config['max_height'] = '4000';
    $config['remove_spaces'] = TRUE;
    $this->load->library('upload' , $config);
    if($this->upload->do_upload($fieldname)) {
      $image_data = $this->upload->data();
      $image_data['url'] = ltrim($config['upload_path'], '.').$image_data['file_name'];
      return $image_data;
    }
    else {
      return $this->upload->display_errors();
    }

  }

}
