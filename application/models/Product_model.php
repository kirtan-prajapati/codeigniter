<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
	public function store($data, $product_id=NULL){
		$data = array(
	        'name' => $data['name'],
	        'code' => $data['code'],
	        'price' => $data['price'],
	        'description' => $data['description'],
		);
		if(!empty($product_id)){
			$this->db->where('id', $product_id);
			return $this->db->update('products', $data);
		}else{
			$this->db->insert('products', $data);
			return $this->db->insert_id();
		}
	}

	public function getAllProducts(){
		$this->db->select('products.*,product_images.image');
		$this->db->join('product_images', 'product_images.product_id = products.id', 'left');
		$this->db->group_by("products.id");
		$this->db->order_by('products.id', 'DESC');
		$query = $this->db->get('products');
		return $query->result_array();
	}

	public function product($params = []){
		$this->db->select('*');
		$this->db->where('id',$params['id']);
		$query = $this->db->get('products');
		return $query->row_array();
	}
}
