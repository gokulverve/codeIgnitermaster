<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends Admin_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->model('admin/setting_model');
		$this->load->model('common_model');
    }

    public function edit_smtp()
    {
        $data['smtp_data'] = $this->setting_model->get_smtp_detail(1);

        $data['page_title'] = 'Edit SMTP Settings';
        $data['breadcrumb'] = "admin/setting/edit";
        $data['main_content'] = "admin/setting/add_edit_smtp";

        $this->load->view('admin/include/template', $data);
    }

      public function edit_pushnotification_setting()
    {
        $data['noti_setting_data'] = $this->setting_model->get_pushnotification_setting_detail(1);
//echo "<pre>";print_r($data);die;
        $data['page_title'] = 'Edit Push Notification Settings';
        $data['breadcrumb'] = "admin/setting/edit";
        $data['main_content'] = "admin/setting/edit_notification_setting";

        $this->load->view('admin/include/template', $data);
    }

    public function save_smtp()
    {
        $smtp['host']        = $this->input->post('host');
        $smtp['username'] = $this->input->post('username');
        $smtp['password']          = $this->input->post('password');
        $smtp['port_id']          = $this->input->post('port_id');
        $smtp['updated_date'] =  date("y-m-d H:i:s");

        if($this->setting_model->update_smtp(1,$smtp)){
                $this->session->set_userdata("success_notification","1");
                $this->session->set_userdata("notification_title","Success!!!");
                $this->session->set_userdata("notification_body","SMTP details has been updated successfully.");
                $this->session->set_userdata("notification_class","success-notification");
        }

        redirect('admin/setting/edit_smtp');
    }

    public function save_noti_setting()
    {
        $noti_setting['api_key']        = $this->input->post('api_key');
        $noti_setting['apns_server_mode'] = $this->input->post('apns_server_mode');
        $noti_setting['apns_password']          = $this->input->post('apns_password');
        $noti_setting['updated_date'] =  date("y-m-d H:i:s");

        $fileName = $_FILES['pem_file_name']['name'];
            if ($fileName != "") 
            {
                $result_image = $this->upload_image('pem_file_name');
                $noti_setting['pem_file_name'] = $result_image;
            }

        if($this->setting_model->update_noti_setting(1,$noti_setting)){
                $this->session->set_userdata("success_notification","1");
                $this->session->set_userdata("notification_title","Success!!!");
                $this->session->set_userdata("notification_body","SMTP details has been updated successfully.");
                $this->session->set_userdata("notification_class","success-notification");
        }

        redirect('admin/setting/edit_pushnotification_setting');
    }
        

    public function upload_image($file_name)
    {
        $pem_folder = $this->config->item('base_path').'pem';
        if (!file_exists($pem_folder)) 
        {
            mkdir($pem_folder, 0777, true);
        }

        $this->load->library('upload');
        $image_name = $_FILES[$file_name]['name'];
        $front_config = array(
            'allowed_types' => '*',
            'upload_path' => $pem_folder,
            'max_size' => '20000',
            'overwrite' => true,
            'file_name' => $image_name

        );
        $this->upload->initialize($front_config);
        $this->upload->do_upload($file_name);
        $imageData = $this->upload->data();
        return $imageData['file_name'];
    }

}