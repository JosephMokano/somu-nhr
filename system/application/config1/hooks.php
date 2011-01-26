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

/*$hook['pre_controller'] = array(
	'class' => 'globalsystem',
	'function' => 'initializeSystem',
	'filename' => 'globalsystem.php',
	'filepath' => 'hooks'
);*/

/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */
$hook['display_override'] = array(
        'class'    => 'Amfphp',
        'function' => 'output',
        'filename' => 'amfphp.php',
        'filepath' => 'hooks'
        ); 