<?php

class Setting_model extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }

    function update_smtp($smtps_id, $smtp_data)
    {
        $this->db->where("smtp_id",$smtps_id);
        $this->db->update("tbl_smtp_settings",$smtp_data);
        return true;
    }

    function update_noti_setting($noti_id, $noti_data)
    {
        $this->db->where("setting_id",$noti_id);
        $this->db->update("tbl_pushnotification_setting",$noti_data);
        return true;
    }

    function get_smtp_detail($setting_id)
    {
        $this->db->select("*");
        $this->db->where("smtp_id",$setting_id);
        $this->db->from("tbl_smtp_settings");
        return $this->db->get()->row_array();
    }

     function get_pushnotification_setting_detail($setting_id)
    {
        $this->db->select("*");
        $this->db->where("setting_id",$setting_id);
        $this->db->from("tbl_pushnotification_setting");
        return $this->db->get()->row_array();
    }

}

?>