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

    public function search_app($start,$end,$room_id){
	    $query = $this->db->select(["borrow_date","borrow_start","borrow_end","reason"])->where(['room_id' => $room_id,'apply_result' => 1])->where("borrow_date between '$start' AND '$end'")->get("application");
	    return $query->result();
    }

    public function updateData($data){
        foreach ($data as $key => $value) {
            $this->db->update($this->table,['apply_result' => $value],['application_id' => $key]);
        }
    }
}