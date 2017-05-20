<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->library('session');
    }

    public function index() {
        $data= [
            'title' => "教室租用系統",
            'color' => "blue"
        ];

        $this->load->view('layouts/header',$data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/home');
        $this->load->view('layouts/footer');
    }

}