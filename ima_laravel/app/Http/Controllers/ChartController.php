<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Config;
use App\Model\Media;
use App\Lib\CommonClass;
use App\Lib\Acl;
use App\Lib\Navigation;
use App\Model\Userfolders;
use App\Model\Graphdetails;
use App\Libraries\mailer\PHPMailer;
use Exception;
use App\Http\Controllers\ErrorController;
use Response;
use Session;
class ChartController extends Controller {

public function index ()
		{
 new ErrorController(404);
		}


	public function getchartdata() {
		//header('Content-type: application/json');
		$CommonClass = new CommonClass();
		$chartCodes = $_POST['chartcodes'];
		$gids = array();
		$data_type = $_POST['type'];
		foreach ($chartCodes as $strgid){
			if ($strgid!='') {
			$arr_gid = explode('-', $strgid);
			$gids[] = $arr_gid[0];
			}
		}
		if(isset($_POST['typeGraph']) && $_POST['typeGraph'] =="map")
		{
			$chartSelectValues = $CommonClass->makeMapSelect($gids);
		}
		else
		{
			$chartSelectValues = $CommonClass->makeChartSelect($gids);
		}
		
		$availableChartFields = $chartSelectValues['options'];
		// Available Labels
		$availableChartLabels = $chartSelectValues['labels'];
		// Get Chart data
		
		if(isset($_POST['typeGraph']) && $_POST['typeGraph'] =="map")
		{
			
			$chart_data = $CommonClass->getmapData($chartCodes,$data_type,$availableChartLabels,$_POST['statename']);
		}
		else
		{
			$chart_data = $CommonClass->getchartData($chartCodes,$data_type,$availableChartLabels);
		}
		return Response::json($chart_data, '200');
	}



	public function get_chart_fields_labels() {
		//header('Content-type: application/json');
		$CommonClass = new CommonClass();
		$chart_data = array();
		if(isset($_POST['p_graph_code']) && $_POST['p_graph_code']!=''){
			$chartCodes = explode(" ",$_POST['p_graph_code']);
		
	    $chartSelectValues = $CommonClass->makeChartSelect($chartCodes);
		$availableChartFields = $chartSelectValues['options'];
		// Available Labels
		$availableChartLabels = $chartSelectValues['labels'];
		$chart_data=array('charts_fields_available' => $availableChartFields,
			               'status' =>1,
						  'chart_labels_available' => $availableChartLabels);

		}else{
				$chart_data = array('status' =>0);
		}
		
		// Get Chart data
		
		
		return Response::json($chart_data, '200');
	}

