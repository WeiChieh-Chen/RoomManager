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
        $dates = [];
        /**
         * 先取得有申請到的日期之時段。以 room_id、 date 抓出時段放入陣列
         * @type Array $row
         */
        foreach ($data as $row) {
            if(!isset($dates[$row['room_id']][$row['date']])) {
                $set = $this->db->where('room_id', $row['room_id'])->where('date', $row['date'])->get("section")->result();
                $dates[$row['room_id']][$row['date']] = $set;
            }
        }

        /**
         * 每一個申請的日期時段與資料庫內的比較
         * @type Array $row
         */
        foreach ($data as $index => $row) {
            // 用 room_id、date 做一個巢狀的資料結構，降低一次拿全部及利用其比較被刪掉的時段
            $sets = $dates[$row['room_id']][$row['date']];

            /**
             * 比較時段，相同則 $dates 跟 $data 都刪除
             * $data 剩下得是要新增的資料
             * $dates 剩下的是要刪除的資料
             * @type Object $record
             */
            foreach ($sets as $key => $record) {
                if ($row['start'] == $record->start && $row['end'] == $record->end) { // 如果時段重複
                    unset($dates[$row['room_id']][$row['date']][$key]); // 順便刪除 $dates 出現在 $data 裡的時段，表示無變更
                    unset($data[$index]); // 則移除不重複申請
                }
            }
        }

        // 收集刪除時段的 id
        $ids = [];
        foreach($dates as $date) {
            foreach ($date as $sections) {
                foreach ($sections as $section) {
                    $ids[] = $section->id;
                }
            }
        }
        // 刪除 id
        if(!empty($ids)){
            $this->db->where_in('id',$ids)->delete('section');
        }

        // 欲新增的時段
        if(!empty($data)){
            $this->db->insert_batch("section",$data);
        }
    }

    public function insertData($data){
        $this->db->insert("section",$data);
    }
}

