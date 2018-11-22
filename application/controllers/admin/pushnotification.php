<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pushnotification extends Admin_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->helper('api');
        $this->load->model('common_model');
	}

    
    public function index() 
    {

        if($this->input->post())
        {
            $notificationData = array();
            $condition = array();
            $usertype = $this->input->post('usertype');
            
            if($usertype !='all'){
                $condition['where'] = array("status" => $usertype,"device_token !=" => '');
            }else{
                $condition['where'] = array("device_token !=" => '');
            }
            $userData = $this->common_model->select_data_by_condition("tbl_users",$condition);
//echo "<pre>";print_r($userData);die;
            if(count($userData) > 0)
            {
                $ios_tokens        = array();
                $notificationArray = array();
                $android_tokens    = array();

                $message = $this->input->post('message'); 
                
                foreach($userData as $k => $list)
                {
                    $notificationArray[$k]  =array(
                            "message"           => $message,
                            "notification_type" => 1,
                            "receiver_userid"     => $list['user_id']
                        );              
                    if($list['device_type'] == '1') //ios
                    {
                        $ios_tokens [$k] = $list['device_token'];
                    }
                    else //andriod
                    {
                        $android_tokens [$k] = $list['device_token'];
                    }   
                }

                // Insert notification array 
                if (count($notificationArray) > 0) 
                {
                    $this->db->insert_batch("tbl_notification_log", $notificationArray);
                }

                // send notification to Android
                if (count($android_tokens) > 0) 
                {
                    $regIdChunk = array_chunk($android_tokens,1000);
                    $message_status = array();
                    $msg = array(
                            'body'             => $message,
                            'title'            => 'Basic Admin Demo',
                            "vibrate"          => "1",
                            'notificationType' => '1',
                            "sound"            => "1" 
                        );

                    foreach($regIdChunk as $RegId)
                    {
                        $message_status[] = send_notification($RegId, $msg);
                    }
                }

                // Send notification to IOS
                if (count($ios_tokens) > 0) 
                {
                    $regIdChunk = array_chunk($ios_tokens,1000);
                    foreach($regIdChunk as $RegId)
                    {
                        $push_arr=array(
                            "alert"            => $message,
                            "badge"            => "1",
                            "distressId"       => $addDistress, 
                            "sound"            => "default",
                            'notificationType' => '1',
                            "dt"               => $RegId
                        );
                        send_ios_push_specific($push_arr);
                    }
                }
            }

			if(count($userData) > 0)
            {
    			$this->session->set_userdata("success_notification","1");
                $this->session->set_userdata("notification_title","Success!!!");
                $this->session->set_userdata("notification_body","Notification sent successfully");
                $this->session->set_userdata("notification_class","success-notification");
    			redirect('admin/pushnotification');
            }
            else
            {
                $this->session->set_userdata("error_notification","1");
                $this->session->set_userdata("notification_title","Error!!!");
                $this->session->set_userdata("notification_body","Unable to send notification to users.");
                $this->session->set_userdata("notification_class","error-notification");
                redirect('admin/pushnotification');
            }             
        }
        $data['form_url']     = base_url("admin/pushnotification");
        $data['breadcrumb']   = "admin/pushnotification";
        $data['page_title']   = "Push Notification";        
        $data['main_content'] = "admin/pushnotification/add";
        $this->load->view('admin/include/template', $data);
    }
}