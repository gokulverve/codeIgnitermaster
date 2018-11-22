<?php
$config['useragent'] = 'CodeIgniter';
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_user'] = 'apiteamtesting@gmail.com';
$config['smtp_pass'] = '123456@@';
//$config['smtp_user'] = 'phpredstorm@gmail.com';
//$config['smtp_pass'] = 'zTl0T0RBucpRudc';
$config['smtp_port'] = 465; 
$config['smtp_timeout'] = 5;
$config['wordwrap'] = TRUE;
$config['wrapchars'] = 76;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['validate'] = FALSE;
$config['priority'] = 3;
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";
$config['bcc_batch_mode'] = FALSE;
$config['bcc_batch_size'] = 200;

defined('BASEPATH') OR exit('No direct script access allowed');
?>