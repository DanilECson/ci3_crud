<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Product_model');
        $this->load->model('User_model');
    }

    private function isLoggedIn(){
        return $this->session->userdata('user_id') !== false;
    }

    private function requireLogin(){
        if (!$this->isLoggedIn()) {
            redirect('login');
        }
    }

    public function login(){
        if ($this->isLoggedIn()) {
            redirect('dashboard');
        }

        $data['title'] = 'Login';
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('templates/header', $data);
        $this->load->view('pages/login', $data);
        $this->load->view('templates/footer');
    }

    public function signup(){
        if ($this->isLoggedIn()) {
            redirect('dashboard');
        }

        $data['title'] = 'Sign Up';
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('templates/header', $data);
        $this->load->view('pages/signup', $data);
        $this->load->view('templates/footer');
    }

    public function register(){
        if ($this->isLoggedIn()) {
            redirect('dashboard');
        }

        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('signup');
        }

        $firstName = $this->input->post('firstName', true);
        $lastName = $this->input->post('lastName', true);
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);
        $confirm = $this->input->post('confirm_password', true);

        if (empty($firstName) || empty($email) || empty($password)) {
            $this->session->set_flashdata('error', 'Please fill in all required fields.');
            redirect('signup');
        }

        if ($password !== $confirm) {
            $this->session->set_flashdata('error', 'Passwords do not match.');
            redirect('signup');
        }

        if ($this->User_model->getUserByEmail($email)) {
            $this->session->set_flashdata('error', 'An account with that email already exists.');
            redirect('signup');
        }

        $this->User_model->createUser([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        $user = $this->User_model->getUserByEmail($email);
        if ($user) {
            $this->session->set_userdata([
                'user_id' => $user['id'],
                'user_name' => $user['firstName'] . ' ' . $user['lastName'],
                'user_email' => $user['email']
            ]);
            redirect('product');
        }

        $this->session->set_flashdata('error', 'Unable to create account. Please try again.');
        redirect('signup');
    }

    public function authenticate(){
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('login');
        }

        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);
        $user = $this->User_model->getUserByEmail($email);

        if ($user && $this->User_model->verifyPassword($password, $user['password'])) {
            $this->session->set_userdata([
                'user_id' => $user['id'],
                'user_name' => $user['firstName'] . ' ' . $user['lastName'],
                'user_email' => $user['email']
            ]);
            redirect('product');
        }

        $this->session->set_flashdata('error', 'Invalid email or password.');
        redirect('login');
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('login');
    }

    public function dashboard(){
        $this->requireLogin();
        $data['title'] = 'Dashboard';
        $data['products'] = $this->Product_model->getAllProducts();
        $this->load->view('templates/header', $data);
        $this->load->view('pages/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function profile(){
        $this->requireLogin();
        $data['title'] = 'Profile';
        $data['user'] = $this->User_model->getUserById($this->session->userdata('user_id'));
        $this->load->view('templates/header', $data);
        $this->load->view('pages/profile', $data);
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
