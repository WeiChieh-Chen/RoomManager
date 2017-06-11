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

    public function create($id,$info){
        $data = [
            "borrow_count" => 0,
            "active" => $info['active'],
            "room_id" => $id,
            "room_name" => $info['room_name']
        ];

        $this->db->insert("classroom",$data);

    }

    public function update($id,$info){
        $data = [
            "active" => $info['active'],
            "room_name" => $info['room_name']
        ];
        $this->db->update("classroom",$data,['room_id' => $id]);
    }

    public function delete($id){
        $table = ['classroom','section'];
        $this->db->delete($table,['room_id' => $id]);
    }
}
