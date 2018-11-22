<?php

class Users_model extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }

    function get_users_list($where=array(),$request_type = 'data',$fileds = "*")
    {
        $this->db->_protect_identifiers = FALSE;
        if($request_type == 'data')
        {
            $this->db->select("tbl_users.*");
        }
        else
        {
            $this->db->select('COUNT(tbl_users.user_id) as total_records');
        }        
        $this->db->from('tbl_users');
        $this->db->where("is_deleted","0");   
        
        if (isset($where['search']) && $where['search'] != "") 
        {
            $this->db->where("(tbl_users.first_name  LIKE '%".addslashes($where['search'])."%' OR
                               tbl_users.email_address LIKE '%".addslashes($where['search'])."%' OR 
                               CONCAT(tbl_users.first_name, ' ', tbl_users.last_name) LIKE '%".addslashes($where['search'])."%' OR 
                               tbl_users.last_name  LIKE '%".addslashes($where['search'])."%' )");
        }

        if (isset($where['status']) && $where['status'] != "") 
        {
            $this->db->where("status",$where['status']);
        }
        
        if($request_type == 'data')
        {
            $page = $where['offset'];

            if($page != 0) $page = --$page;

            $this->db->limit($where['limit']);

            $this->db->offset($page*$where['limit']);
        }     

        if($where['sort_by'] != '' && $where['sort_direction'] != '')   
            $this->db->order_by($where['sort_by'],$where['sort_direction']);
        else
            $this->db->order_by('user_id','DESC');

        if($request_type == 'count')
        {
            $result = $this->db->get()->row_array();
            return $result['total_records'];
        }
        else
        {
            return $this->db->get()->result_array();
        }
    }

    function get_driver_last_id()
    {
        $this->db->select("user_id,driver_special_id");
        $this->db->from("tbl_users");
        $this->db->order_by("user_id","desc");
        return $this->db->get()->row_array();
    }
}
?>