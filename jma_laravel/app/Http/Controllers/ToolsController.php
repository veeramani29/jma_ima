<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use App\Model\Post;
use App\Model\Media;
use Exception;
use App\Http\Controllers\ErrorController;

class ToolsController extends Controller {
	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/common/navigation_class.php');

		public function __construct ()
		{
			 parent::__construct();
		View::share ( 'menu_items', $this->populateLeftMenuLinks());
		}
		public function index() {
		new ErrorController(404);
		}
	public function topixcalculator() {
		$renderResultSet['pageTitle'] = "Welcome to Japan macro advisors - Topix Calculator";
		$renderResultSet['meta']['description']='Japan macro advisors - Topix Calculator';
		$renderResultSet['meta']['keywords']='economic tools, calculator';
		$data['renderResultSet']=$renderResultSet;
		// get all category items
		$media = new Media();
		$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$data['result']['rightside']['media'] = $media->getLatestMedia(5);
		
		
		return view('tools.topixcalculator',$data);
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