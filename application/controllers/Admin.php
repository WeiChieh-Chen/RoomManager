<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    protected $data = ['anchor' => "/Admin", 'color' => "blue",'image' => "2339815.jpg"];

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    public function index()
    {
        if(!$this->session->has_userdata('name')){
            return redirect('/Home');
        }

        $reasoncount = array(0, 0, 0, 0, 0, 0, 0);
        $roomBreakcount = array();
        $roomAllbreakcount = array();
        $this->load->model(["classroom", "blacklist","application"]);
        $class = $this->classroom->getRoominfo();
        $reason = $this->blacklist->getBlacklistinfo();

        foreach ($reason as $key => $value) {
            $reasoncount = $this->blacklist->reasoncount($value->reason, $reasoncount);
        }
        foreach ($class as $key => $value) {
            $roomBreakcount[] = $this->blacklist->getroomBreak($value['room_id']);
            $roomAllbreakcount[] = $this->blacklist->getroomAllbreak($value['room_id']);
        }

//        foreach ($class as $key => $row) {
//                echo $row['borrow_count'];
//        }

        $this->session->noaudit = $this->application->getNoAuditCount();

        $this->data['title'] = "教室數據統計";
        $data = [
            'calssroom' => $class,
            'reasoncount' => $reasoncount,
            'roomBreakcount' => $roomBreakcount,
            'roomAllbreakcount' => $roomAllbreakcount
        ];

        $this->load->view('layouts/header');
        $this->load->view('layouts/navbar', $this->data);
        $this->load->view('pages/ad_home', $data);
        $this->load->view('layouts/footer');
    }


    public function RoomStatus()
    {
        $this->load->model('classroom');
        $rooms = [];
        foreach ($this->classroom->getRoom() as $room) {
            $rooms[$room->room_id] = [
                "status" => "NORMAL",
                "info" => [
                    "room_name" => $room->room_name,
                    "active" => $room->active
                ]
            ];
        }
        $data = ["classroom" => $rooms];
        $this->data['title'] = "教室狀態";
        $this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/room_status', $data);
        $this->load->view('layouts/footer');
    }

    public function course()
    {
	    $this->load->model(['classroom','timeperiod','section']);

        $this->data['title'] = "課表設定";
	    $dropdown=[];
	    foreach ($this->classroom->getRoom() as $room){
		    $dropdown['rooms'][] = [
			    'name' => $room->room_id,
			    'id'   => $room->room_id,
			    'value' => $room->room_id
		    ];
	    }
        $this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/course',$dropdown);
        $this->load->view('layouts/footer');
    }


    public function showBlacklist()
    {
        $reasonlist = array();
        $this->load->model("blacklist");
        $blacklist = $this->blacklist->getBlacklistinfo();
        foreach ($blacklist as $key => $value) {
            $reasonlist[] = $this->blacklist->reasonString($value->reason);
        }
        $data = ['blacklist' => $blacklist, 'reasonlist' => $reasonlist];

        $this->data['title'] = "黑名單列表";
        $this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/blacklist', $data);
        $this->load->view('layouts/footer');
    }


    public function uploadData()
    {
        $this->load->model('classroom');
        $get_data = $this->input->post();

        foreach ($get_data as $room_id => $room) {
            switch ($room['status']) {
                case "INSERT":
                    $this->classroom->create($room_id, $room['info']);
                    break;
                case "UPDATE":
                    $this->classroom->update($room_id, $room['info']);
                    break;
                case "DELETE":
                    $this->classroom->delete($room_id);
                    break;
                default:
                    break;
            }
        }
    }

    public function importClass()
    {
        $this->load->model("Section");
        $this->load->library('excel');
        $file = $_FILES['upload'];
        // $file = "./class.xlsx";
        if (move_uploaded_file($file['tmp_name'], "./uploads/" . $file['name'])) {
            $inputFileName = "./uploads/" . $file['name'];

            $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

            //get only the Cell Collection
            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

            foreach ($cell_collection as $cell) {
                $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

                switch ($column) { //Change row's name to db's schema
                    case 'A':
                        $column = "date";
                        break;
                    case 'B':
                        $column = "room_id";
                        break;
                    case 'C':
                        $column = "start";
                        break;
                    case 'D':
                        $column = "end";
                        break;
                }

                //header will/should be in row 1 only. of course this can be modified to suit your need.
                if ($row == 1) {
                    $header[$row][$column] = $data_value;
                } else {
                    if ($column == "date") {
                        $data_value = PHPExcel_Shared_Date::ExcelToPHPObject($data_value)->format('Y-m-d');
                        // echo "<br>";
                    }
                    // echo $data_value." ";
                    $arr_data[$row][$column] = $data_value;
                }
            }
            $this->Section->insert_xml($arr_data);

        } else {
        
        }

        redirect(base_url("Admin/course"), 'replace');

    }

    public function insertBlacklist()
    {
        $this->load->model("blacklist");
        $reasonlist = "";
        for ($i = 1; $i < 8; $i++) {
            if ($this->input->post('reason' . $i) != '') {
                $reasonlist = $reasonlist . "" . $this->input->post('reason' . $i) . ",";
            }
        }
        $reasonlist = substr($reasonlist, 0, strlen($reasonlist) - 1);

        $this->db->set(['student_id' => $this->input->post('stduentID'), 'room_id' => $this->input->post('roomID'), 'reason' => $reasonlist]);
        $this->db->insert('blacklist');


        return redirect("/Admin/showBlacklist");
    }

    public function Audit(){
        $this->load->model(['borrower','application']);

        $data = [
            'list' => $this->application->getNoAudit(),
            'namelist' => $this->borrower->getNameList()
        ];

        $this->session->noaudit = $this->application->getNoAuditCount();

        $this->data['title'] = "審核列表";
        $this->load->view('layouts/header', $this->data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/audit',$data);
        $this->load->view('layouts/footer');
    }

    public function Audit_Sending(){
        $this->load->model(['application','section']);
        foreach ($this->input->post() as $id => $info) {
            $this->application->updateData($id,$info['result']);
        }

        $table = $this->application->getEmailInfo();
        
        $data = [];
        foreach ($this->input->post() as $id => $info) {
            if($info['result'] === "0"){
                $table[$id]["reason"] = $info['reason'];
            } else {
                $this->section->insertData([
                    'room_id' => $table[$id]['room_id'],
                    'date' => $table[$id]['borrow_date'],
                    'start' => $table[$id]['borrow_start'],
                    'end' => $table[$id]['borrow_end']
                ]);
            }
            $data[] = $table[$id];
        }

        $this->session->set_flashdata('audit_list',$data);
        return redirect("Email/replyMail");
    }

    public function searchRoom(){
	    $post = $this->input->post();
	    $this->load->model(["section",'application','time_period']);
	    $data = [
		    "class_data"    =>  $this->section->search_class($post['start'],$post['end'],$post['room_id']),
		    "period"        =>  $this->time_period->getTime()
	    ];
	
	    echo json_encode($data);
    }
	
	public function update_class()
	{
		$post = $this->input->post();
		$this->load->model("section");
		$temp = $post['data'];
		$end =  $post['endDate'];
		$count = sizeof($post['data']);
		foreach ($post['data'] as $key => $data){
			$arr = explode("-",$data['date']);
			while(1){
				$nextDay = date("Y-m-d",mktime(0,0,0,$arr[1],$arr[2]+7,$arr[0]));
				if(date($end) > date($nextDay)){//next day
					$arr[2] += 7;
					$this->section->recheck($data["start"],$data["end"],$nextDay,$data["room_id"]);
					$temp[$count]["start"] =$data["start"];
					$temp[$count]["end"] = $data["end"];
					$temp[$count]["date"] = $nextDay;
					$temp[$count]["room_id"] = $data["room_id"];
					$count++;
				}else{      //expire
					break;
				}
			}

		}
		
		$this->section->insert_xml($temp);
		echo "SUCCESS";
	}
}