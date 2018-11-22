<?php
class dashboards extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		error_reporting(0);
	}
	
	/*
     * Get count information
     */
	public function getCount1($table,$type="")
	{
		if($type != "")
		{
			$this->db->where("user_type",$type);
		}
		if($table == 'city')
		{			
			$this->db->where("country_id",US_COUNTRY_ID);
		}
		return $this->db->count_all_results($table);
	}
}
?>