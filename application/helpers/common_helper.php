<?php
	
	function pr($data)
    {
    	echo "<pre>";print_r($data);exit;
    }

    function pr1($data)
    {
    	echo "<pre>";print_r($data);
    }

    function base_id($id)
    {
    	$encode_id = base64_encode($id);
    	$id = str_replace("==","",$encode_id);   	
    	$id = str_replace("=","",$id);
    	return $id;
    }


    function get_pagination($base_url = '', $suffix = '', $total_rows = 0, $uri_segment = 3, $per_page = 0, $num_links = 2,$page_query_string=FALSE)
	{
		$config['uri_segment']       = $uri_segment;
		$config['base_url']          = $base_url;
		$config['suffix']            = $suffix;
		$config['per_page']          = $per_page;
		$config['num_links']         = $num_links;
		$config['total_rows']        = $total_rows;
		$config['page_query_string'] = $page_query_string;

		if($page_query_string)
		$config['query_string_segment']  = "page";

		$config['anchor_class']       = 'pagination_link';
		$config['first_tag_open']     = '<li>';
		$config['first_tag_close']    = '</li>';
		$config['num_tag_open']       = '<li>';
		$config['num_tag_close']      = '</li>';		
		$config['next_tag_open']      = '<li>';		
		$config['next_tag_close']     = '</li>';		
		$config['prev_tag_open']      = '<li>';		
		$config['prev_tag_close']     = '</li>';		
		$config['last_tag_open']      = '<li>';		
		$config['last_tag_close']     = '</li>';		
		$config['cur_tag_open']       = '<li class="active">';		
		$config['cur_tag_close']      = '</li>';		
		$config['full_tag_open']      = '<ul class="pagination">';		
		$config['full_tag_close']     = '</ul>';
		$config['next_link']          = '&gt;';
		$config['last_link']          = '&gt;&gt;';
		$config['prev_link']          = '&lt;';
		$config['first_link']         = '&lt;&lt;';

		$CI =& get_instance();
		$CI->load->library('Pagination_Custom');		
		$CI->pagination_custom->initialize($config);		
		return $CI->pagination_custom->create_links();
	}

	function send_email($content_array = array()) 
	{
		$to      = (isset($content_array['to']))?$content_array['to']:"";
		$subject = (isset($content_array['subject']))?$content_array['subject']:"";
		$message = (isset($content_array['message']))?$content_array['message']:"";
		$from    = (isset($content_array['from']))?$content_array['from']:get_configurations_value('ADMIN_EMAIL');
		$cc      = (isset($content_array['cc']))?$content_array['cc']:"";
		$bcc     = (isset($content_array['bcc']))?$content_array['bcc']:"";
		$data    = (isset($content_array['data']))?$content_array['data']:"";

	    $CI =& get_instance();
	    $CI->load->library('email'); // load library 
	    $config = Array(
	        'protocol'     => 'smtp',
	        'smtp_host'    => 'ssl://smtp.googlemail.com',
	        'smtp_port'    => 465,
	        'smtp_timeout' => '30',
	        'charset'      => 'iso-8859-1',
	        'mailtype'     => 'html',
	        'smtp_user'    => get_configurations_value('SMTP_USER'),
	        'smtp_pass'    => get_configurations_value('SMTP_PASSWORD'),
	    );      
	    $CI->email->initialize($config);
	    $CI->email->set_newline("\r\n");
	    $CI->email->set_priority(1);
	    $CI->email->subject($subject);
	    $CI->email->message($message);
	    $CI->email->from($from, PROJECT_NAME);
	    $CI->email->to($to);
	    
	    if ($cc != "") 
	    {
	    	$CI->email->cc($cc);
	    }
	    
	    if ($bcc != "") 
	    {
	    	$CI->email->bcc($bcc); 
	    }

	    if (!empty($data['attachment']))
	    {
	        $CI->email->attach($data['file_path'].$data['attachment']);
	    } 
	    
	    if ($CI->email->send())
	    {
	       $CI->email->clear(TRUE);
	       return TRUE;
	    }
	    else
	    {
	        return $CI->email->print_debugger();            
	    }
	}

    function get_configurations_value($name = "")
    {
	    $CI = & get_instance();

	    $condition = array();
	    $condition["order_by"] = array("name"=>"desc");
	    if( $name != "" )
	    {
	    	$condition['where'] = array("name" => $name);	    	
	    }
		$configurations = $CI->common_model->select_data_by_condition("configurations",$condition,array('name','value'));

		if ($name != "") 
		{
			return $configurations[0]['value'];
		}
		else
		{
			return helper_array_column($configurations, 'name','value');
		}
	}

	function generate_random_password()
	{
		$length = 12;
		$gift_code = substr(str_shuffle("123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		return $gift_code;
	}

    function get_formatted_date($date = NULL)
    {
    	$formated_date = '';
    	if (!is_null($date) && $date != "0000-00-00")
    	{
			$formated_date = date('d-m-Y', strtotime($date));
    	}
        return $formated_date;
    }

    function helper_array_column($input, $array_index_key = NULL , $array_value = NULL ) 
	{
		$result = array();
		if (count($input) > 0)
		{
			foreach ($input as $key => $value)
			{
				if(is_array($value))
				{
					$result[is_null($array_index_key) ? $key : (string)$value[$array_index_key]] = is_null($array_value) ? $value : $value[$array_value];
				}
				else if(is_object($value))
				{
					$result[is_null($array_index_key) ? $key : (string)$value->$array_index_key] = is_null($array_value) ? $value : $value->$array_value;
				}    
			}
		} 
		return $result;
	}

	function price_format($price)
	{
		return sprintf("%0.4f",$price);
	}

	function currency_symbol($currency_code='')
	{
	    $icon = '';
	    switch ($currency_code)
	    {
	        case 'USD':
	        case 'CAD':
	            $icon = '$ ';
	            break;
	        case 'GBP':
	            $icon = '&pound; ';
	            break;
	        case 'EUR':
	            $icon = '&euro;'; 
	            break;
	        case 'CNY':
	            $icon = '&yen;'; 
	            break;
	        case 'THB':
	            $icon = '&#3647;'; 
	            break;
	        case 'YPY':
	        case 'JPY':
	            $icon = '&yen;'; 
	            break;
	        default:
	            $icon = '$ ';
	            break;
	    }
	    return $icon;
	}

	function reference_number($id)
	{
		if ($id != "") 
		{
			if (strlen($id) < 8) 
			{
				return sprintf("%08d",$id);
			}
			else
			{
				return $id;
			}
		}
	}

