<?php
Class Manager extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function validate($account,$password){
        $query = $this->db->where("account",$account)->get("manager");
        if($query){
            foreach ($query->result() as $row){
                $this->session->name = $row->name;
            }
        }
    }
}

