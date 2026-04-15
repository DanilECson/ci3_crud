<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('User_model');
        $this->load->model('Product_model');
    }

    private function isLoggedIn(){
        return $this->session->has_userdata('user_id');
    }

    private function requireLogin(){
        if (!$this->isLoggedIn()) {
            redirect('login');
        }
    }

    // Dashboard home page for logged-in users.
    public function index(){
        $this->requireLogin();
        $data['title'] = 'Dashboard';
        $data['products'] = $this->Product_model->getAllProducts();
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function profile(){

        $this->requireLogin();
        $data['title'] = 'Profile';
        $data['user'] = $this->User_model->getUserById($this->session->userdata('user_id'));
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/profile', $data);
        $this->load->view('templates/footer');
    }

    public function updateProfile(){
        $this->requireLogin();

        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('profile');
        }

        $id = $this->session->userdata('user_id');
        $firstName = $this->input->post('firstName', true);
        $lastName = $this->input->post('lastName', true);

        $this->User_model->updateUser($id, [
            'firstName' => $firstName,
            'lastName' => $lastName
        ]);

        $this->session->set_userdata('user_name', trim($firstName . ' ' . $lastName));
        redirect('profile');
    }
}
