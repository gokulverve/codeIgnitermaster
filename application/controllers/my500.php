<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class my500 extends CI_Controller {
    public function __construct() {
        parent::__construct();
	}
    public function index(){
		$this->output->set_status_header('500'); 
		$arr['page'] = '500';
		$data['page_title'] = '500 - KISBooks';
        $this->load->view('page_500',$data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */