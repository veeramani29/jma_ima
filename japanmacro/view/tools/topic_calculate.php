<?php

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

		echo "Topix=".$topix_fiar_value;
}

else{

	echo "No Results";

	}

?>

