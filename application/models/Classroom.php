<?php
Class Classroom extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function getRoom(){
        $query = $this->db->get("classroom");
        return $query->result();
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
        $table = ['classroom', 'Timeperiod'];
        $this->db->delete($table,['room_id' => $id]);
    }
}