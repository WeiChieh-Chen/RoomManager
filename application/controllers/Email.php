<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {
    private $to = "";

    public function __construct() {
        parent::__construct();
        $this->load->library(['session','email']);
        $this->load->helper('url');
        $this->setConfig();
    }

    private function setConfig(){
        $this->load->model('manager');
        $this->to = "your email";
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => $this->to,
            'smtp_pass' => 'your pass',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];
        $this->email->initialize($config);
    }

    // Borrower to manager
    public function sendMail(){
        $this->load->library('email');
        $user = $this->input->post();
        $this->email->from($user->email, $user->sName);
        $this->email->to($this->to);
        $this->email->subject("教室申請單");
        $this->email->message(
            "<h1>已收到借用&emsp;<span style='color: red'>{$user->room_id}&emsp;的申請單</span></h1><br>".
            "<h3>申請人： {$user->sName}</h3><br>".
            "<h3>學號： {$user->sNumber}</h3><br>".
            "<h3>聯絡電話： {$user->cellphone}</h3><br>".
            "<h3>指導老師： {$user->teacher}</h3><br>".
            "<h3>申請事由： {$user->events}</h3>"
        );

        if(!$this->email->send()){
//            echo $this->email->print_debugger();
        }
        return redirect("/Home");
    }

    // Manager to borrower
    public function replyMail(){
        $auditData = $this->session->audit_list;

        foreach ($auditData as $form){
            $this->email->from($this->to, '教室借用系統');
            $this->email->to($form->email);
            $this->email->subject("教室借用申請-審核結果");
            $this->email->message(
                "<h1>審核結果：<span style='color: red'>{($form->apply_result === '1'?'通過':'不通過')}</span></h1><br>".
                "<h2>教室：{$form->room_id}</h2><br>".
                "<h3>日期：{$form->date}</h3><br>".
                "<h3>第{$form->start}節～第{$form->end}節</h3><br>"
            );

            if(!$this->email->send()){
//            echo $this->email->print_debugger();
            }
        }

        return redirect("/Admin");
    }

}