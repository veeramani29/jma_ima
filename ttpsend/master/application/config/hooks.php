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

$hook['pre_controller'][] = array(
                                'class'    => 'MyClass',
                                'function' => 'load_header',
                                'filename' => 'Myclass.php',
                                'filepath' => 'hooks'
                               // 'params'   => array('beer', 'wine', 'snacks')
                                );

$hook['pre_controller'][] = array(
                                'class'    => 'MyClass',
                                'function' => 'check_session',
                                'filename' => 'Myclass.php',
                                'filepath' => 'hooks'
                               // 'params'   => array('beer', 'wine', 'snacks')
                                );

$hook['pre_controller'][] = array(
                                'class'    => 'MyClass',
                                'function' => '__autoload',
                                'filename' => 'Myclass.php',
                                'filepath' => 'hooks'
                               // 'params'   => array('beer', 'wine', 'snacks')
                                );

$hook['pre_controller'][] = array(
                                'class'    => 'MyClass',
                                'function' => 'get_global_admin_data',
                                'filename' => 'Myclass.php',
                                'filepath' => 'hooks'
                               // 'params'   => array('beer', 'wine', 'snacks')
                                );




$hook['post_controller'] = array(
                                'class'    => 'MyClass',
                                'function' => 'load_footer',
                                'filename' => 'Myclass.php',
                                'filepath' => 'hooks'
                                //'params'   => array('beer', 'wine', 'snacks')
                                );


/* End of file hooks.php */
/* Location: ./application/config/hooks.php */