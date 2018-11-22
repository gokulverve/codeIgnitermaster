<?php
class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
}

class Admin_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$admin_session = $this->session->userdata('admin_session');
		// pr($admin_session);
		if (!$admin_session['is_admin_login']) 
        {
            redirect('admin/home');
        }
        $this->PER_PAGE = '25';
        $this->show_per_page = array("25" => 25,"50"=>50,"100" => 100);
    }
}

class Staff_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$staff_session = $this->session->userdata('staff_session');
		// pr($staff_session);
		if (!$staff_session['is_staff_login']) 
        {
            redirect('staff');
        }
        $this->PER_PAGE = '25';
        $this->show_per_page = array("25" => 25,"50"=>50,"100" => 100);
    }
}

class Front_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$customer_session = $this->session->userdata('customer_session');
		// pr($customer_session);
		if (!$customer_session['is_front_login']) 
        {
            redirect('products');
        }
        $this->PER_PAGE = '25';
        $this->show_per_page = array("25" => 25,"50"=>50,"100" => 100);
    }
}