<?php
Class Application extends CI_Model
{
    protected $table = "application";
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function create($data){
        $this->db->insert($this->table,$data);
    }
}