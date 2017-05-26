<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url','form','date']);
        $this->load->library('session');
    }

    public function index(){
        $this->load->model(['classroom','timeperiod']);
        $data= [
            'title' => "教室租用系統",
            'color' => "gray"
        ];

        $dropdown=[];
        foreach ($this->classroom->getRoom() as $room){
            $dropdown['rooms'][] = [
                'name' => $room->room_id,
                'value' => $room->room_id
            ];
        }

        foreach ($this->timeperiod->getPeriod() as $unit){
            if($unit->start === "12:00") {
                $dropdown['periods'][] = [
                    'name' => "中午休息時間",
                    'value' => $unit->period_id
                ];
            }
            else {
                $dropdown['periods'][] = [
                    'name' => "第{$unit->period_id}節",
                    'value' => $unit->period_id
                ];
            }
        }

        $this->load->view('layouts/header',$data);
        $this->load->view('layouts/navbar',$dropdown);
        $this->load->view('pages/home');
        $this->load->view('layouts/footer');
    }

    public function apply(){
        $post = $this->input->post();
        $this->load->model(['borrower','application']);
        if(is_null($this->borrower->find($post['sNumber']))){
            $data = [
                'student_id' => $post['sNumber'],
                'email' => $post['email'],
                'name' => $post['sName'],
                'cellphone' => $post['cellphone'],
                'department' => $post['department']
            ];
            $this->borrower->create($data);
        }

        date_default_timezone_set('Asia/Taipei');
        $data = [
            'room_id' => $post['room_id'],
            'student_id' => $post['sNumber'],
            'reason' => $post['events'],
            'teacher' => $post['teacher'],
            'borrow_date' => $post['date'],
            'borrow_start' => $post['start_sec'],
            'borrow_end' => $post['end_sec'],
            'apply_time' => date("Y-m-d H:i:s",time())
        ];
        $this->application->create($data);

    }

}