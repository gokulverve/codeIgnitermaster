<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

define('ADMIN_SALT', '5&JDDlwz%Rwh!t2Yg-Igae@QxPzFTSId');
/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('GLM', "gl");
define('TRN', "tr");

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/* Config Param Start*/
define('THUMB_HEIGHT', 300);
define('THUMB_WIDTH', 300);


define('EMPTY_TABLE', 'No record(s) found');

/* Config Param End */

define('PROFILE_UPLOADING', 'assets/upload/profile/');
define('PROFILE_UPLOADING_ADMINUSER', 'assets/upload/admin-user-profile/');
define('PROFILE_UPLOADING_ADMIN', 'assets/upload/admin-profile/');

/* API Messages Start */
define('REQUIRED_FIELD', ' field is required.');
define('PLEASE_ENTER', 'Please enter your ');
define('EMAIL_EXIST', 'This email is already registered.');
define('LOGIN_FAILED', 'You have entered wrong pin & email address.');
define('LOGIN_SUCCESS', 'You are successfully logged-in.');
define('EMAIL_NOT_EXIST', 'Email does not exist.');
define('SUCCESS_LOADED', 'Data has been successfully loaded.');

/* API Messages End */

/*IOS Notification Settings*/
define("LIVE_URL","ssl://gateway.push.apple.com:2195");
define("SANDBOX_URL","ssl://gateway.sandbox.push.apple.com:2195");

//Android Notification
define("GOOGLE_API_KEY","AIzaSyCFPST73RxULFSvROVCZ2e9eGQc0vmnpyA");
define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
