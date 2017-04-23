<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index(){
        $data['title'] = "教室租用系統登入";

        $this->load->view('layouts/header',$data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/login');
        $this->load->view('layouts/footer');
    }
}