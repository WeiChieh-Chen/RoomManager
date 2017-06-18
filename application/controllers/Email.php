<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {
    private $to = "z85083090@gmail.com";

    public function __construct() {
        parent::__construct();
        $this->load->library(['session','email']);
        $this->load->helper('url');
    }


    // Borrower to manager
    public function sendMail(){
        $user = $this->session->toManager;
        $this->email->priority = 1;
        if($user['isB']){
            $this->email->from($user['email'], $user['sName']);
            $this->email->to($user['email']);
            $this->email->subject("教室申請單");
            $this->email->message(
                "<h1><span style='color: red'>您在借用黑名單中，請洽詢管理者</span></h1><br>".
                "<h3>申請人： {$user['sName']}</h3><br>".
                "<h3>學號： {$user['sNumber']}</h3><br>"
            );
        }else{
            $this->email->from($user['email'], $user['sName']);
            $this->email->to($this->to);
            $this->email->subject("教室申請單");
            $this->email->message(
                "<h1>已收到借用&nbsp;<span style='color: red'>{$user['room_id']}&nbsp;</span>的申請單</h1><br>".
                "<h3>申請人： {$user['sName']}</h3><br>".
                "<h3>學號： {$user['sNumber']}</h3><br>".
                "<h3>聯絡電話： {$user['cellphone']}</h3><br>".
                "<h3>指導老師： {$user['teacher']}</h3><br>".
                "<h3>申請事由： {$user['events']}</h3>"
            );
        }

        if(!$this->email->send()){
//            echo $this->email->print_debugger();
        }
        return redirect("/Home");
    }

    // Manager to borrower
    public function replyMail(){
        $auditData = $this->session->audit_list;
        $this->email->priority = 1;
        foreach ($auditData as $form){
            $this->email->from($this->to, '教室借用系統');
            $this->email->to($form['email']);
            $this->email->subject("教室借用申請-審核結果");

            if($form['apply_result'] === "1"){
                $this->email->message(
                    "<h2>審核結果：<span style='color: red'>通過</span></h2><br>".
                    "<h2>教室：{$form['room_id']}</h2><br>".
                    "<h3>日期：{$form['borrow_date']}</h3><br>".
                    "<h3>節次：第{$form['borrow_start']}節～第{$form['borrow_end']}節</h3><br>".
                    "<h3>本信件由系統自動發送，請勿回覆！</h3>"
                );
            }else {
                $this->email->message(
                    "<h2>審核結果：<span style='color: red'>不通過</span></h2><br>".
                    "<h2>教室：{$form['room_id']}</h2><br>".
                    "<h3>日期：{$form['borrow_date']}</h3><br>".
                    "<h3>節次：第{$form['borrow_start']}節～第{$form['borrow_end']}節</h3><br>".
                    "<h3>原因：{$form['reason']}</h3>".
                    "<h4>本信件由系統自動發送，請勿回覆！</h4>"
                );
            }


            if(!$this->email->send()){
                echo $this->email->print_debugger();
            }
        }

        return redirect("/Admin/Audit");
    }

}