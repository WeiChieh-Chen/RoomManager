<?php
class Timeperiod extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function getPeriod(){
        return $this->db->get('time_period')->result();
    }

}