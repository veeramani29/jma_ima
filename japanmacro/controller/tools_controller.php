<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class toolsController extends AlaneeController {
	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/common/navigation_class.php');
	public function topixcalculator() {
		$this->pageTitle = "Welcome to Japan macro advisors - Topix Calculator";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Topix Calculator';
		$this->renderResultSet['meta']['keywords']='economic tools, calculator';
		// get all category items
		$media = new Media();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$AlaneeCommon = new Alaneecommon();
		if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
				$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
			}
		}
		if(count($this->renderResultSet['result']['rightside']['media'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
				$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
			}
		}
		$this->populateLeftMenuLinks();	
		$this->renderView();		
	}
	
	function topic_calculate(){
	

//echo '<strong>You submitted to me:</strong><br/>';

$arr= $_REQUEST;

$US_nominal_GDP_rate=$arr['a'];	

$JP_nominal_GDP_rate=$arr['b'];

$USDJPY=$arr['d'];

$JGB_rate=$arr['c'];

if(($US_nominal_GDP_rate!="")  || ($JP_nominal_GDP_rate!="") || ($USDJPY!="")  || ($JGB_rate!="")){

		$sa_Profit='';

		$sa_Interest='';

		$SA_Cashflow='';

		$topix_fiar_value='';

		

		

		
 $sa_Profit= ((-0.09476*1)+(1.02787)*$US_nominal_GDP_rate/100) + (4.41148*$JP_nominal_GDP_rate/100) + ((1.32423*0)+ (0.301407*0)+(0.329486)*log($USDJPY/98));

 $sa_Interest= ((0.60043*1)+(14.803)* $JGB_rate/100)*1000000;
 $SA_Cashflow= (9104107*exp($sa_Profit)+ $sa_Interest)*(1-0.3564) + 4908410;
 $topix_fiar_value=exp((-15.6783*1)+1.4566*log($SA_Cashflow) + (-0.01173*96) + (0.51662*0));

		echo "Topix=".round($topix_fiar_value,2);
}

else{

	echo "No Results";

	}



	exit;
		
	}

}


?>