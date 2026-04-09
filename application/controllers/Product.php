<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Product_model');
    }

    public function index(){
        $data['products'] = $this->Product_model->getAllProducts();
        $data['title'] = 'Product List';
        $this->load->view('products/index', $data);
    }

    public function create(){
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->Product_model->createProduct([
                'title' => $this->input->post('title', true),
                'description' => $this->input->post('description', true)
            ]);
        }

        redirect('product');
    }

    public function update(){
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->Product_model->updateProduct($this->input->post('id', true), [
                'title' => $this->input->post('title', true),
                'description' => $this->input->post('description', true)
            ]);
        }

        redirect('product');
    }

    public function delete(){
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->Product_model->deleteProduct($this->input->post('id', true));
        }

        redirect('product');
    }
}