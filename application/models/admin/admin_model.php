<?php
class Admin_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/*
     * Update admin user information
     */
	public function edit($data,$email)
	{
        $this->db->where('email_address',$email);
        return $this->db->update('tbl_admin',$data);
	}
	
	/*
     * Check email exist or not
     */
	public function check_email($email) 
	{
        $this->db->where('email_address',$email);
        $query = $this->db->get('tbl_admin');
		if ($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
     * Get admin user information
     */
	public function getValue($id) 
	{
        $this->db->where('admin_id',$id);
        $query = $this->db->get('tbl_admin');
		return $query->result();
	}
	
	/*
     * Update admin user profile information
     */
	public function edit_profile($data,$id)
	{
        $this->db->where('admin_id',$id);
        return $this->db->update('tbl_admin',$data);
	}

	function update_admin($admin_id, $data)
    {
        $this->db->where("admin_id",$admin_id);
        $this->db->update("tbl_admin",$data);
        return true;
    }


    function check_email_exist($email_address, $admin_id)
    {
        $this->db->select("email_address");
        if ($admin_id != "") 
        {
            $this->db->where("admin_id",$admin_id);
        }
        $this->db->where("is_deleted","0");
        $this->db->where("email_address",$email_address);
        $this->db->from("tbl_admin");
        return $this->db->get()->row_array();
    }
}
?>