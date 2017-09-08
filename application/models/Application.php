<?php
Class Application extends CI_Model
{
    protected $table = "application";
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function getNoAudit(){
    	return $this->db->where('apply_result',2)->order_by('borrow_date','asc')->order_by('application_id','asc')
            ->join('borrower','borrower.student_id = application.student_id')->get($this->table)->result();
    }

    public function getNoAuditCount(){
        return $this->db->where('apply_result',2)->count_all_results($this->table);
    }

    public function getEmailInfo(){
        $table = $this->db->select(
            'application_id,email,room_id,borrow_date,borrow_start,borrow_end,apply_result,name'
        )->from($this->table)->join('borrower','borrower.student_id = application.student_id')->get()->result();
	    $data =[];
        foreach ($table as $item){
            $data[$item->application_id] = [
                'email' => $item->email,
                "room_id"=> $item->room_id,
                "borrow_date" => $item->borrow_date,
                "borrow_start" => $item->borrow_start,
                "borrow_end" => $item->borrow_end,
                "apply_result" => $item->apply_result,
                "name" => $item->name
            ];
        }
        return $data;
    }

    public function create($data){
        $this->db->insert($this->table,$data);
    }

    public function search_class($start,$end,$room_id){
	    $query = $this->db->select(['student_id',"borrow_date","borrow_start","borrow_end","reason",'apply_result'])->where(['room_id' => $room_id])->where("borrow_date between '$start' AND '$end'")->get("application");
	    return $query->result();
    }
	
	public function search_date($start){
		$query = $this->db->select(['student_id',"borrow_date","borrow_start","borrow_end","reason",'room_id','apply_result'])->where('borrow_date',$start)->get("application");
		return $query->result();
	}
	
	public function search_both($start,$room_id){
		$query = $this->db->select(['student_id',"borrow_date","borrow_start","borrow_end","reason",'room_id','apply_result'])->where(['room_id' => $room_id])->where('borrow_date',$start)->get("application");
		return $query->result();
	}

    public function updateData($id,$result){
        $this->db->update($this->table,['apply_result' => $result],['application_id' => $id]);
    }
}