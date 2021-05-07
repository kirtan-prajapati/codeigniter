<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_images_model extends CI_Model {
	public function store($data){
		$data = array(
	        'product_id' => $data['product_id'],
	        'image' => $data['image'],
		);
		$this->db->insert('product_images', $data);
		return $this->db->insert_id();
	}
}
