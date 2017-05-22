<?php
Class Section extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function getClass(){
        $query = $this->db->get("section");
        return $query->result();
    }
}

