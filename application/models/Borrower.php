<?php
Class Borrower extends CI_Model
{
    protected $table = "borrower";

    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function find($id){
        return $this->db->where('student_id',$id)->get($this->table)->row();
    }

    public function create($data){
        $this->db->insert($this->table,$data);
    }
}