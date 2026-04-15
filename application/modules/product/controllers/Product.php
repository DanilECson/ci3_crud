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
        $this->load->view('templates/header', $data);
        $this->load->view('product/index', $data);
        $this->load->view('templates/footer');
    }

    public function create(){
        // Create product action receives data from the product create modal form.
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->Product_model->createProduct([
                'title' => $this->input->post('title', true),
                'description' => $this->input->post('description', true)
            ]);
        }

        redirect('products');
    }

    public function update() {
        // Update action receives the product id through a hidden form field.
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('products');
        }

        $id = $this->input->post('id', true);
        if (empty($id)) {
            redirect('products');
        }

        $this->Product_model->updateProduct($id, [
            'title' => $this->input->post('title', true),
            'description' => $this->input->post('description', true)
        ]);

        redirect('products');
    }

    public function delete(){
        // delete action uses the hidden id field from the form

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->Product_model->deleteProduct($this->input->post('id', true));
        }

        redirect('products');
    }
}
