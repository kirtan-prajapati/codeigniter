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

	public function getProductAttributes($params=[]){
		$this->db->select('product_attribute.*,attribute.name,attribute.value');
		$this->db->join('attribute', 'attribute.id = product_attribute.attribute_id', 'left');

		$this->db->where('product_attribute.product_id',$params['product_id']);
		$query = $this->db->get('product_attribute');
		return $query->result_array();
	}

	public function delete($params=[]){
		if(!empty($params['product_id']) && !empty($params['attribute_id'])){
			$this->db->where('product_id', $params['product_id']);
			$this->db->where('attribute_id', $params['attribute_id']);
			return $this->db->delete('product_attribute');
		}else{
			return false;
		}
	}
}