	public function getchartListdata() {
		//header('Content-type: application/json');
		
						if(isset($_POST['folder_id'])) {

						if( $this->isUserLoggedIn() ) {
						$folder = new Userfolders();
						$FolderContent = $folder->getFolderContent($_POST['folder_id'],$_SESSION['user']['id']);
						$listView_Array=array();	$listView_finalArray=array();
						$folderData = $folder->getThisFolderData($_POST['folder_id'],$_SESSION['user']['id']);
						$listView_finalArray['status'] = 1;
						$listView_finalArray['message'] = 'OK';
						$listView_finalArray['result'] = array('folderData'=>$folderData);

						if(is_array($FolderContent) && count($FolderContent)>0){
                 $eachfoldercontent=json_decode($FolderContent[0]['folder_contents']);
                       // echo "<pre>";print_r($eachfoldercontent);die;
                 if(is_array($eachfoldercontent) && count($eachfoldercontent)>0){
                      $no=0; $pageCount=0;
                      foreach ($eachfoldercontent as $eachfoldercontent) {
                       if($no%4 == 0){$pageCount++;}
                      $listView_Array[$no]['folder_name']=($FolderContent[0]['folder_name']!=null)?$FolderContent[0]['folder_name']:'N/A';
                      $listView_Array[$no]['pageCount']=$pageCount;
                      $listView_Array[$no]['title']=($eachfoldercontent->title!=null)?$eachfoldercontent->title:'N/A';
                      $listView_Array[$no]['note_content']=($eachfoldercontent->note_content!=null)?$eachfoldercontent->note_content:'N/A';
                      $listView_Array[$no]['type']=($eachfoldercontent->type!=null)?$eachfoldercontent->type:'N/A';
                  $listView_Array[$no]['chart_view_type']=(isset($eachfoldercontent->chart_view_type) && $eachfoldercontent->chart_view_type!=null)?$eachfoldercontent->chart_view_type:$eachfoldercontent->type;

                      $listView_Array[$no]['uuid']=($eachfoldercontent->uuid!=null)?$eachfoldercontent->uuid:'N/A';
                      $chart_codes_available=($eachfoldercontent->chart_codes_available!=null)?$eachfoldercontent->chart_codes_available:'N/A';
                      $charts_fields_available=array();
                        if($eachfoldercontent->type!='note'){
                          $eachfolder_chart_codes_available=isset($chart_codes_available[0])?$chart_codes_available[0]:$chart_codes_available[1];
                          $eachfolder_charts_fields_available=$eachfoldercontent->charts_fields_available->$eachfolder_chart_codes_available;
                              
                              if(is_array($eachfolder_charts_fields_available) && count($eachfolder_charts_fields_available)>0){
                                  $g=0;
                                  foreach ($eachfolder_charts_fields_available as $key => $value) { 

                                     $charts_fields_available[]=$key; if($g>1){ break;} $g++;
                                   } 
                              }
                             }
                        
                             $listView_Array[$no]['charts_fields_available']=$charts_fields_available;
                          
                               $no++;
                            }
                          }
                     
                      }

                      $listView_finalArray['listView']=$listView_Array;

                        // echo "<pre>";print_r($listView_finalArray);die;
                      	return Response::json($listView_finalArray, '200');

						}else{
						throw new Exception("Error.Authentication failed.",9999);
						}
						}else{
						throw new Exception("Error. Invalid request",9999);
						}		
               
                
            
	
	}

	public function downloadxls() {
		//ob_end_clean();
		if (isset ( $_SESSION ['user'] ) && $_SESSION ['user'] ['id'] > 0) {
			    if(isset($_SESSION['chartIndex'])){
					unset($_SESSION['chartIndex']);
				}
				$chartCodes = explode ( ',', $_POST['chart_codes'] );
				$gids = array();
				//$data_type = $_POST['type'];
				foreach ($chartCodes as $strgid){
					$arr_gid = explode('-', $strgid);
					$gids[] = $arr_gid[0];
				}
				if(isset($_POST['map_selectState']))
				{
					$selectState = explode(",",$_POST['map_selectState']);
				}
				
				if(isset($_POST['title_map_state']))
				{
					$titleMap = $_POST['title_map_state'];
				}
				
				$graphDetails = new Graphdetails();
				$gstr = join(',', $gids);
				$acl = new Acl();
				$chart_codes = explode ( ',', $_POST ['chart_codes'] );
				$chart_datatype = $_POST ['chart_datatype'];
				$filaname = sha1($_POST ['chart_codes'].$_POST ['chart_datatype'].microtime()).'.csv';
				if(isset($_POST['map_selectState'])  && !empty($_POST['map_selectState']))
				{
					        if($acl->isPermitted ( 'graph', 'datadownload', 'allowdatadownload' ) == true)
							{
								$this->downloadxlsDataForMap($chart_codes,$chart_datatype,$filaname,$selectState,$titleMap);
							}
							else 
							{
								$data['msg']="Download data feature is restricted to our <b>Premium</b> subscribers. Please upgrade your account from below.";
						return redirect('user/myaccount/subscription')->with('data', $data);
							}
				}
				else
				{
						//check whether data is premium or not
						if($graphDetails->checkIsPremiumForTheseComaseperatedGids($gstr)) 
						{
							if ($acl->isPermitted ( 'graph', 'datadownload', 'allowpremiumdatadownload' ) == true) {
								$this->downloadxlsData($chart_codes,$chart_datatype,$filaname);
							} else {
								$data['msg']="Download data feature is restricted to our <b>Premium</b> subscribers. Please upgrade your account from below.";
						return redirect('user/myaccount/subscription')->with('data', $data);
							}
						}
						else // if data is not premium
						{ 
							// check is permitted for data download
							if($acl->isPermitted ( 'graph', 'datadownload', 'allowdatadownload' ) == true)
							{
								$this->downloadxlsData($chart_codes,$chart_datatype,$filaname);
							}
							else 
							{
								$data['msg']="Download data feature is restricted to our <b>Premium</b> subscribers. Please upgrade your account from below.";
						return redirect('user/myaccount/subscription')->with('data', $data);
							}
						}
		       }
		} else {
			return redirect('user/login');
		}
	}
	
