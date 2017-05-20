<?php
Class Manager extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function validate($account,$password){
        $query = $this->db->where([ "account" => $account,"password" => $password])->get("manager");
        $row = $query->result()[0];
        if($row){
            $this->session->name = $row->name;
            $this->session->set_flashdata("LoginState","SUCCESS");
        }else {
            $this->session->set_flashdata("LoginState","NOPE");
        }
    }
}

