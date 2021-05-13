<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_images_model extends CI_Model {
	public function store($data, $imgId = NULL){
		$data = array(
	        'product_id' => $data['product_id'],
	        'image' => $data['image'],
		);
		if(!empty($imgId)){
			$this->db->where('id', $imgId);
			return $this->db->update('product_images', $data);
		}else{
			$this->db->insert('product_images', $data);
			return $this->db->insert_id();
		}
	}

	public function getProductImages($params = []){
		$this->db->select('*');
		$this->db->where($params);
		$query = $this->db->get('product_images');
		return $query->result_array();
	}

	public function getImagesUsingWhereIn($ids=[]){
		$this->db->select('*');
		$this->db->where_in('id',$ids);
		$query = $this->db->get('product_images');
		return $query->result_array();
	}

	public function getProImgFromID($id){
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('product_images');
		return $query->row_array();
	}

	public function delete($ids=[]){
		$this->db->where_in('id', $ids);
		return $this->db->delete('product_images');
	}
}
