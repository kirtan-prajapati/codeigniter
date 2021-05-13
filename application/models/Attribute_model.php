<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute_model extends CI_Model {
	public function store($data, $attribute_id=NULL){
		$data = array(
	        'name' => $data['name'],
	        'value' => $data['value'],
		);
		if(!empty($attribute_id)){
			$this->db->where('id', $attribute_id);
			return $this->db->update('attribute', $data);
		}else{
			$this->db->insert('attribute', $data);
			return $this->db->insert_id();
		}
	}

	public function delete($attribute_id){
		if(!empty($attribute_id)){
			$this->db->where('id', $attribute_id);
			return $this->db->delete('attribute');
		}else{
			return false;
		}
	}
}
