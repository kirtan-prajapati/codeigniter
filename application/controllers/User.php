<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('User_model');
	}
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function register(){
		$this->load->view('includes/header');
		$this->load->view('register');
		$this->load->view('includes/footer');
	}

	public function store(){
		$check = $this->userValidationCheck();
		if($check == False){
			$this->load->view('includes/header');
			$this->load->view('register');
			$this->load->view('includes/footer');
		}else{
			$data = $this->input->post();
			$result = $this->User_model->store($data);
			return redirect(base_url('user/login'));
		}
	}

	public function login(){
		$this->load->view('includes/header');
		$this->load->view('login');
		$this->load->view('includes/footer');
	}

	public function loginCheck(){
		$data = $this->input->post();
		$result = $this->User_model->authCheck($data);
		if($result){
			$user = [
				'name'=>$result[0]->name,
				'email'=>$result[0]->email,
				'login_id'=>$result[0]->id,
				'logged_in' => true
			];

			$this->session->set_userdata($user);
			return redirect(base_url());
		}else{
			return redirect(base_url('user/login'));
		}
	}

	public function userValidationCheck(){
		$config = array(
	        array(
                'field' => 'name',
                'label' => 'Username',
                'rules' => 'required'
	        ),
	        array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide a %s.',
                ),
	        ),
		    array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required'
	        )
		);

		$this->form_validation->set_rules($config);
		return $this->form_validation->run();
	}
}
