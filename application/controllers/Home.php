<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url','form','date']);
        $this->load->library('session');
    }

    public function index(){
        if($this->session->has_userdata('name')){
            return redirect('/Admin');
        }

        $this->load->model(['classroom','timeperiod']);
        $data= [
            'anchor' => '/Home',
            'title' => '短期申請',
            'color' => "gray",
            'image' => "building-g3.png"
        ];

        $dropdown=[];
        foreach ($this->classroom->getRoom() as $room){
            if($room->active ==='1'){
                $dropdown['rooms'][] = [
                    'name' => $room->room_id,
                    'id'   => $room->room_id,
                    'value' => $room->room_id
                ];
            }
        }
        
	    foreach ($this->timeperiod->getPeriod() as $unit) {
		    if ($unit -> start === "12:00") {
			    $dropdown['periods'][] = [
				    'name' => "中午休息時間({$unit -> start}~{$unit -> end})",
				    'id' => $unit -> period_id."_period",
				    'value' => $unit -> period_id
			    ];
		    } else {
			    $tmp = $unit -> period_id;
			    if ($unit -> start >= "12:00") {
				    $tmp--;
			    }
			    $dropdown['periods'][] = [
				    'name' => "第{$tmp}節&emsp;({$unit -> start}~{$unit -> end})",
				    'id'   => $unit -> period_id."_period",
				    'value' => $unit -> period_id
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
        $this->load->model(['borrower','application','blacklist']);

        $data = [
            'student_id' => $post['sNumber'],
            'email' => $post['email'],
            'name' => $post['sName'],
            'cellphone' => $post['cellphone'],
            'department' => $post['department']
        ];
        if(!$this->blacklist->checklist($data['student_id'])){
            if(is_null($this->borrower->find($post['sNumber']))){
                $this->borrower->create($data);
            }else {
                unset($data['student_id']);
                $this->borrower->update($post['sNumber'],$data);
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
            $this->session->set_flashdata('toManager',[
                "room_id"=> $post['room_id'],
                "email"=> $post['email'],
                "sName"=> $post['sName'],
                "sNumber"=> $post['sNumber'],
                "cellphone"=> $post['cellphone'],
                "teacher"=> $post['teacher'],
                "events"=> $post['events'],
                "isB" => false
            ]);
            return redirect("Email/sendMail");
        }else{
            $this->session->set_flashdata('toManager',[
                "email"=> $post['email'],
                "sName"=> $post['sName'],
                "sNumber"=> $post['sNumber'],
                "isB" => true
            ]);
            return redirect("Email/sendMail");
        }
    }
    
    public function searchRoom() {
	    $post = $this->input->post();
	    $this->load->model(["section",'application','time_period','borrower']);
	    $apply_data = $this->application->search_class($post['start'],$post['end'],$post['room_id']);
	    $borrower_data = [];
	    foreach ($apply_data as $key => $arr){
	    	$borrower_data[$key] = $this->borrower->find($arr->student_id);
	    }
	    $data = [
	        "apply_data"    =>	$apply_data,
		    "borrower_data"    =>	$borrower_data,
		    "class_data"    =>  $this->section->search_class($post['start'],$post['end'],$post['room_id']),
		    "period"        =>  $this->time_period->getTime()
	    ];

	    echo json_encode($data);
    }
	
	public function searchDate() {
		$post = $this->input->post();
		$this->load->model(["section",'application','time_period','classroom','borrower']);
		$apply_data = $this->application->search_date($post['start']);
		$borrower_data = [];
		foreach ($apply_data as $key => $arr){
			$borrower_data[$key] = $this->borrower->find($arr->student_id);
		}
		$data = [
			"apply_data"    =>	$apply_data,
			"borrower_data" =>  $borrower_data,
			"class_data"    =>  $this->section->search_date($post['start']),
			"period"        =>  $this->time_period->getTime(),
			"classroom"     =>  []
		];
		foreach ($this->classroom->getRoom() as $key => $room){
			if($room->active ==='1'){
				$data['classroom'][$key] = $room;
			}
		}
		echo json_encode($data);
	}
	
	public function searchBoth() {
		$post = $this->input->post();
		$this->load->model(["section",'application','time_period','borrower']);
		$apply_data = $this->application->search_both($post['start'],$post['room_id']);
		$borrower_data = [];
		foreach ($apply_data as $key => $arr){
			$borrower_data[$key] = $this->borrower->find($arr->student_id);
		}
		$data = [
			"apply_data"    =>	$apply_data,
			"borrower_data" =>  $borrower_data,
			"class_data"    =>  $this->section->search_both($post['start'],$post['room_id']),
			"period"        =>  $this->time_period->getTime()
		];
		
		echo json_encode($data);
	}
}