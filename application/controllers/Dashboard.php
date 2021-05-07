<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public $loginUser;
    public $viewPath;
    public function __construct()
    {
        parent::__construct();
        $this->viewPath = '';
        // Your own constructor code
        if(!$this->session->userdata('logged_in')){
        	return redirect(base_url('user/login'));
        }else{
        	$this->loginUser = $this->session->userdata();
            if($this->loginUser['role'] == 1){
                $this->viewPath = 'admin/';
            }
        }
    }

	public function index()
	{
		$data['user'] = $this->loginUser;
        $this->load->view($this->viewPath.'includes/header');
        $this->load->view($this->viewPath.'dashboard',$data);
        $this->load->view($this->viewPath.'includes/footer');
	}
}
