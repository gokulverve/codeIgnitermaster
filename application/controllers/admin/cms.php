<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms extends Admin_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->model('admin/cms_model');
		$this->load->model('common_model');
    }

   public function changestatus() {
        $conditionArray     = array('cms_id' => $this->input->post('id'));
        $status = ($this->input->post('status') == "1" ? "0" : "1");

        $this->db->where('cms_id',$this->input->post('id'));
        $this->db->update('tbl_cms',array('status' =>$status));

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
        $data['paging_url']     = base_url().'admin/cms/';
        $data['page']           = ($this->uri->segment(3)) ? intval($this->uri->segment(3)) : 1;
        $data['sort_by']        = $this->input->post('sort_by');
        $data['sort_direction'] = $this->input->post('sort_direction');
        $data['per_page']       = ($this->input->post('per_page')) ? $this->input->post('per_page') : $this->PER_PAGE;
        $data['search']         = ($this->input->post('search')) ? $this->input->post('search') : '';
        
        // $data['record_exist'] = FALSE;        
        
        $where_data =   array(
                    "search"         => $data['search'],
                    "per_page"       => $data['per_page'],
                    'offset'         => $data['page'],
                    'limit'          => $data['per_page'],
                    "page"           => $data['page'],
                    "sort_by"        => $data['sort_by'],
                    "sort_direction" => $data['sort_direction']);

        $data['cms']  = $this->cms_model->get_cms_list($where_data,'data');

        $data['total_records'] = $this->cms_model->get_cms_list($where_data,'count', 'cms_id');
        
        $config['base_url']    = base_url().'admin/cms/';
        
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
        $data['page_title'] = "Cms List";
        $data['breadcrumb'] = "admin/cms";        
        // pr($data);
        if($this->input->post('request') == 'ajax')
        {
            echo $this->load->view('admin/cms/ajax_list', $data, TRUE);
        }
        else
        {
            $data['main_content'] = "admin/cms/list";
            $this->load->view('admin/include/template', $data);
        }        
    }

    /*
     * Function For delete user information
     */
    public function delete() 
    {
        $message = array("status" => "error","msg" => "Something went wrong!");
        $cms_id = $this->input->post('cms_id');
        $cms['updated_date'] =  date("y-m-d H:i:s");
        $cms['is_deleted'] =  "1";
        $cmsData = $this->cms_model->update_cms($cms_id, $cms);
        
        if($cmsData)
        {
            $message = array("status" => "success","msg" => "Record deleted successfully.");
        }
        echo json_encode($message);exit;
    }
    
    public function add_edit_cms()
    {
        $cms_id = $this->uri->segment(4);

        if($cms_id != "")
        {
            $data['cms_data'] = $this->cms_model->get_cms_detail($cms_id);
            if (empty($data['cms_data'])) 
            {
                redirect('admin/cms');
            }
            // pr($data['cms_data']);
            $data['page_title'] = 'Edit cms';
            $data['breadcrumb'] = "admin/cms/edit";
        }
        else
        {

            $data['page_title'] = 'Add cms';
            $data['breadcrumb'] = "admin/cms/add";
        }
        $data['main_content'] = "admin/cms/add_edit_cms";
        $this->load->view('admin/include/template', $data);
    }

    public function save_cms()
    {
        $cms_name        = $this->input->post('cms_name');
        $cms_description = $this->input->post('editor1');
        $cms_id          = $this->input->post('cms_id');
        $status          = $this->input->post('status');

        if ($cms_name != "")  
        {
            $cms['cms_name']        =  $cms_name;
            $cms['status'] =  $status;
            $cms['cms_description'] =  $cms_description;

            if ($cms_id != "") 
            {
                $cms['updated_date'] =  date("y-m-d H:i:s");
                $this->cms_model->update_cms($cms_id, $cms);
                $this->session->set_userdata("success_notification","1");
                $this->session->set_userdata("notification_title","Success!!!");
                $this->session->set_userdata("notification_body","cms has been successfully updated.");
                $this->session->set_userdata("notification_class","success-notification");
            }
            else
            {
                $cms['created_date'] =  date("y-m-d H:i:s");
                $this->cms_model->insert_cms($cms);
                $this->session->set_userdata("success_notification","1");
                $this->session->set_userdata("notification_title","Success!!!");
                $this->session->set_userdata("notification_body","cms has been successfully inserted.");
                $this->session->set_userdata("notification_class","success-notification");
            }
        }
        redirect('admin/cms');
    }

    public function check_cms_exist()
    {
        //$message = array("status" => "error","msg" => "Something went wrong!");
        $cms_id = $this->input->post('cms_id');
        $cms_name = $this->input->post('cms_name');

        if ($cms_name != "") 
        {
            $cms_exist = $this->cms_model->check_cms_exist($cms_name, $cms_id);
            // pr($cms_exist);
            if (!empty($cms_exist)) 
            {
                $message = array("status" => "error","msg" => $cms_name." already exists.");
            }
            else
            {
                $message = array("status" => "success","msg" => "");
            }
        }
        echo json_encode($message);exit;
    }

    public function upload_image($file_name)
    {
        $cms_folder = $this->config->item('base_path').'cms_image';
        if (!file_exists($cms_folder)) 
        {
            mkdir($cms_folder, 0777, true);
        }

        $this->load->library('upload');
        $image_name = $_FILES[$file_name]['name'];
        $front_config = array(
            'allowed_types' => 'jpg|png|jpeg',
            'upload_path' => $cms_folder,
            'max_size' => '20000',
            'overwrite' => FALSE,
            'file_name' => $image_name,
            'max_height' => "50000",
            'max_width' => "50000",

        );
        $this->upload->initialize($front_config);
        $this->upload->do_upload($file_name);
        $imageData = $this->upload->data();
        return $imageData['file_name'];
    }

    public function delete_image()
    {
        $message = array("status" => "error","msg" => "Something went wrong!");
        $id = $this->input->post('id');
        $image = $this->input->post('image');
        

        if ($id != "" && $image != "")
        {
            unlink($image);
            $cms['updated_date'] =  date("y-m-d H:i:s");
            $cms['cms_image'] =  NULL;
            
            $this->common_model->insert_update_action('update', 'tbl_cms', $cms, array("cms_id" => $id));
            $message = array("status" => "success","msg" => "Image deleted successfully.");
        }
        echo json_encode($message);exit;
    }
}