<?php

class Cms_model extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }

    function get_cms_list($where=array(),$request_type = 'data',$fileds = "*")
    {
        if($request_type == 'data')
        {
            $this->db->select("tbl_cms.*");
        }
        else
        {
            $this->db->select('COUNT(tbl_cms.cms_id) as total_records');
        }        
        $this->db->from('tbl_cms');
        $this->db->where("is_deleted","0");   
        
        if (isset($where['search']) && $where['search'] != "") 
        {
            $this->db->where("(cms_name  LIKE '%".addslashes($where['search'])."%')");
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
            $this->db->order_by('cms_name','ASC');

        if($request_type == 'count')
        {
            $result = $this->db->get()->row_array();
            return $result['total_records'];
        }
        else
        {
            return $this->db->get()->result();
        }
    }

    function update_cms($cms_id, $cms_data)
    {
        $this->db->where("cms_id",$cms_id);
        $this->db->update("tbl_cms",$cms_data);
        return true;
    }

    function get_cms_detail($cms_id)
    {
        $this->db->select("*");
        $this->db->where("cms_id",$cms_id);
        $this->db->from("tbl_cms");
        return $this->db->get()->row_array();
    }

    function insert_cms($cms_data)
    {
        $this->db->insert("tbl_cms",$cms_data);
        return  $this->db->insert_id();
    }

    function check_cms_exist($cms_name, $cms_id)
    {
        $this->db->select("cms_name");
        if ($cms_id != "") 
        {
            $this->db->where("cms_id",$cms_id);
        }
        $this->db->where("is_deleted","0");
        $this->db->where("cms_name",$cms_name);
        $this->db->from("tbl_cms");
        return $this->db->get()->row_array();
    }
}

?>