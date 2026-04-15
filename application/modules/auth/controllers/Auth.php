<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Module scaffold copy of application/controllers/Auth.php
// Note: To enable HMVC, install Modular Extensions (Wiredesignz) and
// change this class to extend MX_Controller instead of CI_Controller.
class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        // Auth controller only needs the user model for login/signup.
        $this->load->model('User_model');
    }

    public function authenticate(){
        // Login action expects a POST request from the login form.

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
            redirect('products');
        }

        $this->session->set_flashdata('error', 'Invalid email or password.');
        redirect('login');
    }

    public function login(){
        if ($this->isLoggedIn()) {
            redirect('dashboard');
        }

        $data['title'] = 'Login';
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('templates/header', $data);
        $this->load->view('auth/login', $data);
        $this->load->view('templates/footer');
    }

    public function signup(){
        if ($this->isLoggedIn()) {
            redirect('dashboard');
        }

        $data['title'] = 'Sign Up';
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('templates/header', $data);
        $this->load->view('auth/signup', $data);
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
            redirect('products');
        }

        $this->session->set_flashdata('error', 'Unable to create account. Please try again.');
        redirect('signup');
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('login');
    }

    // Check whether the user session is active
    private function isLoggedIn(){
        return $this->session->has_userdata('user_id');
    }
}
