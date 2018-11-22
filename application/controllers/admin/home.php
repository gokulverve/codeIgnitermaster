<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->library('form_validation', 'session');
        $this->load->model('admin/admin_model');
        $this->load->model('common_model');
        $this->load->helper('api');
    }

    public function index() 
    {
        $admin_session = $this->session->userdata('admin_session');
        if ($admin_session['is_admin_login'] === TRUE) 
        {
            redirect('admin/dashboard');
        } 
        else 
        {
            $this->load->view('admin/home/login');
        }
    }

    /*
     * Function For admin user login
     */

    public function login() 
    {
        $admin_session = $this->session->userdata('admin_session');
        if ($admin_session['is_admin_login'] === TRUE) 
        {
            redirect('admin/home/dashboard');
        } 
        else 
        {
            $user = @$_POST['var_Email'];
            $password = @$_POST['var_Password'];

            $this->form_validation->set_rules('var_Email', 'Email', 'required');
            $this->form_validation->set_rules('var_Password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) 
            {
                $this->load->view('admin/home/login', $data);
            } 
            else 
            {
                $enc_pass = md5(ADMIN_SALT . $password);
                // echo $enc_pass;exit;
                $this->db->select('*');
                $this->db->from('tbl_admin');
                $this->db->where('email_address',$user);
                $this->db->where('password',$enc_pass);
                $this->db->where('is_deleted','0');
                $res = $this->db->get()->row_array();
                
                if (!empty($res) == '1') 
                {
                    $newdata = array(
                        'admin_id'       => $res['admin_id'],
                        'username'       => $res['first_name'].' '.$res['last_name'],
                        'firstname'      => $res['first_name'],
                        'lastname'       => $res['last_name'],
                        'email'          => $res['email_address'],
                        'sub_userid'     => "",
                        'is_admin_login' => true
                    );
                    $this->session->set_userdata('admin_session', $newdata);                    
                    redirect('admin/dashboard');
                } 
                else 
                {
                    $err['error'] = 'Email or Password incorrect';
                    $this->load->view('admin/home/login', $err);
                }
            }
        }
    }

    /*
     * Function For admin user forgot password
     */

    public function forgot() 
    {
        $data = array();
        $admin_session = $this->session->userdata('admin_session');
        if ($admin_session['is_admin_login'] === TRUE) 
        {
            $data["redirect"] = base_url() . 'admin/home/dashboard';
            $data["success"] = 0;
            $data["message"] = "Already logged in.";
        } 
        else 
        {
            if (isset($_GET["email_address"])) 
            {
                $email = filter_var(trim($_GET["email_address"]), FILTER_SANITIZE_EMAIL);
                
                if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) 
                {
                    $condition['where'] = array("email_address" => $email);
                    $admin_data = $this->common_model->select_data_by_condition("tbl_admin",$condition);
                    if (count($admin_data) == 1) 
                    {
                        $password = generate_random_password();
                        $enc_pass = md5(ADMIN_SALT . $password);
                        
                        if ($this->admin_model->edit(array("password" => $enc_pass), $email)) 
                        {
                            $template_data['NAME'] = $admin_data[0]['first_name']." ".$admin_data[0]['last_name'];
                            $template_data['LOGIN_LINK'] = ADMIN_URL;
                            $template_data['EMAIL_ID'] = $email;
                            $template_data['PASSWORD'] = $password;

                            $this->load->library('email');
                            $this->email->from('apiteamtesting@gmail.com', PROJECT_NAME);
                            $this->email->to($email);
                            $this->email->subject('Forgot Password - '.PROJECT_NAME);
                            $this->email->message($this->load->view('emails/forgot_email.php', $template_data, TRUE));
                            // pr($this->email);
                            if (!$this->email->send()) 
                            {
                                mail($email, 'Forgor Password - '.PROJECT_NAME, $this->load->view('emails/forgot_email.php', $template_data, TRUE));
                            }
                            $data["success"] = 1;
                            $data["message"] = "<i class='icon-ok-sign'></i> Success!!! Please check your email address, we have send you an email.";
                        } 
                        else 
                        {
                            $data["success"] = 0;
                            $data["message"] = "<i class='icon-remove-sign'></i> Something went wrong, please try again later.";
                        }
                    } 
                    else 
                    {
                        $data["success"] = 0;
                        $data["message"] = "<i class='icon-remove-sign'></i> Email address does not matched.";
                    }
                } 
                else 
                {
                    $data["success"] = 0;
                    $data["message"] = "<i class='icon-remove-sign'></i> Please enter a valid email address.";
                }
            } 
            else 
            {
                $data["success"] = 0;
                $data["message"] = "<i class='icon-remove-sign'></i> Something went wrong, please try again later.";
            }
        }
        echo json_encode($data);
        die;
    }

    /*
     * Function For admin user logout
     */

    public function logout() 
    {
        $this->session->unset_userdata('admin_session');
        $this->session->unset_userdata('app_data');
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        redirect('admin/home', 'refresh');
    }

    public function check_email($email) 
    {
        if (!$this->admin_model->check_email($email)) 
        {
            $this->form_validation->set_message('check_email', 'Email not exist.');
            return false;
        }
    }

}