	public function downloadxlsDataForMap($chart_codes,$chart_datatype,$filaname,$selectState,$titleMap)
	{
		
		//ob_end_clean();
		$tempFilepath_conf = Config::read ( 'chart.download' ); // ['tempfolder'];
		$tempFilepath = $tempFilepath_conf ['tempfolder'];
		$CommonClass = new CommonClass ();
		$gids = array ();
		foreach ( $chart_codes as $c_code ) {
			$gid = explode ( '-', $c_code );
			$gid = $gid [0];
			$gids [] = $gid;
		}
		
		$chartSelectValues = $CommonClass->makeMapSelect($gids);
		
		$availableChartLabels = $chartSelectValues ['labels'];
		$base_data_array_idx = $chart_codes [0];
		$base_data_array_count = 0;
		$chart_data = $CommonClass->getmapData( $chart_codes, $chart_datatype, $availableChartLabels,$selectState);
		
		$chart_data = $chart_data['data'];
		
		/* print_r($chart_data); exit; */
		
	
		
		header ( 'Content-Type: text/csv; charset=utf-8' );
		header ( 'Content-Disposition: attachment; filename=ima_data.csv' );
		header ( 'Pragma: no-cache' );
		
		
		foreach ( $chart_data as $idx => $chart_data_row ) {
			
			$arr_count = count ( $chart_data_row );
			if ($arr_count > $base_data_array_count) {
				$base_data_array_count = $arr_count;
				$base_data_array_idx = $idx;
			}
		}
		
		
		
		$data_formatted = array ();
		$data_formatted [0] = array (
				'Date' 
		);
		
		
		
		
		foreach ( $chart_codes as $tmp_cht_code ) {
			//$data_formatted [0] [] = $availableChartLabels[$tmp_cht_code];
			$stateName = explode("-",$availableChartLabels[$tmp_cht_code]);
			$data_formatted [0] [] = $titleMap." - ".$stateName[0];
		}
		
		
		$new_file_name = $tempFilepath .$filaname;
		$f = fopen ( $new_file_name, 'w' );
	//	$f = fopen('php://output', 'w');
		fputcsv ( $f, $data_formatted [0] );
		foreach ( $chart_data [$base_data_array_idx] as $idx => $dateRow ) {
			$datetime = strtotime ( $dateRow [0] );
			switch ($chart_datatype) {
				case 'monthly' :
				case 'quaterly' :
					$datetime_str = date ( 'Y/m', $datetime );
					break;
				case 'anual' :
					$datetime_str = date ( 'Y', $datetime );
					break;
				case 'daily' :
					$datetime_str = date ( 'Y/m/d', $datetime );
					break;
			}
			$data_arr_row = array (
					$datetime_str 
			);
			
			foreach ( $chart_codes as $tmp_cht_code ) {
				$data_arr_row [] = $chart_data [$tmp_cht_code] [$idx] [1];
				
				//$data_arr_row [] = $chart_data [0] [$idx] [1];
			}
			$data_formatted [] = $data_arr_row;
			fputcsv ( $f, $data_arr_row );
		}
		fseek ( $f, 0 );
		fclose ( $f );
		$fsize = filesize ( $new_file_name );
		header( 'Content-Length: '.$fsize);
		readfile ( $new_file_name );
		//unlink($new_file_name);
	}
	
