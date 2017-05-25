<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        $reasoncount = array(0,0,0,0,0,0,0);
        $this->load->model("classroom");
        $this->load->model("blacklist");
        $class = $this->db->get("classroom");
        $calssroom = $class->result();
        $reason = $this->db->get("blacklist");
        $blacklist = $reason->result();
        foreach ($blacklist as $key => $value) {
            $reasoncount = $this->blacklist->reasoncount($value->reason,$reasoncount);    
        }

        $data= [
            'title' => "教室租用系統",
            'color' => "blue",
            'calssroom' => $calssroom,
            'reasoncount' => $reasoncount
        ];

        $this->load->view('layouts/header',$data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/ad_home');
        $this->load->view('layouts/footer');
    }
    public function showBlacklist()
    {
        $reasonlist = array();
        $this->load->model("blacklist");
        $query = $this->db->get("blacklist");
        $blacklist = $query->result();
        foreach ($blacklist as $key => $value) {
            $reasonlist[] = $this->blacklist->reasonString($value->reason);    
        }

        $data= [
            'title' => "教室租用系統",
            'color' => "blue",
            'blacklist' => $blacklist,
            'reasonlist' => $reasonlist
        ];

        $this->load->view('layouts/header',$data);
        $this->load->view('layouts/navbar');
        $this->load->view('pages/blacklist');
        $this->load->view('layouts/footer');
    }
    public function insertBlacklist()
    {
        $this->load->model("blacklist");
        $reasonlist = "";
        for($i=1;$i<8;$i++){
            if($this->input->post('reason'.$i) != ''){
                $reasonlist=$reasonlist."".$this->input->post('reason'.$i).",";
            }
        }
        $reasonlist=substr($reasonlist,0,strlen($reasonlist)-1);
        
        $this->db->set(['student_id'=>$this->input->post('stduentID'),'room_id'=>$this->input->post('roomID'),'reason'=>$reasonlist]);
        $this->db->insert('blacklist');


        return redirect("/Admin/showBlacklist");
    }

}