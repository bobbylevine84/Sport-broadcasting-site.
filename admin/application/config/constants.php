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

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

date_default_timezone_set('Asia/Karachi');

define('DEFAULT_TITLE','Welcome to WiziWig Administration Panel');
define('DEFAULT_META_KEYWORDS','Default Meta Keywords');
define('DEFAULT_META_DESCRIPTION','default Meta Description');

// defining surl here
define('SURL','http://'.$_SERVER["HTTP_HOST"].'/admin/');
define('FRONT','http://'.$_SERVER["HTTP_HOST"]);
define('SUR','http://'.$_SERVER["HTTP_HOST"].'/');
define('IMAGES','http://'.$_SERVER['HTTP_HOST'].'/resources/phpthumb/phpThumb.php?src=../../uploads');
//define('IMAGES','http://'.$_SERVER['HTTP_HOST'].'/admin/resources/phpthumb/phpThumb.php?src=../../uploads');
define('FRONT_SURL','http://'.$_SERVER['HTTP_HOST'].'/admin/');

// defining image slider url surl here

define('IMG',SURL.'assets/img/');

define('IMG_slider',IMAGES.'/slideshow/');
define('IMG_liquidity',IMAGES.'/liquidity/');
define('IMG_partners',IMAGES.'/partners/');
define('IMG_document',IMAGES.'/temp/');
define('IMG_section',IMAGES.'/section/');
define('IMG_social_icons',IMAGES.'/social_icons/');
define('IMG_deposit_icons',IMAGES.'/deposit_icons/');
define('IMG_partner_icons',IMAGES.'/partner_icons/');



define('CSS',SURL.'assets/css/');
define('FONTS',SURL.'assets/fonts/');
define('JS',SURL.'assets/js/');
define('VENDOR',SURL.'assets/vendor/');
define('AJAX',SURL.'assets/ajax/');

define('USER_FOLDER',SURL.'assets/user_files/');
define('SLIDER_IMAGES',FRONT_SURL.'assets/slider.images/');
define('SPONSOR_IMAGES',FRONT_SURL.'assets/sponsor.images/');


/* End of file constants.php */
/* Location: ./application/config/constants.php */