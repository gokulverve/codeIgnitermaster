<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends Admin_Controller 
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->library('form_validation');
        
        $admin_session = $this->session->userdata('admin_session');
        if (!isset($admin_session['is_admin_login'])) 
        {
            redirect('admin/home');
        }

    	$this->load->model('admin/admin_model');
    	$this->load->model('common_model');
		$this->load->helper('url');
		$this->load->helper('api');
    }

    public function index() 
    {
    	//echo "string";die;
    	$condition['where'] = array('is_deleted' => '0');
		$data['total_users']     = $this->common_model->select_count('tbl_users', $condition, "COUNT(user_id) count");

		$data['page']             ='dash';
		$data['page_title']       = "Dashboard";
		$data['breadcrumb']       = "admin/dashboard";		
		$data['main_content']     = "admin/dashboard/dashboard";
        $this->load->view('admin/include/template',$data);
    }
	
	function checkspecialchar($field)
	{
		//return ( ! preg_match("/^[0-9*#+]+$/", $field)) ? FALSE : TRUE;
		if( preg_match('/[^a-z0-9 _]+/i', $field)) {
		/*if( ! preg_match("/^[0-9*#+]+$/", $field))
		{*/
			$this->form_validation->set_message('checkspecialchar', 'Please enter valid text');
			return false;	
		}
		else
		{
			return true;
		}
		
	}

	/*
     * Function For admin user profile
     */
	public function profile() 
	{
		$admin_session = $this->session->userdata('admin_session');
		if($this->input->post()) 
		{
			$this->form_validation->set_rules('first_name', 'first name', 'required|callback_checkspecialchar');
			$this->form_validation->set_rules('last_name', 'last name', 'required|callback_checkspecialchar');
			$this->form_validation->set_rules('email_address', 'email', 'required|valid_email');
			
			if($this->form_validation->run())
			{
				$data = array(
							"first_name"=>$this->input->post('first_name'),
							"last_name"=>$this->input->post('last_name'),
							"email_address"=>$this->input->post('email_address')
						);
				
				/*Upload image*/
	            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != "") 
	            {
	                $image_folder = BASE_PATH.'admin-user-profile';
	                $fileName = $_FILES['profile_image']['name'];
	                
	                $config = array(
	                    'allowed_types' => 'jpg|png|jpeg',
	                    'upload_path' => $image_folder,
	                    'max_size' => '20000',
	                    'overwrite' => true,
	                    'file_name' => $fileName,
	                    'max_height' => "1200",
	                    'max_width' => "1200",

	                );
	                $this->load->library('upload', $config);
	                $this->upload->do_upload('profile_image');
	                $imageData = $this->upload->data();
	                $data['profile_image'] = $imageData['file_name'];
	            }	
				
				$affected=$this->admin_model->edit_profile($data,$admin_session['admin_id']);
				if($affected) 
				{
					$this->session->set_userdata(array(
                    		'firstname' =>$this->input->post('first_name'),
							'lastname' =>$this->input->post('last_name'),
                            'email' => $this->input->post('email_address')
                        	)
                        );

					$this->session->set_userdata("success_notification","1");
					$this->session->set_userdata("notification_title","Success!!!");
					$this->session->set_userdata("notification_body","Admin Profile has been successfully updated.");
					$this->session->set_userdata("notification_class","success-notification");
				}
				else
				{
					$this->session->set_userdata("success_notification","1");
					$this->session->set_userdata("notification_title","Failure!!!");
					$this->session->set_userdata("notification_body","Admin Profile updation failed.");
					$this->session->set_userdata("notification_class","failure-notification");
				}
				
				//redirect('admin', 'refresh');
				redirect('admin/dashboard/profile', 'refresh');
			}
		}
		$data['form_url'] = base_url("admin/dashboard/profile");
		$data['detail']=$this->admin_model->getValue($admin_session['admin_id']);
		// pr($data['detail']);
		$data['page_title'] = 'Profile';
		$data['breadcrumb'] = "admin/dashboard/Profile";

		$data['main_content'] = "admin/dashboard/profile";
        $this->load->view('admin/include/template', $data);
    }
    
	/*
     * Function For change password
     */
    public function changepassword()
	{
		$dataa['page'] = 'home';
		$admin_session = $this->session->userdata('admin_session');
		$data['page_title'] = 'Change Password';
		if($this->input->post())
		{
			$this->form_validation->set_rules('old_password', 'old password', 'required');
			$this->form_validation->set_rules('new_password', 'new password', 'required');
			$this->form_validation->set_rules('confirm_password', 'confirm password', 'required');
			if($this->form_validation->run())
			{
				$this->db->where("email_address",$admin_session['email']);
				$admin_query = $this->db->get("tbl_admin");
				$admin_result = $admin_query->result();
				if($admin_query->num_rows())
				{
					
					if(md5(ADMIN_SALT.$this->input->post('old_password')) == $admin_result[0]->password)
					{
						if($this->input->post('new_password') == $this->input->post('confirm_password'))
						{
							$data_update = array(
								"password" => md5(ADMIN_SALT.$this->input->post('new_password')),
								"updated_date" => date("Y-m-d h:i:s")
							);
							$this->db->where("email_address",$this->session->userdata('email'));
							$admin_update = $this->db->update("tbl_admin",$data_update);
							
							if($data_update) 
							{
								$this->session->set_userdata("success_notification","1");
								$this->session->set_userdata("notification_title","Success!!!");
								$this->session->set_userdata("notification_body"," Password has been changed successfully.");
								$this->session->set_userdata("notification_class","success-notification");

								//redirect('admin/dashboard', 'refresh');
								redirect('admin/dashboard/changepassword', 'refresh');
							}
							else
							{
								$this->session->set_userdata("success_notification","1");
								$this->session->set_userdata("notification_title","Failure!!!");
								$this->session->set_userdata("notification_body","Password updation failed.");
								$this->session->set_userdata("notification_class","failure-notification");
								redirect('admin/dashboard/changepassword', 'refresh');
							}
						}
						else
						{
							$this->session->set_userdata("success_notification","1");
							$this->session->set_userdata("notification_title","Failure!!!");
							$this->session->set_userdata("notification_body","Password updation failed.");
							$this->session->set_userdata("notification_class","failure-notification");
							redirect('admin/dashboard/changepassword', 'refresh');
						}
					}
					else
					{
						$this->session->set_userdata("success_notification","1");
						$this->session->set_userdata("notification_title","Failure!!!");
						$this->session->set_userdata("notification_body","Password updation failed.");
						$this->session->set_userdata("notification_class","failure-notification");
						redirect('admin/dashboard/changepassword', 'refresh');
					}
				}
			}
		}
		
		$dataa['page'] = 'home';
		$data['breadcrumb'] = "admin/dashboard/Change Password";
		$data['form_url'] = base_url("admin/dashboard/changepassword");
		$data['main_content'] = "admin/dashboard/changepassword";
        $this->load->view('admin/include/template', $data);
    }

	/*
     * Function For delete profile
     */
	public function deleteprofileimg()
	{
		$message = array("status" => "error","msg" => "Something went wrong!");
		$id = $this->input->post('id');
        $image = $this->input->post('image');

		if ($id != "" && $image != "")
		{
			unlink($image);
            $this->admin_model->update_admin($id,array("profile_image" => ""));
            $message = array("status" => "success","msg" => "Profile image deleted successfully.");
		}
		echo json_encode($message);exit;
	}
}