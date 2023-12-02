<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;
class Mailtemplate extends Model{
	 protected $table = TBL_MAIL_TEMP;
	public function getTemplateParsed($template,$data){

		
			$result = array();
			$result_template = array();
			$rs = Mailtemplate::where('email_templates_code',$template)->first();
	
			if($rs->count()>0) {
				$result_template = $rs->toArray();
			}
			
			if(count($result_template)>0){

				$templatestr = $result_template['email_templates_message'];
				$result['subject'] = $result_template['email_templates_subject'];

				if (preg_match_all("/{{(.*?)}}/", $templatestr, $m)) {
					
			      foreach ($m[1] as $i => $varname) {
			         $templatestr = str_replace($m[0][$i], sprintf('%s', $data[$varname]), $templatestr);
			      }

			       
			    }
			   
			    $result['message'] = $templatestr;
			   
			}

			return $result;
		
		
	}
	
}

?>