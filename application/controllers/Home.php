<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Product_model','Product_images_model','Attribute_model','Product_attribute_model']);
    }

	public function index(){
        $data['productList'] = $this->Product_model->getAllProducts();
        $this->load->view('includes/header');
		$this->load->view('index', $data);
        $this->load->view('includes/footer');
	}
}
