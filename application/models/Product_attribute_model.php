<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_attribute_model extends CI_Model {
	public function store($data){
		$data = array(
	        'product_id' => $data['product_id'],
	        'attribute_id' => $data['attribute_id'],
		);
		$this->db->insert('product_attribute', $data);
		return $this->db->insert_id();
	}
}
