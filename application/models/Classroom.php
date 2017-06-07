<?php
Class Classroom extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }
    
	public function getRoom(){
		$query =  $this->db->get("classroom");
		return $query->result();
	}
    public function getRoominfo()
    {
        $roomcount = array();
        $classinfo = array();
        $i=0;
        $this->load->model("application");
        $class = $this->db->get("classroom");
        $class = $class->result();
        foreach ($class as $key => $value) {
            $roomcount[] = $this->db->where(["room_id"=>$value->room_id])->count_all_results('application');
        }
        foreach ($class as $key => $value) {
            $classinfo[] = [
            'room_id' => $value->room_id,
            'room_name' => $value->room_name,
            'active' => $value->active,
            'borrow_count' => $roomcount[$i]
            ];
            $i=$i+1;
        }
        return $classinfo;
    }
}
