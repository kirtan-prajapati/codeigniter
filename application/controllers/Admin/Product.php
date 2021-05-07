<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

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
        $this->load->model(['Product_model','Product_images_model','Attribute_model','Product_attribute_model']);
    }

	public function index()
	{
		$data['user'] = $this->loginUser;
        $this->load->view($this->viewPath.'includes/header');
        $this->load->view($this->viewPath.'product/index',$data);
        $this->load->view($this->viewPath.'includes/footer');
	}

    public function add()
    {
        $data['user'] = $this->loginUser;
        $this->load->view($this->viewPath.'includes/header');
        $this->load->view($this->viewPath.'product/add',$data);
        $this->load->view($this->viewPath.'includes/footer');
    }

    public function store(){
        $input = $this->input->post();
        $product_id = $this->Product_model->store($input);
        if($product_id){
            $images = $_FILES['images'];
            $this->do_upload_multiple_files($images,$product_id);

            foreach ($input['attribute_name'] as $key => $attrName) {
                $attr = [];
                $attr['name'] = $attrName;
                $attr['value'] = $input['attribute_value'][$key];
                $attrId = $this->Attribute_model->store($attr);
                $proAttr = [];
                $proAttr['product_id'] = $product_id;
                $proAttr['attribute_id'] = $attrId;
                $this->Product_attribute_model->store($proAttr);
            }

            redirect(base_url('admin/product'));
        }
    }

    public function do_upload_multiple_files($images,$product_id){
            $this->config->load('product');
            $config = $this->config->item('fileupload');

            foreach ($images['name'] as $key => $image) {
                $_FILES['proimage']['name']= $images['name'][$key];
                $_FILES['proimage']['type']= $images['type'][$key];
                $_FILES['proimage']['tmp_name']= $images['tmp_name'][$key];
                $_FILES['proimage']['error']= $images['error'][$key];
                $_FILES['proimage']['size']= $images['size'][$key];
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('proimage')){
                    $imagedata = array('error' => $this->upload->display_errors());
                }else{
                    $uploaded_data = $this->upload->data();
                    $imagedata = [];
                    $imagedata['image'] = $uploaded_data['file_name'];
                    $imagedata['product_id'] = $product_id;
                    $this->Product_images_model->store($imagedata);
                }
            }
    }
}
