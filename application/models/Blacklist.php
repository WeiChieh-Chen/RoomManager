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
}

