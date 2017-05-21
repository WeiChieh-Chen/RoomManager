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
        $rooms = [];
        foreach ($this->classroom->getRoom() as $room){
            $rooms[$room->room_id] = [
                "status" => "NORMAL",
                "info" =>[
                    "room_name" => $room->room_name,
                    "active" => $room->active
                ]
            ];
        }
        $data = [
            "classroom" =>  $rooms
        ];

        $this->load->view('layouts/header',$this->data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/room_status',$data);
        $this->load->view('layouts/footer');
    }

    public function uploadData(){
        $this->load->model('classroom');
        $get_data = $this->input->post();

        foreach ($get_data as $room_id => $room){
            switch($room['status']){
                case "INSERT":
                    $this->classroom->create($room_id,$room['info']);
                    break;
                case "UPDATE":
                    $this->classroom->update($room_id,$room['info']);
                    break;
                case "DELETE":
                    $this->classroom->delete($room_id);
                    break;
                default:
                    break;
            }
        }
    }
}