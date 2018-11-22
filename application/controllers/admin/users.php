<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends Admin_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->helper('file');
        $this->load->model('admin/users_model');
        $this->load->model('common_model');

    }

       public function changestatus() {
        $conditionArray     = array('cms_id' => $this->input->post('id'));
        $status = ($this->input->post('status') == "1" ? "0" : "1");

        $this->db->where('user_id',$this->input->post('id'));
        $this->db->update('tbl_users',array('status' =>$status));
//echo $this->db->last_query();
        $output = array(
            "statustext" => ($this->input->post('status') == "1" ? "Inactive" : "Active"),
            "statusval" => ($this->input->post('status') == "1" ? "0" : "1")
        );
        //output to json format
        echo json_encode($output);
    }

    public function index() 
    {
        $data['data'] = array();        
        $data['total_records']  = 0;
        $data['show_per_page']  = $this->show_per_page;
        $data['paging_url']     = base_url().'admin/users/';
        $data['page']           = ($this->uri->segment(3)) ? intval($this->uri->segment(3)) : 1;
        $data['sort_by']        = $this->input->post('sort_by');
        $data['sort_direction'] = $this->input->post('sort_direction');
        $data['status']         = $this->input->post('status');
        $data['per_page']       = ($this->input->post('per_page')) ? $this->input->post('per_page') : $this->PER_PAGE;
        $data['search']         = ($this->input->post('search')) ? $this->input->post('search') : '';
        
        // $data['record_exist'] = FALSE;        
        
        $where_data =   array(
                    "search"         => $data['search'],
                    "per_page"       => $data['per_page'],
                    'offset'         => $data['page'],
                    'limit'          => $data['per_page'],
                    "page"           => $data['page'],
                    "status"         => $data['status'],
                    "sort_by"        => $data['sort_by'],
                    "sort_direction" => $data['sort_direction']);

        $data['users']  = $this->users_model->get_users_list($where_data,'data');

        $data['total_records'] = $this->users_model->get_users_list($where_data,'count');
        
        $config['base_url']    = base_url().'admin/users/';
        
        if ($data['total_records'] > $data['per_page']) 
        {
            $data['pagination'] = get_pagination($config['base_url'],"",$data['total_records'],3,$data['per_page']);
        }

        $data['from_records'] = ($data['total_records'] > 0) ? $data['page'] * $data['per_page'] - $data['per_page'] + 1 : 0;
        
        $data['to_records']   = ($data['page']*$data['per_page'] < $data['total_records']) ? $data['page']*$data['per_page'] : $data['total_records'];

        if ($data['page'] == '1') 
        {
            $i = 1;
        }
        else if($data['page'] > 1 )
        {
            $i = (($data['page']-1) * $data['per_page']) + 1;
        }
        $data['i'] = $i;
        $data['page_title'] = "Users List";
        $data['breadcrumb'] = "admin/users";        
        // pr($data);

        if($this->input->post('request') == 'ajax')
        {

            echo $this->load->view('admin/users/ajax_list', $data, TRUE);
        }
        else
        {
            $data['left_title'] = 'Users List';
            $data['btn_link'] = base_url('admin/users/add_edit_user');
            $data['btn_label'] = 'Add User';
            $data['main_content'] = "admin/users/list";
            $this->load->view('admin/include/template', $data);
        }        
    }

    public function delete() 
    {
        $message = array("status" => "error","msg" => "Something went wrong!");
        $user_id = $this->input->post('user_id');
       // echo $user_id;die;
        $users['updated_date'] =  date("y-m-d H:i:s");
        $users['is_deleted'] =  "1";
        $cmsData = $this->common_model->insert_update_action('update', 'tbl_users', $users, array("user_id" => $user_id));
       // echo $this->db->last_query();die;
        
        if($cmsData)
        {
            $message = array("status" => "success","msg" => "Record deleted successfully.");
        }
        echo json_encode($message);exit;
    }
    
    public function add_edit_user()
    {
        $user_id = base64_decode($this->uri->segment(4));

        if($user_id != "")
        {
            $condition['where'] = array("user_id" => $user_id);
            $user_data = $this->common_model->select_data_by_condition("tbl_users",$condition);
            
            if (empty($user_data)) 
            {
                redirect('admin/users');
            }
            $data['user_data'] = $user_data[0];            
            $data['page_title'] = 'Edit User';
            $data['breadcrumb'] = "admin/users/edit";
        }
        else
        {
            $data['page_title'] = 'Add User';
            $data['breadcrumb'] = "admin/users/add";
        }
        $data['form_url'] = base_url("admin/users/save_user");
        $data['btn_cancel'] = base_url("admin/users");
        $data['main_content'] = "admin/users/add_edit_user";
        $this->load->view('admin/include/template', $data);
    }

    public function save_user()
    {
        $user_id           = $this->input->post('user_id');
        $first_name          = $this->input->post('first_name');
        $last_name           = $this->input->post('last_name');
        $email_address       = $this->input->post('email_address');
        $status              = $this->input->post('status');
        $birthdate = $this->input->post('birthdate');

        if ($first_name != "" && $last_name != "")  
        {
            $users['first_name']          =  $first_name;
            $users['last_name']           =  $last_name;
            $users['status']              =  $status;
            $date_format = explode("-", $birthdate);
            $users['birthdate'] = $date_format[2]."-".$date_format[1]."-".$date_format[0];

                ini_set( 'memory_limit', '200M' );
                ini_set('upload_max_filesize', '200M');  
                ini_set('post_max_size', '200M');  
                ini_set('max_input_time', 3600);  
                ini_set('max_execution_time', 3600);

            $users_folder = $this->config->item('base_path').'user_image';
            if (!file_exists($users_folder)) 
            {
                mkdir($users_folder, 0777, true);
            }

            $fileName = $_FILES['profile_image']['name'];
            if ($fileName != "") 
            {
                $result_image = $this->upload_image('profile_image');
                $users['profile_image'] = $result_image;
            }

            // pr($users);
            if ($user_id != "") 
            {
                $users['updated_date'] =  date("y-m-d H:i:s");
                $this->common_model->insert_update_action('update', 'tbl_users', $users, array("user_id" => $user_id));

                $this->session->set_userdata("success_notification","1");
                $this->session->set_userdata("notification_title","Success!!!");
                $this->session->set_userdata("notification_body","User has been successfully updated.");
                $this->session->set_userdata("notification_class","success-notification");
            }
            else
            {
                $password = $this->input->post('password');
                $users['password']         = md5(ADMIN_SALT . $password);
                $users['email_address']    = $email_address;
                $users['created_date']     = date("y-m-d H:i:s");

                $this->common_model->insert_update_action('insert', 'tbl_users', $users);
                
                $this->session->set_userdata("success_notification","1");
                $this->session->set_userdata("notification_title","Success!!!");
                $this->session->set_userdata("notification_body","User has been successfully inserted.");
                $this->session->set_userdata("notification_class","success-notification");
            }
        }
        redirect('admin/users');
    }

    public function check_user_exist()
    {
        $message = array("status" => "error","msg" => "Something went wrong!");
        $email_address = $this->input->post('email_address');
        $user_id = $this->input->post('user_id');
        
        if ($email_address != "") 
        {
            if($user_id !=''){
                $condition['where'] = array("email_address" => $email_address,"user_id !=" => $user_id);
            }else{
                $condition['where'] = array("email_address" => $email_address);
            }
           
            $exist = $this->common_model->check_record_exist("tbl_users", $condition);
            // pr($category_exist);
            if (!empty($exist)) 
            {
                $message = array("status" => "error","msg" => $email_address." already exists.");
            }
            else
            {
                $message = array("status" => "success","msg" => "");
            }
        }
        echo json_encode($message);exit;
    }

    public function delete_profile_image()
    {
        $message = array("status" => "error","msg" => "Something went wrong!");
        $id = $this->input->post('id');
        $image = $this->input->post('image');
        $field = $this->input->post('field');

        if ($id != "" && $image != "" && $field != "")
        {
            unlink($image);
            $users['updated_date'] =  date("y-m-d H:i:s");
            $users[$field] =  NULL;
            $this->common_model->insert_update_action('update', 'tbl_users', $users, array("user_id" => $id));
            $message = array("status" => "success","msg" => "Image deleted successfully.");
        }
        echo json_encode($message);exit;
    }

    public function get_detail()
    {
        $id = $this->input->post('id');
        $condition['where'] = array("user_id" => $id);
        $user_data = $this->common_model->select_data_by_condition("tbl_users",$condition);

        //echo "<pre>";print_r($user_data);die;
        $data['user_data'] = $user_data[0];
        echo $this->load->view('admin/users/view_detail', $data, TRUE);
    }

    public function upload_image($file_name)
    {

        $this->load->library('upload');
        $users_folder = $this->config->item('base_path').'user_image';
        $image_name = time().'.png';//$_FILES[$file_name]['name'];
        $front_config = array(
            'allowed_types' => 'jpg|png|jpeg',
            'upload_path' => $users_folder,
            'max_size' => '20000',
            'overwrite' => TRUE,
            'file_name' => $image_name,
            'max_height' => "1200",
            'max_width' => "1200",
            'max_size' => '1000000',
            'max_width'  => '1024000',
            'max_height'  => '768000'

        );
        $this->upload->initialize($front_config);
        $this->upload->do_upload($file_name);
        $imageData = $this->upload->data();

       // echo "<pre>";print_r($imageData);die;
        return $imageData['file_name'];
    }

}