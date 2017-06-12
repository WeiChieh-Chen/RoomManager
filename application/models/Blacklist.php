<?php
Class Blacklist extends CI_Model
{
    private $table = 'blacklist';
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }
    public function checklist($value)
    {
        $query = $this->db->where(["student_id"=>$value])->count_all_results($this->table);
        return $query;
    }

    public function getBlacklistinfo()
    {   
        date_default_timezone_set("Asia/Taipei");
        $myDate = explode("-", date("Y-m-d",strtotime("now")));
        $date=$myDate[0]."-9-01";
        $date2=$myDate[0]."-3-01";
        if((strtotime("now")-strtotime($date))/60/60/24 < 30 && (strtotime("now")-strtotime($date))/60/60/24 >= 0){ 
            $this->db->empty_table($this->table);

        }
        else if((strtotime("now")-strtotime($date2))/60/60/24 < 30 && (strtotime("now")-strtotime($date2))/60/60/24 >= 0){
            $this->db->empty_table($this->table);
        } 
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function reasonString($reasonlist)
    {
        $reasonstring="";
        $this->load->model("blacklist_reason");
        $pieces = explode(",", $reasonlist);
        foreach ($pieces as $value) {
            $query = $this->db->select("reason")->where(["reason_id"=>$value])->get("blacklist_reason");
            $row=$query->result();
            $reasonstring=$reasonstring."".$row[0]->reason.",";         
        }
        $reasonstring=substr($reasonstring,0,strlen($reasonstring)-1);
        return $reasonstring;
    }

    public function reasoncount($reasonlist,$countarray)
    {
        $pieces = explode(",", $reasonlist);
        foreach ($pieces as $value) {
            $countarray[$value-1]++;        
        }
        return $countarray;
    }

    public function getroomBreak($room_id)
    {
        $query = $this->db->where(["room_id"=>$room_id])->count_all_results($this->table);
        return $query;
    }
    public function getroomAllbreak($room_id)
    {
        $countarray = array(0, 0, 0, 0, 0, 0, 0);
        $query = $this->db->where(["room_id"=>$room_id])->get($this->table);
        $roomdata = $query->result();
        foreach ($roomdata as $key => $value) {
            $countarray = $this->blacklist->reasoncount($value->reason,$countarray);
        }
        return $countarray;
    }

    public function create($data){
        $this->db->insert($this->table,$data);
    }
}

