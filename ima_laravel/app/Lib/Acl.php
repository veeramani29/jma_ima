<?php
//if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');

//echo '<pre>';
//print_r($_SESSION); exit;
namespace App\Lib;
use Exception;
use  Session;
class Acl {
	private $user;
	private $user_permissions;
//	$autoloader = new Autoloader('modal');
//	$autoloader->loadThisClass($adtClass);
	public function __construct() {
			$this->user = array(
				'id' => 0,
				'fname' => '',
				'lname' => '',
				'user_type' => '',
				'user_status' => '',
				'registered_on' => '',
				'expiry_on' => ''
			);
			$this->user_permissions = array();
			if(isset($_SESSION['user']) && count($_SESSION['user'])>0) {
				$this->setUserDetails($_SESSION['user']);
				$this->setUserPermissions($_SESSION['user']['user_permissions']);
			}
	}
	
	public function setUserDetails($user) {
		try{
			if(is_array($user) && count($user)>0) {
				$this->user['id'] = $user['id'];
				$this->user['fname'] = $user['fname'];
				$this->user['lname'] = $user['lname'];
				$this->user['user_type'] = $user['user_type'];
				$this->user['user_status'] = $user['user_status'];
				$this->user['registered_on'] = $user['registered_on'];
				$this->user['expiry_on'] = $user['expiry_on'];
			}else {
				throw new Exception('Empty user details', 9999);
			}
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
	}
	
	public function setUserPermissions($permissions){
		try{
			if(is_array($permissions)) {
				$this->user_permissions = $permissions;
			}
			/*
			if(is_array($permissions) && count($permissions)>0) {
				$this->user_permissions = $permissions;
			}else {
				throw new Exception('Empty permission set', 9999);
			}
			*/
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}		
	}
	
	public function isPermitted($module,$functionality,$action,$user=null,$permissions=null){
		try {
			if(is_array($user) && count($user)>0) {
				$this->setUserDetails($user);
			}
			if(is_array($permissions) && count($permissions)>0) {
				$this->setUserPermissions($permissions);
			}
			if(isset($this->user_permissions[$module][$functionality][$action])) {
				return $this->user_permissions[$module][$functionality][$action] == 'Y' ? true : false;
			} else {
				return false;
			}
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
	}
	
	
	
}
?>