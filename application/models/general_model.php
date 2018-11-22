<?php

class general_model extends CI_Model {

    /** Defining parent constructor */
    function __consruct() {
        parent::__consruct();
    }

    /** Returns Rows based on condition array provided */
    public function countRows($table = NULL, $conditionArray = NULL) { 
        if ($table == NULL) {
            exit("Table name is required!");
        }
        if ($conditionArray == NULL) {
            $query = $this->db->get($table);/** Using CI `get` method */
            return $query->num_rows();/** Return rows */
        } else {
            $query = $this->db->get_where($table, $conditionArray);/** Using CI `get_where` method */
            return $query->num_rows();/** Return rows */
        }
    }

    /*
      |
      |  Returns Rows based on columns and condition/s array provided
      |
      |	*~~~~~~~PARAMS:~~~~~~~*
      |
      |	@$table : table name
      |	@columns : if all specifiy "*" else comma separated list of columns "name,email,first_name" etc
      |	@conditionArray : array with column names values for their conditions
      |	@returnArray : if "true" returns array else object
      |
     */
    public function getRows($table = NULL, $columns = NULL, $conditionArray = NULL, $returnArray = NULL) 
    {
        if ($table == NULL) 
        {
            exit("Table name is required!");
        }
        
        if ($conditionArray == NULL) 
        {
            if ($columns == "*") 
            {
                $query = $this->db->get($table);/** Using CI `get` method */
            } 
            else 
            {
                $this->db->select($columns)->from($table);
                $query = $this->db->get();
            }
            if ($returnArray == true) 
            {
                return $query->result_array();/** Return rows in array format */
            } 
            else 
            {
                return $query->result();
            }
        } 
        else 
        {
            if ($columns == "*") 
            {
                $query = $this->db->get_where($table, $conditionArray);
            } 
            else 
            {
                $this->db->select($columns)->from($table);
                $this->db->where($conditionArray);
                $query = $this->db->get();
            }

           // echo $this->db->last_query();
            /** Using CI `get_where` method */
            return $query->result();/** Return rows */
        }
    }

	public function getAllRows($table = NULL) 
    {
        $this->db->select('*');
        $query = $this->db->from($table);
        $result = $query->get();
        $result = $result->result();
        //echo $this->db->last_query();
        return $result;
    }

    public function getSingleRow($table = NULL, $conditionArray, $cols = NULL) 
    {
        if ($table == NULL) 
        {
            exit("Table name is required!");
        }
        if ($conditionArray == NULL) 
        {
            exit("Condition array is required!");
        } 
        else 
        {
            if ($cols == NULL) 
            {
                $query = $this->db->get_where($table, $conditionArray);/** Using CI `get_where` method */
                return $query->first_row();/** Return rows */
            } 
            else 
            {
                $query = $this->db->select($cols)->from($table)->where($conditionArray)->get();
                return $query->first_row();
            }
        }
    }

    /** General Data Insertion function - Returns Inserted Row ID */
    public function insertData($table = NULL, $dataArray = NULL) 
    {
        if ($table == NULL) 
        {
            exit("Table name is required!");
        }
        if ($dataArray == NULL) 
        {
            exit("Data array is required! 1");
        }

        $query = $this->db->insert($table, $dataArray);
        if (!$this->db->insert_id()) 
        {
            return array("error" => $this->db->_error_message());
        }
        return array("insertedRowId" => $this->db->insert_id());
    }

    /** General Data Insertion function - Returns Inserted Row ID */
    public function insertBatchData($table = NULL, $dataArray = NULL) 
    {
        if ($table == NULL) 
        {
            exit("Table name is required!");
        }
        if ($dataArray == NULL) 
        {
            exit("Data array is required! 2");
        }
        $query = $this->db->insert_batch($table, $dataArray);
        return true;
    }

    /** General Data Update function - Returns Inserted Row ID */
    public function updateData($table = NULL, $conditionArray = NULL, $dataArray = NULL) 
    {
        if ($table == NULL) 
        {
            exit("Table name is required!");
        }
        if ($conditionArray == NULL) 
        {
            exit("Condition array is required!");
        }
        if ($dataArray == NULL) 
        {
            exit("Data array is required! 3");
        }
        /** If rows or row is found then update it else return false */
        if ($this->countRows($table, $conditionArray) > 0) 
        {
            $this->db->where($conditionArray);
            $this->db->update($table, $dataArray);
            return array("affectedRows" => $this->db->affected_rows());
        } 
        else 
        {
            return array("error" => "No rows found.");
        }
    }

    public function deleteData($table = NULL, $conditionArray = NULL) 
    {
        if ($table == NULL) 
        {
            exit("Table name is required!");
        }
        if ($conditionArray == NULL) 
        {
            exit("Condition array is required!");
        }
        $this->db->where($conditionArray);
        $this->db->delete($table);

        return true;
    }

    /** General Data mail function - Returns True/false */
    public function mail($fromemail, $from_company_name, $to, $subject, $message) 
    {
        //$config = array('mailtype' => 'html');
        //$this->load->library('email', $config);
        $this->email->from($fromemail, $from_company_name);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        
        if (!$this->email->send()) 
        {
            die($this->email->print_debugger());
            return false;
        } 
        else 
        {
            return true;
        }
    }
	
	
	 /** General Data mail function - Returns True/false */
    public function mailwithattachment($fromemail, $from_company_name, $to, $subject, $message,$file_name="") 
    {
        //$config = array('mailtype' => 'html');
        //$this->load->library('email', $config);
        $this->email->from($fromemail, $from_company_name);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
		$this->email->attach($file_name );
        
        if (!$this->email->send()) 
        {
            die($this->email->print_debugger());
            return false;
        } 
        else 
        {
            return true;
        }
    }

    /*     * *****************
     *
     * @param    string    $columns      coma seprated columns to be select in query
     * @param    Array     $from         From table or Primary table
     * @param    Array     $joins        Array of joins 
     * @param    Array     $conditions   Array of Conditions 
     * 
     * @return    Array    $query->result()    result array
     * 
     * ******************* */

    public function getJoinData($columns, $from, $joins = null, $condition = array(), $groupby = null, $orderby = null, $limit = 0, $offset = 0) 
    {
        $this->db->select($columns);
        $this->db->from($from);
        if (is_array($joins) && !empty($joins)) 
        {
            foreach ($joins as $join) 
            {
                if (isset($join[2])) 
                {
                    $this->db->join($join[0], $join[1], $join[2]);
                } 
                else 
                {
                    $this->db->join($join[0], $join[1]);
                }
            }
        }
        if (is_array($condition) && !empty($condition)) 
        {
            foreach ($condition as $key => $value) 
            {
                if (is_array($value)) 
                {
                    $this->db->where_in($key, $value);
                } 
                else 
                {
                    $this->db->where($key, $value);
                }
            }
        }
        if ($groupby) 
        {
            $this->db->group_by($groupby);
        }
        if ($orderby) 
        {
            $this->db->order_by($orderby);
        }
        if ($limit && $limit > 0) 
        {
            if ($offset && $offset > 0) 
            {
                $this->db->limit($limit, $offset);
            } 
            else 
            {
                $this->db->limit($limit);
            }
        }       
        $query = $this->db->get();
        return $query->result();
    }
}
