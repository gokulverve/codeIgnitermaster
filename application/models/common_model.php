<?php
class Common_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

	function select_data_by_condition($table,$condition=array(),$fields="*")
	{
		// example code how to add conditions in controllers
		// $condition = array();
		// $condition['where'] = array($field1 => $value1,$field2 => $value2);
		// $condition['where_in'] = array($field1 => array($value1,$value2));
		// $condition['where_not_in'] = array($field1 => array($value1,$value2));
		// $condition['order_by'] = array($field1 => "ASC/DESC");
		// $condition['group_by'] = array($field);
		// $condition['limit'] = 1;

		$where        = isset($condition["where"])?$condition["where"]:array();
		$where_in     = isset($condition["where_in"])?$condition["where_in"]:array();
		$where_not_in = isset($condition["where_not_in"])?$condition["where_not_in"]:array();
		$order_by     = isset($condition["order_by"])?$condition["order_by"]:array();
		$group_by     = isset($condition["group_by"])?$condition["group_by"]:"";
		$limit        = isset($condition["limit"])?$condition["limit"]:"";

		// $this->db->_protect_identifiers=false;
		$this->db->select($fields);

		//condition for where
		foreach ($where as $key => $value)
		{
			if(is_numeric($key))
			{
				$this->db->where($value);
			}
			else
			{
				$this->db->where($key,$value);
			}
		}

		//condition for where_in
		foreach($where_in as $key => $value)
		{
			if(is_array($value))
			{
				$this->db->where_in($key,$value);
			}
		}

		//condition for where_not_in
		foreach ($where_not_in as $key => $value)
		{
			if(is_array($value))
			{
				$this->db->where_not_in($key,$value);
			}
		}

		$this->db->from($table);

		//condition for order by
		foreach ($order_by as $key => $value)
		{
			$this->db->order_by($key, $value);
		}
		
		//condition for group by
		if($limit != "")
		{
			$this->db->limit($limit);
		}

		//condition for group by
		if($group_by != "")
		{
			$this->db->group_by($group_by);
		}

		return $this->db->get()->result_array();		
	}

	function select_count($table,$condition=array(),$fields="*",$rows="")
	{
		// example code how to add conditions in controllers
		// $condition = array();
		// $condition['where'] = array($field1 => $value1,$field2 => $value2);
		// $condition['where_in'] = array($field1 => array($value1,$value2));
		// $condition['where_not_in'] = array($field1 => array($value1,$value2));
		// $condition['order_by'] = array($field1 => "ASC/DESC");
		// $condition['group_by'] = array($field);
		// $condition['limit'] = 1;

		$where        = isset($condition["where"])?$condition["where"]:array();
		$where_in     = isset($condition["where_in"])?$condition["where_in"]:array();
		$where_not_in = isset($condition["where_not_in"])?$condition["where_not_in"]:array();
		$order_by     = isset($condition["order_by"])?$condition["order_by"]:array();
		$group_by     = isset($condition["group_by"])?$condition["group_by"]:"";
		$limit        = isset($condition["limit"])?$condition["limit"]:"";

		// $this->db->_protect_identifiers=false;
		$this->db->select($fields);

		//condition for where
		foreach ($where as $key => $value)
		{
			if(is_numeric($key))
			{
				$this->db->where($value);
			}
			else
			{
				$this->db->where($key,$value);
			}
		}

		//condition for where_in
		foreach($where_in as $key => $value)
		{
			if(is_array($value))
			{
				$this->db->where_in($key,$value);
			}
		}

		//condition for where_not_in
		foreach ($where_not_in as $key => $value)
		{
			if(is_array($value))
			{
				$this->db->where_not_in($key,$value);
			}
		}

		$this->db->from($table);

		//condition for order by
		foreach ($order_by as $key => $value)
		{
			$this->db->order_by($key, $value);
		}
		
		//condition for group by
		if($limit != "")
		{
			$this->db->limit($limit);
		}

		//condition for group by
		if($group_by != "")
		{
			$this->db->group_by($group_by);
		}

		$response = $this->db->get()->row_array();		
		return $response['count'];
	}

	public function insert_batch($table,$data)
	{
		$this->db->insert_batch($table, $data);
		return $this->db->insert_id();
	}

	public function update_table_data($table,$data,$condition=array())
	{
		// example code how to add conditions in controllers
		// $condition = array();
		// $condition['where'] = array($field1 => $value1,$field2 => $value2);
		// $condition['where_in'] = array($field1 => array($value1,$value2));
		// $condition['where_not_in'] = array($field1 => array($value1,$value2));

		$where =   isset($condition["where"])?$condition["where"]:array();
		$where_in= isset($condition["where_in"])?$condition["where_in"]:array();
		$where_not_in= isset($condition["where_not_in"])?$condition["where_not_in"]:array();

		// $this->db->_protect_identifiers=false;
		//condition for where
		foreach ($where as $key => $value)
		{
			if(is_numeric($key))
			{
				$this->db->where($value);
			}
			else
			{
				$this->db->where($key,$value);
			}
		}
		//condition for where_in
		foreach ($where_in as $key => $value)
		{
			if(is_array($value))
			{
				$this->db->where_in($key,$value);
			}
		}
		//condition for where_not_in
		foreach ($where_not_in as $key => $value)
		{
			if(is_array($value))
			{
				$this->db->where_not_in($key,$value);
			}
		}

		$this->db->update($table, $data);
	}

    function delete_table_data($table, $condition=array())
	{
		// example code how to add conditions in controllers
		// $condition = array();
		// $condition['where'] = array($field1 => $value1,$field2 => $value2);
		// $condition['where_in'] = array($field1 => array($value1,$value2));
		// $condition['where_not_in'] = array($field1 => array($value1,$value2));

		$where        = isset($condition["where"])?$condition["where"]:array();
		$where_in     = isset($condition["where_in"])?$condition["where_in"]:array();
		$where_not_in = isset($condition["where_not_in"])?$condition["where_not_in"]:array();

		//condition for where
		foreach ($where as $key => $value)
		{
			if(is_numeric($key))
			{
				$this->db->where($value);
			}
			else
			{
				$this->db->where($key,$value);
			}
		}

		//condition for where_in
		foreach ($where_in as $key => $value)
		{
			if(is_array($value))
			{
				$this->db->where_in($key,$value);
			}
		}

		//condition for where_not_in
		foreach ($where_not_in as $key => $value)
		{
			if(is_array($value))
			{
				$this->db->where_not_in($key,$value);
			}
		}

	   $this->db->delete($table);	   
	   return true;
    }

    function begin_transaction()
	{
		$this->db->trans_begin();
	}

	function complete_transaction()
	{
		$this->db->trans_commit();
	}

	function rollback_transaction()
	{
		 $this->db->trans_rollback();
	}

	function trans_status()
	{
		return $this->db->trans_status();
	}

	public function check_record_exist($table, $condition)
	{
		$where = isset($condition["where"])?$condition["where"]:array();
		$this->db->select("*");
		$this->db->from($table);
		foreach ($where as $key => $value)
		{
			if(is_numeric($key))
			{
				$this->db->where($value);
			}
			else
			{
				$this->db->where($key,$value);
			}
		}
		return $this->db->get()->row_array();
	}

	public function insert_update_action($type, $table, $data, $where_array = array())
	{
		if ($type == 'insert')
		{
			$this->db->insert($table, $data);
			return $id = $this->db->insert_id();
		}
		elseif ($type == 'update')
		{
	   		if (count($where_array) > 0)
	   		{
				$this->db->where($where_array);
				$response = $this->db->update($table, $data);
				return true;
			}
		}
		else
		{
			return false;
		}
	}

	public function update_batch_with_key($tbl, $data, $key)
	{
		$this->db->update_batch($tbl, $data, $key);
	}
}
?>