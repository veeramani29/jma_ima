<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Mailtemplate extends AlaneeModal{
	
	public function getTemplateParsed($template,$data){
		try {
			$result = array();
			$result_template = array();
			$sql = "SELECT * FROM `email_templates` WHERE `email_templates_code` = '$template'";
			$rs = $this->executeQuery($sql);
			if($rs->num_rows>0) {
				$result_template = $rs->fetch_assoc();
			}
			if(count($result_template)>0){
				$template = $result_template['email_templates_message'];
				$result['subject'] = $result_template['email_templates_subject'];
				if (preg_match_all("/{{(.*?)}}/", $template, $m)) {
			      foreach ($m[1] as $i => $varname) {
			        $template = str_replace($m[0][$i], sprintf('%s', $data[$varname]), $template);
			      }
			    }
			    $result['message'] = $template;
			}
			return $result;
			
		}catch (Exception $ex){
			throw new Exception('Database error..', 9999);
		}
		
	}
	
}

?>