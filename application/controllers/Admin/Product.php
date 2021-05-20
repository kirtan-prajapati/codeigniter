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
        $this->load->library('form_validation');
    }

	public function index()
	{
		$data['user'] = $this->loginUser;
        $data['productList'] = $this->Product_model->getAllProducts();
        /*echo "<pre>";
        print_r($data['productList']);
        die();*/
        $this->load->view($this->viewPath.'includes/header');
        $this->load->view($this->viewPath.'product/index',$data);
        $this->load->view($this->viewPath.'includes/footer');
	}

    public function add()
    {
        $data['user'] = $this->loginUser;
        $data['title'] = 'Add Product';
        $this->load->view($this->viewPath.'includes/header');
        $this->load->view($this->viewPath.'product/add',$data);
        $this->load->view($this->viewPath.'includes/footer');
    }

    public function edit($id)
    {
        $data['user'] = $this->loginUser;
        $data['title'] = 'Edit Product';

        $data['product'] = $this->Product_model->product(['id'=>$id]);
        $data['productImages'] = $this->Product_images_model->getProductImages(['product_id'=>$id]);
        $data['productAttributes'] = $this->Product_attribute_model->getProductAttributes(['product_id'=>$id]);
        /*echo "<pre>";
        print_r($data);*/

        $this->load->view($this->viewPath.'includes/header');
        $this->load->view($this->viewPath.'product/edit',$data);
        $this->load->view($this->viewPath.'includes/footer');
    }

    public function store(){
        $input = $this->input->post();
        $response = ['status'=>'error','message'=>'Something went wrong!'];
        $isValid = $this->productValidationCheck();
        if(!$isValid){
            return $this->add();
        }
        $product_id = $this->Product_model->store($input);
        if($product_id){
            $response = ['status'=>'success','message'=>'Product added successfully!'];
            $images = $_FILES['images'];
            $this->do_upload_multiple_files($images,$product_id);

            foreach ($input['attribute_name'] as $key => $attrName) {
                if(empty(trim($attrName)) || empty($input['attribute_value'][$key])){
                   continue;
                }
                $attr = [];
                $attr['name'] = $attrName;
                $attr['value'] = $input['attribute_value'][$key];
                $attrId = $this->Attribute_model->store($attr);
                $proAttr = [];
                $proAttr['product_id'] = $product_id;
                $proAttr['attribute_id'] = $attrId;
                $this->Product_attribute_model->store($proAttr);
            }
            $this->session->set_flashdata('messageAlert', $response);
            redirect(base_url('admin/product'));
        }
    }

    public function update(){
        $input = $this->input->post();
        $response = ['status'=>'error','message'=>'Something went wrong!'];
        $product_id = $input['id'];
        $isValid = $this->productValidationCheck();
        if(!$isValid){
            return $this->edit($input['id']);
        }
        $isProUpdated = $this->Product_model->store($input, $product_id);
        if($isProUpdated){
            $response = ['status'=>'success','message'=>'Product updated successfully!'];
            $images = $_FILES['images'];
            $this->do_upload_multiple_files($images,$product_id);

            foreach ($input['attribute_name'] as $key => $attrName) {
                if(empty(trim($attrName)) || empty($input['attribute_value'][$key])){
                   continue;
                }
                $attr = [];
                $attr['name'] = $attrName;
                $attr['value'] = $input['attribute_value'][$key];
                if(!empty($input['attribute_id']) && !empty($input['attribute_id'][$key])){
                    $attrId = $input['attribute_id'][$key];
                    $this->Attribute_model->store($attr, $attrId);
                }else{
                    $attrId = $this->Attribute_model->store($attr);
                    $proAttr = [];
                    $proAttr['product_id'] = $product_id;
                    $proAttr['attribute_id'] = $attrId;
                    $this->Product_attribute_model->store($proAttr);
                }
            }
        }
        $this->session->set_flashdata('messageAlert', $response);
        redirect(base_url('admin/product'));
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

    public function productValidationCheck(){
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Product Name',
                'rules' => 'required|min_length[3]|max_length[100]'
            ),
            array(
                'field' => 'code',
                'label' => 'Product code',
                'rules' => 'required|exact_length[6]'
            ),
            array(
                'field' => 'price',
                'label' => 'Product price',
                'rules' => 'required|decimal'
            ),
            /*array(
                'field' => 'images[]',
                'label' => 'Product image',
                'rules' => 'required'
            ),*/
            array(
                'field' => 'description',
                'label' => 'Product description',
                'rules' => 'required|max_length[500]'
            ),
        );

        $this->form_validation->set_rules($config);
        return $this->form_validation->run();
    }

    public function removeAttr(){
        $data = $this->input->post();
        $isRelationRemoved = $this->Product_attribute_model->delete($data);
        if($isRelationRemoved){
            $this->Attribute_model->delete($data['attribute_id']);
            echo json_encode(['status'=>'success', 'message'=> 'Attribute has been removed successfully!']);
        }else{
            echo json_encode(['status'=>'error', 'message'=> 'Something went wrong. Please try again!']);
        }
    }

    public function changeImage(){
        $product_id = $this->input->post('product_id');
        $imgId = $this->input->post('id');
        $this->config->load('product');
        $config = $this->config->item('fileupload');
        $this->load->library('upload', $config);

        $response = ['status'=>'error', 'message'=>'Something went wrong!'];
        
        if (!$this->upload->do_upload('file')){
            $response = ['status'=>'error', 'message'=> $this->upload->display_errors()];
        }else{
            $uploaded_data = $this->upload->data();
            $imgRecord = $this->Product_images_model->getProImgFromID($imgId);

            if(!empty($imgRecord)){
                $imgPath = PRODUCT_IMAGE_PATH.$imgRecord['image'];
                @unlink($imgPath);
            }

            $imagedata = [];
            $imagedata['image'] = $uploaded_data['file_name'];
            $imagedata['product_id'] = $imgRecord['product_id'];

            $result = $this->Product_images_model->store($imagedata,$imgId);

            if($result){
                $imageURL = base_url(PRODUCT_IMAGE_PATH.$imagedata['image']);
                $response = ['status'=>'success', 'message'=>'Image updated successfully!', 'image'=>$imageURL];
            }
        }

        echo json_encode($response);
    }

    public function deleteImages(){
        $ids = $this->input->post('ids');
        $records = $this->Product_images_model->getImagesUsingWhereIn($ids);
        foreach ($records as $key => $imgRecord) {
            $imgPath = PRODUCT_IMAGE_PATH.$imgRecord['image'];
            @unlink($imgPath);
        }
        $isDeleted = $this->Product_images_model->delete($ids);
        if($isDeleted){
            echo json_encode(['status'=>'success','message'=>'Images deleted successfully!']);
        }else{
            echo json_encode(['status'=>'error','message'=>'Something went wrong!']);
        }
    }

    public function delete($id){
        $id = base64_decode($id);
        $isDeleted = $this->Product_model->destroy($id);
        if($isDeleted){
            $response = ['status'=>'success','message'=>'Product deleted successfully!'];
        }else{
            $response = ['status'=>'error','message'=>'Something went wrong!'];
        }

        $this->session->set_flashdata('messageAlert', $response);
        redirect(base_url('admin/product'));
    }
}
