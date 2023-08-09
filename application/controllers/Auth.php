<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');

	}

	public function index () 
	{
		$this->load->view('templates/auth_header');
		$this->load->view('auth/login'); 
		$this->load->view('templates/auth_footer');
	} 

	public function register() {
        $this->form_validation->set_rules('firstname','First Name','trim|required');
        $this->form_validation->set_rules('lastname','Last Name','trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|md5');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|md5');


        $data['title'] = 'Register';

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');

        } else {
            if ($this->user_model->set_user()) {
                $this->session->set_flashdata('msg_success', 'Registration Successful!');
                redirect('users/login');
            } else {
                $this->session->set_flashdata('msg_error', 'Error! Please try again later.');
                redirect('users/registration');
            }
        }
    }
} 