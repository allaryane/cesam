<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_system'] = array(
							'class'    => 'Cesam_hook',
							'function' => 'pre_system',
							'filename' => 'Cesam_hook.php',
							'filepath' => 'hooks',
							'params'   => array()
						);

$hook['pre_controller'] = array(
							'class'    => 'Cesam_hook',
							'function' => 'pre_controller',
							'filename' => 'Cesam_hook.php',
							'filepath' => 'hooks',
							'params'   => array()
						);

$hook['post_controller'] = array(           'class'    => 'Cesam_hook',
                                            'function' => 'post_controller',
                                            'filename' => 'Cesam_hook.php',
                                            'filepath' => 'hooks',
                                            'params' => array()
                                            );



$hook['post_controller_constructor'] = array(
							'class'    => 'Cesam_hook',
							'function' => 'post_controller_constructor',
							'filename' => 'Cesam_hook.php',
							'filepath' => 'hooks',
							'params'   => array()
						);


$hook['post_system'] = array(
							'class'    => 'Cesam_hook',
							'function' => 'post_system',
							'filename' => 'Cesam_hook.php',
							'filepath' => 'hooks',
							'params'   => array()
						);




/* End of file hooks.php */
/* Location: ./application/config/hooks.php */

