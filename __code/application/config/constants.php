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


define('USER_TYPE_ROOT', 'ROOT');
define('USER_TYPE_DOCTOR', 'DOCTOR');

define('ERROR_URL', 'error');

/************* PAGE ID **************/
define('PAGE_ID_DASHBOARD', 'DASHBOARD');
define('PAGE_ID_DOCTORS', 'DOCTORS');
define('PAGE_ID_PATIENTS', 'PATIENTS');
define('PAGE_ID_SETTINGS', 'SETTINGS');
define('PAGE_ID_CONNEXION_LOG', 'CONNEXION_LOG');
define('PAGE_ID_FAQ', 'FAQ');
define('PAGE_ID_ERROR_404', 'ERROR_404');

/*************************************/
/***************LOGIN *****************/
define('LOGIN', 'LOGIN');
define('LOGIN_OK_URL', 'dashboard');
define('LOGIN_FAILED_URL', 'welcome');

define('LOGOUT', 'LOGOUT');
define('LOGOUT_OK_URL', '');

define('LOGIN_FAILED_FIELDS_REQUIRED','LOGIN_FAILED_FIELDS_REQUIRED');
define('LOGIN_FAILED_USERNAME_NOT_VALID','LOGIN_FAILED_USERNAME_NOT_VALID');
define('LOGIN_FAILED_PASSWORD_NOT_VALID','LOGIN_FAILED_PASSWORD_NOT_VALID');
/**************************************/
/************ STATE DOSSIER *************/

define('STATE_PROGRESS', 'EN_COURS');
define('STATE_DONE', 'TERMINE');
define('STATE_PENDING', 'SUSPENDU');


/**************************************/
/************ MAINTENANCE *************/
define('MAINTENANCE_MODE', false);

/**************************************/
/**************** FILE UPLOAD **********/
define('FILE_UPLOAD_DIR', 'upload/');

/***************************************/
/************* SEARCH *****************/
define('SEARCH_BY_NAME','SEARCH_BY_NAME');
define('SEARCH_BY_CESAM_DOSSIER_NUM','SEARCH_BY_CESAM_DOSSIER_NUM');
define('SEARCH_BY_DOCTOR_NAME','SEARCH_BY_DOCTOR_NAME');

/* End of file constants.php */
/* Location: ./application/config/constants.php */