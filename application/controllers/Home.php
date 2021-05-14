<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Product_model','Product_images_model','Attribute_model','Product_attribute_model']);
        $this->load->library('cart');
    }

	public function index(){
        $data['productList'] = $this->Product_model->getAllProducts();
        $this->load->view('includes/header');
		$this->load->view('index', $data);
        $this->load->view('includes/footer');
	}

    public function addCart(){
        $product_id = $this->input->post('product_id');
        $quantity = $this->input->post('quantity');
        $product = $this->Product_model->product(['id'=>$product_id]);

        $imageURL = base_url(DEFAULT_PRODUCT_IMAGE);
        if(!empty($product['image']) && file_exists(PRODUCT_IMAGE_PATH.$product['image'])){
            $imageURL = base_url(PRODUCT_IMAGE_PATH.$product['image']);
        }
        
        $data = array(
            'id'      => $product['id'],
            'qty'     => $quantity,
            'price'   => $product['price'],
            'name'    => $product['name'],
            'image'    => $imageURL
            //'options' => array('Size' => 'L', 'Color' => 'Red')
        );

        $this->cart->insert($data);
        echo json_encode(['status'=>'success', 'message'=>'Product added successfully in your cart!']);
    }

    public function updateShoppingCartMenu(){
        $cartItems = $this->cart->contents();
        $data['count'] = count($cartItems);
        $data['html'] = $this->load->view('includes/shopping_cart','' , TRUE);
        //echo "<pre>";
        //print_r($cartItems);
        /*print_r($cartItems);
        die();*/
        echo json_encode($data);
    }
}
