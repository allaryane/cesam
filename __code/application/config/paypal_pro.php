<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/******************** Entête UTF-8 ******************\
*
*	fichier			: config/paypal_pro.php
*	projet			: 
*	version			: 1.0.0 2011/07/04 16:40 EV
*
\****************************************************/

if (in_array(ENVIRONMENT, array('development', 'stage'))) {
	$config['Sandbox'] = TRUE;
} else {
	$config['Sandbox'] = FALSE;
}
$config['APIVersion'] = '66.0';
$config['APIUsername'] = $config['Sandbox'] ? 'SANDBOX_USERNAME_GOES_HERE' : 'PRODUCTION_USERNAME_GOES_HERE';
$config['APIPassword'] = $config['Sandbox'] ? 'SANDBOX_PASSWORD_GOES_HERE' : 'PRODUCTION_PASSWORD_GOES_HERE';
$config['APISignature'] = $config['Sandbox'] ? 'SANDBOX_SIGNATURE_GOES_HERE' : 'PRODUCTION_SIGNATURE_GOES_HERE';

/* End of file paypal_pro.php */
/* Location: ./system/application/config/paypal_pro.php */
