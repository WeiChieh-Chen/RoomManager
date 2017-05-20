<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    protected $data = [
        'title' => "教室租用系統",
        'color' => "blue"
    ];

    public function __construct(){
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('layouts/header',$this->data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/home');
        $this->load->view('layouts/footer');
    }

    public function RoomStatus(){
        $this->load->model('classroom');

        $data = [
            "classroom" => $this->classroom->getRoom()
        ];

        $this->load->view('layouts/header',$this->data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/room_status',$data);
        $this->load->view('layouts/footer');
    }

}