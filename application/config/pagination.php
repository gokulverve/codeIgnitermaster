<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pagination Config
 * 
 * Just applying codeigniter's standard pagination config with twitter 
 * bootstrap stylings
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		pagination.php
 * @version		1.0
 * @date		09/28/2011
 * 
 * Copyright (c) 2011
 */
 
// --------------------------------------------------------------------------

// $config['base_url'] = '';
$config["per_page"] = PER_PAGE;
$config['uri_segment'] = 3;
$config['use_page_numbers'] = TRUE;
$config['display_pages'] = true;
$config['full_tag_open'] = '<section class="panel"><div class="panel-body"><div class="text-center"><ul class="pagination pagination-lg">';
$config['full_tag_close'] = '</ul></div></div></section>';
$config['prev_link'] = '&laquo;';
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';
$config['next_link'] = '&raquo;';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = '<li class="active"><a href="#">';
$config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
$config['next_link'] = '>>';
$config['prev_link'] = '<<';
 $config['first_link'] = '« First';
  $config['first_tag_open'] = '<li class="prev page">';
  $config['first_tag_close'] = '</li>';
  $config['last_link'] = 'Last »';
  $config['last_tag_open'] = '<li class="next page">';
  $config['last_tag_close'] = '</li>';

// --------------------------------------------------------------------------

/* End of file pagination.php */
/* Location: ./booktrack/application/config/pagination.php */