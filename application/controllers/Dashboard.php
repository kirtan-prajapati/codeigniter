<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public $loginUser;
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        if(!$this->session->userdata('logged_in')){
        	return redirect(base_url('user/login'));
        }else{
        	$this->loginUser = $this->session->userdata();
        }
    }

	public function index()
	{
		$data['user'] = $this->loginUser;
		$this->load->view('welcome_message',$data);
	}
}
