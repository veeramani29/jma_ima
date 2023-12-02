<?php
namespace App\Lib;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Exception;

/**
 * 
 * Class file for handling all CURL requests and responses.
 * @author Shijo Thomas : shijo@alanee.com
 *
 */

class AlaneeCurlClass {
	
    public function postData($url=null,$postParam = null,$c_options = array()) {
        if ($url ==null || $url =='') {
            throw new Exception('', 5001);
        }
        $options_array = array(
        	CURLOPT_RETURNTRANSFER => true,
        	CURLOPT_POST => 1,
        	CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_RETURNTRANSFER => 1     	
        );
       if(!empty($c_options)) {
            foreach ($c_options as $options => $value) {
                $options_array[$options] = $value;
            }
        }
       if($postParam !=null) {
          $options_array[CURLOPT_POSTFIELDS] =$postParam;
       }
        $curl = curl_init($url);
		curl_setopt_array($curl,$options_array); 
        $response = curl_exec($curl);
        if($err = curl_error($curl) != '') {
            throw new Exception($err, 5000);
        }
        curl_close($curl);
        return $response;
    }
    
    public function postData_opt($url=null,$postParam = null,$c_options = array()) {
 // exit($postParam);  	
    		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
	    //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
	   //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 


		//NVPRequest for submitting to server
		//$nvpreq="METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode($version) . "&PWD=" . urlencode($API_Password) . "&USER=" . urlencode($API_UserName) . "&SIGNATURE=" . urlencode($API_Signature) . $nvpStr . "&BUTTONSOURCE=" . urlencode($sBNCode);

		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postParam);

		//getting response from server
		$response = curl_exec($ch);
		curl_close($ch);
		echo $response;
		echo '<pre>';
		var_dump($response);
    	
    	
    }
	
}

?>