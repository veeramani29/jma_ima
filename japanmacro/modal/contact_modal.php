<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Contact extends AlaneeModal {
	
	public function saveContact($sql) {
		if($this->executeQuery($sql)) {
			return true;
		} else {
			return false;
		}
	}
}

?>