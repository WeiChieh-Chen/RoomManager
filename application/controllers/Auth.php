<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function login(){
        $this->load->model("manager");
        $this->manager->validate($this->input->post('account'),$this->input->post('password'));
        // TODO: Because my environment is run in the virtual machine, so it would translate for uri to 192.168.10.10 and let path of file of parse become invalid.
//        header("Location: /Home");
        return redirect("/Admin");
    }

    public function logout(){
        $this->session->sess_destroy();
//        header("Location: /Home");
        return redirect("/Home");
    }
}