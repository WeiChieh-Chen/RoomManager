<?php
Class Time_period extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function getTime()
    {
    	$query  = $this->db->get("time_period");
	    return $query->result();
    }
}

