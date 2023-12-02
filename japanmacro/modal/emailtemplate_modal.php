<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Emailtemplate extends AlaneeModal {
	
	public function getThisTemplate($template) {
		$response = array();
		$sql = "SELECT `email_templates_subject`, `email_templates_message` FROM `email_templates` WHERE `email_templates_code` = '$template'";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;	
	}
	
}

?>