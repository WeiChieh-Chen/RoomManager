<?php
Class Blacklist extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database("room_borrow");
    }

    public function getBlacklistinfo()
    {   
        date_default_timezone_set("Asia/Taipei");
        $myDate = explode("-", date("Y-m-d",strtotime("now")));
        $date=$myDate[0]."-9-01";
        $date2=$myDate[0]."-3-01";
        if((strtotime("now")-strtotime($date))/60/60/24 < 30 && (strtotime("now")-strtotime($date))/60/60/24 >= 0){ 
            $this->db->empty_table('blacklist');

        }
        else if((strtotime("now")-strtotime($date2))/60/60/24 < 30 && (strtotime("now")-strtotime($date2))/60/60/24 >= 0){
            $this->db->empty_table('blacklist');
        } 
        $query = $this->db->get("blacklist");
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
        $query = $this->db->where(["room_id"=>$room_id])->count_all_results('blacklist');
        return $query;
    }
}

