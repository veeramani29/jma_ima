<?php


/* file_put_contents("Tmpfile1.pdf", fopen("https://activitiesbank.voucher-service.com/vouser/rest/voucher/get/0UGFW7ZA9N",'r'));

//echo file_get_contents('https://activitiesbank.voucher-service.com/vouser/rest/voucher/get/0UGFW7ZA9N');

die;*/
#include('header.php');
ini_set('memory_limit', '-1');
set_time_limit(0);
ini_set('max_execution_time', 300000);
#$thisdb	     = new mysql();
$inputFileName ='C:\users\guru\desktop\V314\flatfile_ger_air.csv';



$file = fopen($inputFileName,"r");



$o=0;
while (($line_array = fgetcsv($file, 800000, ';')) !== false)
	 		{
	 				
	 			if($o<3){
	 				     echo implode('|', $line_array);echo "<br>";
	 			}
          		
	 			//echo "<pre>";print_r($line_array);die;//rezlive_hotel_amenities
	 			/*if($line_array[0]>2){
	 				$dataArray2[]=$line_array;
				}*/
$o++;
			}
 echo $a=count($dataArray2);
 echo "<pre>";print_r($dataArray2);die;
			for ($i=0; $i<$a ; $i++) { 
if($i!=0){
	if($dataArray2[$i][0]>179983){

$query="update `rezlive_hotel_amenities` set  `room_amenities`='".addslashes($dataArray2[$i][1])."' where hotel_id='".addslashes($dataArray2[$i][0])."'";

		#$query="insert into `rezlive_hotel_amenities` (`hotel_id`,`property_amenities`) values('".addslashes($dataArray2[$i][0])."','".addslashes($dataArray2[$i][1])."');";


				$thisdb->insertQuery($query);

		/*$inputFileName ='C:\xampp\htdocs\jma\ttpsend\10022018\hotels\hotels.csv';
	  $query="insert into `rezlive_hotel_list1` (`HotelCode`,`Name`, `City`,  `CityId`, `CountryId`,`CountryCode`,`Rating`, `HotelAddress`,  `HotelPostalCode`, `Latitude`, `Longitude`, `Desc`) values('".addslashes($dataArray2[$i][0])."','".addslashes($dataArray2[$i][1])."','".addslashes($dataArray2[$i][2])."','".addslashes($dataArray2[$i][3])."','".$dataArray2[$i][4]."','".addslashes($dataArray2[$i][5])."','".addslashes($dataArray2[$i][6])."','".addslashes($dataArray2[$i][7])."','".addslashes($dataArray2[$i][8])."','".addslashes($dataArray2[$i][9])."','".addslashes($dataArray2[$i][10])."','".addslashes($dataArray2[$i][11])."');";

//$query="update `rezlive_city_list` set  `country_name`='".addslashes($dataArray2[$i][1])."' where country_code='".addslashes($dataArray2[$i][2])."'";
$query="update `rezlive_hotel_list1` set  `Telephone`='".addslashes($dataArray2[$i][7])."',`Website`='".addslashes($dataArray2[$i][8])."',`Email`='".addslashes($dataArray2[$i][9])."',`Picture`='".addslashes($dataArray2[$i][14])."' where HotelCode='".addslashes($dataArray2[$i][0])."'";

  $query="insert into `rezlive_city_list` (`name`,`city_code`,`country_code`) values('".addslashes($dataArray2[$i][1])."','".addslashes($dataArray2[$i][2])."','".addslashes($dataArray2[$i][3])."');";

				$thisdb->insertQuery($query);*/
	}
}

				
			}




fclose($file);


die;

$url = "http://testph.via.com/apiv2/flight/review";
 $postData = '{
  "flightKeys": [{
     "keys": "08182848556591438188422@@O_$38_MNL_CEB_763_158_06:00__A1_0_0"
	 
 }],
  "isSSRReq" : "true",
   "isExReq" : "true"
}'; 





$curlConnection = curl_init();
#,"Via-Access-Token: c51b5435-cec6-4de2-b133-4t9e3s12ta02"
curl_setopt($curlConnection, CURLOPT_HTTPHEADER, array( "Content-Encoding: UTF-8","Content-Type: application/json","Via-Access-Token: c51b5435-cec6-4de2-b133-4t9e3s12ta02"));
curl_setopt($curlConnection, CURLOPT_URL, $url);
 #curl_setopt($curlConnection, CURLOPT_TIMEOUT, 180);
curl_setopt($curlConnection, CURLOPT_POST, TRUE);
 #curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, 1);
 #curl_setopt($curlConnection, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($curlConnection, CURLOPT_POSTFIELDS, $postData);
curl_setopt($curlConnection, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curlConnection, CURLOPT_SSL_VERIFYPEER, FALSE);

 $results = curl_exec($curlConnection);
echo "<pre>";
print_r(json_decode($results, true));

 echo $error = curl_getinfo($curlConnection, CURLINFO_HTTP_CODE);
    curl_close($curlConnection);

die;
phpinfo();
?>