	public function downloadxlsData($chart_codes,$chart_datatype,$filaname)
	{
		
		$this->Track_Download('xls',$chart_codes);
		$tempFilepath_conf = Config::read ( 'chart.download' ); // ['tempfolder'];
		$tempFilepath = $tempFilepath_conf ['tempfolder'];
		$CommonClass = new CommonClass ();
		$gids = array ();
		foreach ( $chart_codes as $c_code ) {
			$gid = explode ( '-', $c_code );
			$gid = $gid [0];
			$gids [] = $gid;
		}
		$chartSelectValues = $CommonClass->makeChartSelect($gids);
		$availableChartLabels = $chartSelectValues ['labels'];
		$base_data_array_idx = $chart_codes [0];
		$base_data_array_count = 0;
		$chart_data = $CommonClass->getchartData ( $chart_codes, $chart_datatype, $availableChartLabels );
		$chart_data = $chart_data['data'];
		header ( 'Content-Type: text/csv; charset=utf-8' );
		header ( 'Content-Disposition: attachment; filename=ima_data.csv' );
		header ( 'Pragma: no-cache' );
		foreach ( $chart_data as $idx => $chart_data_row ) {
			$arr_count = count ( $chart_data_row );
			if ($arr_count > $base_data_array_count) {
				$base_data_array_count = $arr_count;
				$base_data_array_idx = $idx;
			}
		}
		$data_formatted = array ();
		$data_formatted [0] = array (
				'Date' 
		);
		foreach ( $chart_codes as $tmp_cht_code ) {
			$data_formatted [0] [] = $availableChartLabels[$tmp_cht_code];
		}
		$new_file_name = $tempFilepath .$filaname;
		$f = fopen ( $new_file_name, 'w' );
	//	$f = fopen('php://output', 'w');
		fputcsv ( $f, $data_formatted [0] );
		foreach ( $chart_data [$base_data_array_idx] as $idx => $dateRow ) {
			$datetime = strtotime ( $dateRow [0] );
			switch ($chart_datatype) {
				case 'monthly' :
				case 'quaterly' :
					$datetime_str = date ( 'Y/m', $datetime );
					break;
				case 'anual' :
					$datetime_str = date ( 'Y', $datetime );
					break;
				case 'daily' :
					$datetime_str = date ( 'Y/m/d', $datetime );
					break;
			}
			$data_arr_row = array (
					$datetime_str 
			);
			foreach ( $chart_codes as $tmp_cht_code ) {
				$data_arr_row [] = $chart_data [$tmp_cht_code] [$idx] [1];
			}
			$data_formatted [] = $data_arr_row;
			fputcsv ( $f, $data_arr_row );
		}
		fseek ( $f, 0 );
		fclose ( $f );
		$fsize = filesize ( $new_file_name );
		header( 'Content-Length: '.$fsize);
		readfile ( $new_file_name );
	//	unlink($new_file_name);
	}					
	public function exportChart(){
		$tempFilepath_conf = Config::read ( 'chart.download' ); // ['tempfolder'];
		$tempFilepath = $tempFilepath_conf ['tempfolder'];
		$BATIK = Config::read ( 'chart.export' );
		 $BATIK_PATH = $BATIK ['BATIK_PATH'].'batik-rasterizer.jar';
		 $type = (isset($_POST ['type'])?'image/'.$_POST ['type']:'');
		$svg = ( string ) $_POST ['svg'];
		  $svg = preg_replace(array('/strokeWidth="\d+"/i'), "", $svg);
		$filename = ( string ) $_POST ['filename'];
		
		// prepare variables
		if (! $filename or ! preg_match ( '/^[A-Za-z0-9\-_ ]+$/', $filename )) {
			$filename = 'chart';
		}
		if (get_magic_quotes_gpc ()) {
			$svg = stripslashes ( $svg );
		}
		// check for malicious attack in SVG
		if (strpos ( $svg, "<!ENTITY" ) !== false || strpos ( $svg, "<!DOCTYPE" ) !== false) {
			exit ( "Execution is stopped, the posted SVG could contain code for a malicious attack" );
		}
		
	
		$tempName = md5 ( rand () );
		// allow no other than predefined types
		if ($type == 'image/png') {
			$typeString = '-m image/png';
			$ext = 'png';
		} elseif ($type == 'image/jpeg') {
			$typeString = '-m image/jpeg';
			$ext = 'jpg';
		} elseif ($type == 'application/pdf') {
			$typeString = '-m application/pdf';
			$ext = 'pdf';
		} elseif ($type == 'image/svg+xml') {
			$ext = 'svg';
		} else { // prevent fallthrough from global variables
			$ext = 'txt';
		}
		 $outfile = $tempFilepath."$tempName.$ext"; 
		if (isset ( $typeString )) {


			// size
			$width = '';
			if ($_POST ['width']) {
				$width = ( int ) $_POST ['width'];
				if ($width)
					$width = "-w $width";
			}

			// generate the temporary file
			if (! file_put_contents ( $tempFilepath."$tempName.svg", $svg )) {
				die ( "Couldn't create temporary file. Check that the directory permissions for
the /temp directory are set to 777." );
			}


			// do the conversion
			// Debug : $output = shell_exec ( "java -jar " . $BATIK_PATH . " $typeString -d $outfile $width ".$tempFilepath."$tempName.svg 2>&1" );
			$output = shell_exec ( "java -jar " . $BATIK_PATH . " $typeString -d $outfile $width ".$tempFilepath."$tempName.svg" );	
			// catch error
			if (! is_file ( $outfile ) || filesize ( $outfile ) < 10) {
				echo "<pre>$output</pre>";
				echo "Error while converting SVG. ";
				if (strpos ( $output, 'SVGConverter.error.while.rasterizing.file' ) !== false) {
					echo "
<h4>Debug steps</h4>
<ol>
<li>Copy the SVG:<br/><textarea rows=5>" . htmlentities ( str_replace ( '>', ">\n", $svg ) ) . "</textarea></li>
<li>Go to <a href='http://validator.w3.org/#validate_by_input' target='_blank'>validator.w3.org/#validate_by_input</a></li>
<li>Paste the SVG</li>
<li>Click More Options and select SVG 1.1 for Use Doctype</li>
<li>Click the Check button</li>
		</ol>";
				}
			} 			// stream it
			else {

				header ( "Content-Disposition: attachment; filename=\"$filename.$ext\"" );
				header ( "Content-Type: $type" );
				echo file_get_contents ( $outfile );
			}
			// delete it
			unlink ( $tempFilepath."$tempName.svg" );
			unlink ( $outfile );
			// SVG can be streamed directly back
		} else if ($ext == 'svg') {
			header ( "Content-Disposition: attachment; filename=\"$filename.$ext\"" );
			header ( "Content-Type: $type" );
			echo $svg;
		} else {
			echo "Invalid type";
		}
	}




	public function exportChartpptx(){
		$tempFilepath_conf = Config::read ( 'chart.download' ); // ['tempfolder'];
		$tempFilepath = $tempFilepath_conf ['tempfolder'];
		$BATIK = Config::read ( 'chart.export' );
		 $BATIK_PATH = $BATIK ['BATIK_PATH'].'batik-rasterizer.jar';
		 $type = (isset($_POST ['type'])?'image/'.$_POST ['type']:'');
		$svg = ( string ) $_POST ['svg'];
		  $svg = preg_replace(array('/strokeWidth="\d+"/i'), "", $svg);
		$filename =(isset($_POST ['filename']))? ( string )$_POST ['filename']:'' ;
		
		// prepare variables
		if (! $filename or ! preg_match ( '/^[A-Za-z0-9\-_ ]+$/', $filename )) {
			$filename = 'chart';
		}
		if (get_magic_quotes_gpc ()) {
			$svg = stripslashes ( $svg );
		}
		// check for malicious attack in SVG
		if (strpos ( $svg, "<!ENTITY" ) !== false || strpos ( $svg, "<!DOCTYPE" ) !== false) {
			exit ( "Execution is stopped, the posted SVG could contain code for a malicious attack" );
		}
		
	
		$tempName = md5 ( rand () );
		// allow no other than predefined types
		if ($type == 'image/png') {
			$typeString = '-m image/png';
			$ext = 'png';
		} elseif ($type == 'image/jpeg') {
			$typeString = '-m image/jpeg';
			$ext = 'jpg';
		} elseif ($type == 'application/pdf') {
			$typeString = '-m application/pdf';
			$ext = 'pdf';
		} elseif ($type == 'image/svg+xml') {
			$ext = 'svg';
		} else { // prevent fallthrough from global variables
			$ext = 'txt';
		}
		 $outfile = $tempFilepath."$tempName.$ext"; 
		if (isset ( $typeString )) {


			// size
			$width = '';
			if (isset($_POST ['width'])) {
				$width = ( int ) $_POST ['width'];
				if ($width)
					$width = "-w $width";
			}

			// generate the temporary file
			if (! file_put_contents ( $tempFilepath."$tempName.svg", $svg )) {
				die ( "Couldn't create temporary file. Check that the directory permissions for the /temp directory are set to 777." );
			}

			

            //error_reporting(E_All);
			// do the conversion
			// Debug : $output = shell_exec ( "java -jar " . $BATIK_PATH . " $typeString -d $outfile $width ".$tempFilepath."$tempName.svg 2>&1" );
			$output = shell_exec ( "java -jar " . $BATIK_PATH . " $typeString -d $outfile $width ".$tempFilepath."$tempName.svg" );	
			
			//print_r($output);
			// catch error
			if (! is_file ( $outfile ) || filesize ( $outfile ) < 10) {
				
				echo "Error while converting SVG. ";
				//if (strpos ( $output, 'SVGConverter.error.while.rasterizing.file' ) !== false) {}
					
				
			}else {
				unlink ( $tempFilepath."$tempName.svg" );
				echo $echofile="files/$tempName.$ext"; 
				
			}
			// delete it
			
			//unlink ( $outfile );

			
			
			// SVG can be streamed directly back
		} else if ($ext == 'svg') {
			header ( "Content-Disposition: attachment; filename=\"$filename.$ext\"" );
			header ( "Content-Type: $type" );
			echo $svg;
		} else {
			echo "Invalid type";
		}
	}

	public function sendshare() {
		//header('Content-type: application/json');
		mb_internal_encoding("UTF-8");
		$params['to_emails'] = explode(',',$_POST['graph_share_input_to_email']);
		$params['key_verification'] = md5(time().rand().$_POST['graph_share_input_link']);
		$params['from_email'] = $_POST['graph_share_input_from_email'];
		$params['to_email'] = $_POST['graph_share_input_to_email'];
		$params['link'] = $_POST['graph_share_input_link'];
		$params['message'] = mb_convert_encoding($_POST['graph_share_ta_message'],'UTF-8');
		$params['client_ip'] = $_SERVER['REMOTE_ADDR'];
		$params['verified'] = 0;
		$appPath = Config::read('appication_path') != '' ? '/'.trim(Config::read('appication_path'),'/') : '';
		$params['confirmlink'] = 'http://'.$_SERVER['HTTP_HOST'].$appPath.'/chart/confirmshare/'.$params['key_verification'];
		$graphShareLog = new Graphsharelog();
		if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {
			$params['verified'] = 1;
			$this->sendShareEmail($params);
			$res_msg = '<span style="color:#80a91d">Thank you for using our chart sharing function.<br>Your message has been sent.</span>';
			$res_status = 1;
		} else {
			$params['verified'] = 0;
			$res_msg = '<span style="color:#80a91d">You are almost done!</span><br><span style="color:#606060">For security reasons, we need to verify your email address. Please check your email inbox for a confirmation message we just sent. Click on the link in the email and the chart will be sent to your friends.</spam>';
			$res_status = 1;
			$mail_message = 'Dear India Macro Advisors user,<br><br>
			We are about to send the chart you made to <br>
			'.$_POST['graph_share_input_to_email'].'<br>with a message<br>
			'.mb_convert_encoding($_POST['graph_share_ta_message'],'HTML-ENTITIES','UTF-8').'<br>
			<br>Click on the confirm button below to complete the process.<br><br>
			<a href="'.$params['confirmlink'].'" target="_blank">CONFIRM</a><br><br>
			Note: If you can\'t click on the above, copy paste this URL in your browser '.$params['confirmlink'].'
			If you did not try to send a chart to your friends, please contact us on info@indiamacroadvisors.com for inquiries and spam reports.<br>
			- The India Macro Advisors team';
		//	$headers  = 'MIME-Version: 1.0' . "\r\n";
		//	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//	$headers .= 'From: Indiamacroadvisors<info@indiamacroadvisors.com>' . "\r\n";
		//	mail($_POST['graph_share_input_from_email'], $subject, $mail_message, $headers);
                                
		try {
			  $mail = new PHPMailer();
			  $mail->IsSMTP();
			  $mail->IsHTML(true);  
			  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
			  $mail->AddAddress($_POST['graph_share_input_from_email']);
			  $mail->SetFrom('info@indiamacroadvisors.com', 'IMA Info');
			  $mail->AddReplyTo('info@indiamacroadvisors.com', 'IMA Info');
			  $mail->Subject = 'Please verify your email.';
			  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		//	  $mail->MsgHTML($mail_message);
			  $mail->Body = $mail_message;
			  
			  $mail->WordWrap = 50;                                 
			  $mail->Send();
			} catch (phpmailerException $e) {
				$res_status = 9999;
				$res_msg = '<span style="color:#ff0000">'.$e->errorMessage().'</span>';
			} catch (Exception $e) {
				$res_status = 9999;
				$res_msg = '<span style="color:#ff0000">'.$e->errorMessage().'</span>';
			}
		}
			$graphShareLog->logGraphShare($params);
			$response = array(
				'Status' => $res_status,
				'Message' => $res_msg
			);
				

		
/*
 * @todo : share graph log.
 */
		/*
		 $db->open();
		 $sql = 'INSERT INTO share_graph_log(datetime,from_email,to_email,link,message,key_verification,client_ip) VALUES
		 (now(),"'.mysql_real_escape_string($_POST['graph_share_input_from_email']).'"
		 ,"'.mysql_real_escape_string($_POST['graph_share_input_to_email']).'",
		 "'.mysql_real_escape_string($_POST['graph_share_input_link']).'",
		 "'.mysql_real_escape_string(mb_convert_encoding($_POST['graph_share_ta_message'],'UTF-8')).'",
		 "'.$ky.'","'.$_SERVER['SERVER_ADDR'].'")';
		 $db->executeQuery($sql);
		 */


		return Response::json($response, '200');

	}
	

	public function confirmshare($params) {
		$this->pageTitle = "Welcome to India macro advisors - Confirm share.";
		// get all category items
		$postCategory = new postCategory();
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
		mb_internal_encoding("UTF-8");
		$key_verify = $params[0];
		$graphShareLog = new Graphsharelog();
		$rs = $graphShareLog->getGraphShareLogForThisKey($key_verify);
		if(count($rs)>0){
			$share_row = $rs[0];
			$bk_link = $share_row['link'];
			if($share_row['verified'] == 0) {
	
				$to_emails = explode(',',$share_row['to_email']);
				foreach ($to_emails as $to_email) {
					$share_row['to_email'] = trim($to_email);
					$this->sendShareEmail($share_row);
					//mail(trim($to_email), $subject, $message, $headers);
				}
				$graphShareLog->setGraphShareVerificationStatusAsVerified($key_verify);
				$this->renderResultSet['message'] = "Thank you for using our chart sharing function.<br>Your message has been sent.";
			} else {
				$this->renderResultSet['message'] = "Error.. You have already verified your email";
			}
		} else {
			$this->renderResultSet['message'] = "Sorry.. Requested page not found";
		}
		$this->renderView();
	}
	
	private function sendShareEmail($share_row) {
	//	$headers  = 'MIME-Version: 1.0' . "\r\n";
	//	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	//	$headers .= 'From: indiamacroadvisors<info@indiamacroadvisors.com>' . "\r\n";
	//	$headers .= 'Disposition-Notification-To: '.$share_row['from_email'].'<'.$share_row['from_email'].'>' . "\r\n"; //is mail read?
	//	$headers .= 'Return-Path: <'.$share_row['from_email'] . '>'."\r\n"; // Return path for errors
	//	$headers .= 'Reply-To: '.$share_row['from_email'];
	//	$subject = 'Your friend '.$share_row['from_email'].' just sent you a chart';

		$message = "Hi,<br>
					Your friend, ".$share_row['from_email'].", sent you this message:<br><br>
					\"".mb_convert_encoding($share_row['message'],'HTML-ENTITIES','UTF-8')."\"<br><br>
					Click the following to access the sent link. <br>
					<a href=\"".$share_row['link']."\" target=\"_blank\">".$share_row['link']."</a><br><br>
					Note: If you can't click on the above, copy paste this URL in your browser ".$share_row['link'];
	//	mail($share_row['to_email'], $subject, $message, $headers);
	$to_emails = explode(',',$share_row['to_email']);
		try {
			  $mail = new PHPMailer();
			  $mail->IsSMTP();
			  $mail->IsHTML(true);  
			  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
		//	  $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		//	  $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
		//	  $mail->Username   = "info@indiamacroadvisors.co";  // GMAIL username
		//	  $mail->Password   = "qB^gXTK5";            // GMAIL password
			  $mail->SetFrom('info@indiamacroadvisors.com', 'IMA Info');
			  $mail->AddReplyTo('info@indiamacroadvisors.com', 'IMA Info');
			  $mail->Subject = 'Your friend '.$share_row['from_email'].' just sent you a chart';
			  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			  $mail->Body = $message;
			  $mail->WordWrap = 50;
			  foreach ($to_emails as $to_mail) {
			  	$mail->AddAddress(trim($to_mail));
			  	$mail->Send();
			  	$mail->clearAddresses();
    		  	$mail->clearAttachments();
			  }

			} catch (phpmailerException $e) {
			  	$response = array(
				'Status' => 9999,
				'Message' => '<span style="color:#ff0000">'.$e->errorMessage().'</span>'
				);
			} catch (Exception $e) {
			  	$response = array(
				'Status' => 9999,
				'Message' => '<span style="color:#ff0000">'.$e->errorMessage().'</span>'
				);
			}

	}
	
	public function viewchart($params,$uparams){
		print_r($uparams); exit;
	}
	
	public function testgetchartdata($params) {
		header('Content-type: application/json; charset=utf-8');
		$alaneeCommon = new Alaneecommon();
		//$chartCodes = $_POST['chartcodes'];
		$chartCodes = array('187-0','187-2');
		$gids = array();
		//$data_type = $_POST['type'];
		$data_type = 'anual';
		foreach ($chartCodes as $strgid){
			$arr_gid = explode('-', $strgid);
			$gids[] = $arr_gid[0];
		}
		$chartSelectValues = $alaneeCommon->makeChartSelect($gids);
		echo '<pre>';
		print_r($chartSelectValues);
	//	echo utf8_decode($chartSelectValues['labels']['186-0']);
		$availableChartFields = $chartSelectValues['options'];
		// Available Labels
		$availableChartLabels = $chartSelectValues['labels'];
		// Get Chart data
		$chart_data = $alaneeCommon->getchartData($chartCodes,$data_type,$availableChartLabels);
		echo json_encode($chart_data);
	}

}


?>