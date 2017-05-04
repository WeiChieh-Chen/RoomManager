<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->library('session');
    }

    public function index(){
        $data['title'] = "教室租用系統";

        $this->load->view('layouts/header',$data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/home');
        $this->load->view('layouts/footer');
    }

    public function login(){
        $this->load->model("manager");
        $this->manager->validate($this->input->post('account'),$this->input->post('password'));
        // TODO: Because my environment is run in the virtual machine, so it would translate for uri to 192.168.10.10 and let path of file of parse become invalid.
        header("Location: /Home");
    }
}