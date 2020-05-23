<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|   application/hooks/ConfigUsuarios.php
*/
$hook['post_controller_constructor'][] = array(
    'class'     => 'ConfigUsuarios', 
    'function'  => 'checkAccess', 
    'filename'  => 'ConfigUsuarios.php',
    'filepath'  => 'hooks',
    'param'     => []
);
$hook['post_controller_constructor'][] = array(
    'class'     => 'ConfigUsuarios', 
    'function'  => 'ControladorPermitido', 
    'filename'  => 'ConfigUsuarios.php',
    'filepath'  => 'hooks',
    'param'     => []
);
$hook['post_controller'] = array(     			// 'post_controller' indicated execution of hooks after controller is finished
    'class'     => 'Audi_log',             			// Nombre de la clase.
    'function'  => 'Insertar_audi_log',     		// Nombre de la funcion que se va a ejecutar desde la clase.
    'filename'  => 'AuditoriaLog.php',    			// Nombre del hooks file.
    'filepath'  => 'hooks'         			// Name of folder where Hook file is stored.
);