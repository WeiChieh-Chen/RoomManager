<?php
Class Application extends CI_Model
{
    protected $table = "application";
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function getTable(){
    	return $this->db->get($this->table)->result();
    }


    public function create($data){
        $this->db->insert($this->table,$data);
    }

    public function updateData($data){
        foreach ($data as $key => $value) {
            $this->db->update($this->table,['apply_result' => $value],['application_id' => $key]);
        }
    }
}