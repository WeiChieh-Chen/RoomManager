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
    
    public function search_class($start,$end,$room_id)
    {
	   $query = $this->db->where('room_id',$room_id)->where("date between '$start' AND '$end'")->get("section");
	   return $query->result();
    }
	
	public function search_date($start)
	{
		$query = $this->db->where('date',$start)->get("section");
		return $query->result();
	}
	
	public function search_both($start,$room_id)
	{
		$query = $this->db->where('room_id',$room_id)->where("date",$start)->get("section");
		return $query->result();
	}
 
	public function insert_xml($data){
        $this->db->insert_batch("section",$data);
    }
}

