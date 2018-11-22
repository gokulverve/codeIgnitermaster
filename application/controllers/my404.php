<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class my404 extends CI_Controller {
    public function __construct() {
        parent::__construct();
	}
    public function index(){
		$this->output->set_status_header('404'); 
		$arr['page'] = '404';
		$data['page_title'] = '404 - KISBooks';
        $this->load->view('page_404',$data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */