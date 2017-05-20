<?php
Class Classroom extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function getRoom(){
        $query = $this->db->get("classroom");
        return $query->result();
    }
}