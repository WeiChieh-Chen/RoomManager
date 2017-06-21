<?php
Class Section_of_borrower extends CI_Model
{
    protected $table = "section_of_borrower";

    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function search($condition){
        return $this->db->where($condition)->get($this->table)->result();
    }
}