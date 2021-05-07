<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
	public function store($data){
		$data = array(
	        'name' => $data['name'],
	        'code' => $data['code'],
	        'price' => $data['price'],
	        'description' => $data['description'],
		);
		$this->db->insert('products', $data);
		return $this->db->insert_id();
	}
}
