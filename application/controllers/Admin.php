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
	
	public function course() {
        $this->load->model("ClassRoom");
        $this->load->model("Time_period");
        $this->load->model("Section");
		$this->session->set_flashdata("uploadState","");
		
		$this->load->view('layouts/header',$this->data);
		$this->load->view('layouts/navbar');
		$this->load->view('pages/course');
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

	public function uploadClass(){
		$this->load->model("Section");
		$this->load->library('excel');
		$file = $_FILES['upload'];
		// $file = "./class.xlsx";
		$this->session->set_flashdata("uploadState","");
		if(move_uploaded_file($file['tmp_name'],"./uploads/".$file['name'])){
			$inputFileName = "./uploads/".$file['name'];

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
					if($column == "date"){
						$data_value = PHPExcel_Shared_Date::ExcelToPHPObject($data_value)->format('Y-m-d');						
						// echo "<br>";
					}
					// echo $data_value." ";
					$arr_data[$row][$column] = $data_value;
					$this->session->set_flashdata("uploadState","SUCCESS");
				}
			}
			 $this->Section->insert_xml($arr_data);

		}else{
			$this->session->set_flashdata("uploadState","NOPE");
		}
		
		redirect(base_url("Admin/course"), 'replace');

	}

}