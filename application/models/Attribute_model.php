<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute_model extends CI_Model {
	public function store($data){
		$data = array(
	        'name' => $data['name'],
	        'value' => $data['value'],
		);
		$this->db->insert('attribute', $data);
		return $this->db->insert_id();
	}
}
