<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	public function store($data){
		$data = array(
	        'name' => $data['name'],
	        'email' => $data['email'],
	        'password' => md5($data['password'])
		);
		$this->db->insert('users', $data);
		return $this->db->insert_id();
	}

	public function authCheck($data){
		$data = array(
	        'email' => $data['email'],
	        'password' => md5($data['password'])
		);
		$this->db->select('*');
		$this->db->where($data);
		$query = $this->db->get('users');
		return $query->result();
	}
}
