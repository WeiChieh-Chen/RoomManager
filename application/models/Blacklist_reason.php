<?php
Class Blacklist_reason extends CI_Model
{
    private $table = 'blacklist_reason';
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function getAll(){
        $reason = $this->db->get($this->table)->result();
        $data = [];
        foreach ($reason as $item) {
            $data[$item->reason_id] = $item->reason;
        }
        return $data;
    }
}

