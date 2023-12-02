<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('debug'))
{
	function debug($item,$ext=0)
	{
		if($ext==1){
			echo  "<pre>";print_r($item);die;
		}else{
			echo  "<pre>";print_r($item);
		}
		

		
	}
}
