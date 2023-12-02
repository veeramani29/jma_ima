<?php
namespace App\Lib;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');

use App\Model\Graphdetails;
use App\Model\Graphvalues;
use App\Model\Memcachedclass;
class CommonClass {

	public function makeChart($value,$isNavigator = true) {
		
	/*	$php_timestamp = strtotime('0-0-1990');
		$js_timestamp = ($php_timestamp*1000);
		
		echo $js_timestamp;
		
		exit;
		*/
		$isFromUrl = false;
		$chart_details = array();
		$graph_default_configs_master = array(
			'chartType' => 'line',
			'ViewOption' => 'chart',
			'isMultiaxis' => false,
			'isChartTypeSwitchable' => 'Y',
			'chartLayout' => 'normal',
			'isNavigator' => true,
			'chartExport' => array(
					'image_size_available' => array(
							'small' => 400,
							'medium' => 800,
							'large' => 1200
					),
					'types_available' => array(
						'jpeg' => 'image/jpeg',
						'png' => 'image/png',
						'pdf' => 'application/pdf'
					)
			)
		);
		
		if($count = preg_match_all("/{(map[_a-z]*) ((\d|,|\||-)+)({([a-zA-Z:,\"\'&quot;]*)})*}/", $value, $matches))
		{
			
			if($count > 0) {
				for($cnt_graphs = 0; $cnt_graphs<$count; $cnt_graphs++){
					$graph_default_configs = $graph_default_configs_master;
					// Graph Ids
					/*graph details from URL */
					if (isset($_GET['graph_index']) && $cnt_graphs == $_GET['graph_index'] && $isFromUrl == false)
					{
						$get_gids = $_GET['gids'];
						$get_graph_type = $_GET['graph_type'];
						$get_graph_data_from = $_GET['graph_data_from'];
						$get_graph_data_to = $_GET['graph_data_to'];
						$get_graph_index = $_GET['graph_index'];
						$isFromUrl = true;
					}
					else
					{
						$get_gids = null;
						$get_graph_type = null;
						$get_graph_data_from = null;
						$get_graph_data_to =null;
						$get_graph_index = null;
					}
					$main = explode('|', $matches[2][$cnt_graphs]);
					$gids = array();
					$GIDS = $get_gids !=null ? explode('|', $get_gids) : explode(',', $main[0]);
					$GID = $GIDS[0];
					$gid = explode('-', $GID);
					$gid = $gid[0];
					$gids = array();
					if(isset($main[1]) and !empty($main[1]))
					{
						$NGIDS = explode(',', $main[1]);
						foreach($NGIDS as $id)
						{
							$nid = explode('-', $id);
							$nid = $nid[0];
							if(in_array($nid, $gids)) continue;
							$gids[] = $nid;
						}
					}
					$gids2 = array();
					foreach($GIDS as $id)
					{
						$nid = explode('-', $id);
						$nid = $nid[0];
						if(in_array($nid, $gids)) continue;
						$gids2[] = $nid;
					}
					// All available graph ids
					$gids = array_merge($gids2, $gids);	
					// GraphId to plot
					$gid_to_plot = $main[0];	
					// Date range
					$dateRange_arr = explode(',',$main[2]);
					// Data - Date From
					$dateinfo_from = explode('-',$dateRange_arr[0]);
					// Data Date To
					$dateinfo_to = explode('-',$dateRange_arr[1]);
					
					
					//Graph configurations
					$data_period_type = 'monthly';
					switch ($matches[1][$cnt_graphs]){
						case 'map':
							$data_period_type = 'monthly';
							$dateRange_from = '1-'.$dateinfo_from[1].'-'.$dateinfo_from[0];
							$dateRange_to = '1-'.$dateinfo_to[1].'-'.$dateinfo_to[0];
							break;
						case 'map_narrow':
							$data_period_type = 'monthly';
							$dateRange_from = '1-'.$dateinfo_from[1].'-'.$dateinfo_from[0];
							$dateRange_to = '1-'.$dateinfo_to[1].'-'.$dateinfo_to[0];
							$graph_default_configs['chartLayout'] = 'narrow';
							break;
						case 'map_anual':
							$data_period_type = 'anual';
							$dateRange_from = '1-1-'.$dateinfo_from[0];
							$dateRange_to = '1-1-'.$dateinfo_to[0];
							break;
						case 'map_month':
							$data_period_type = 'monthly';
							$dateRange_from = '1-'.$dateinfo_from[1].'-'.$dateinfo_from[0];
							$dateRange_to = '1-'.$dateinfo_to[1].'-'.$dateinfo_to[0];
							break;
						case 'map_daily':
							$data_period_type = 'daily';
							$dateRange_from = $dateinfo_from[2].'-'.$dateinfo_from[1].'-'.$dateinfo_from[0];
							$dateRange_to = $dateinfo_to[2].'-'.$dateinfo_to[1].'-'.$dateinfo_to[0];
							break;	
						case 'map_quaterly':
							$data_period_type = 'quaterly';
							$dateRange_from = '1-'.$dateinfo_from[1].'-'.$dateinfo_from[0];
							$dateRange_to = '1-'.$dateinfo_to[1].'-'.$dateinfo_to[0];
							break;							
					}
					$graph_configurations = $graph_default_configs;
					if(isset($matches[4][$cnt_graphs])) {
						$graph_conf_str = html_entity_decode($matches[4][$cnt_graphs]);
						$graph_conf_arr = json_decode($graph_conf_str,true);
						if(is_array($graph_conf_arr)){
							foreach ($graph_conf_arr as $c_ky => $c_val){
								$graph_configurations[$c_ky] = $c_val;
							}
						}
					}
					
					
					
					
					/////start
					
					
					# Map specification details :
					
					//map graph details
					$availableMapDetails = $this->mapGraphDetails($gids);
					//$flatCategories = array();
					$availableCharts = $this->makeChartCategories($gids);
					$NewDataVal1 = array();
					foreach($availableCharts as $key => $csm)
					{  foreach($csm as $key1 => $csm1)
					   {
					      $NewDataVal1[] = $csm1;
					   }	  
					}
					
					$MapData = $this->makeMapData($gids);
					$NewMapDataVal = array_values($MapData);
					$valueMapData = array_keys($MapData);
					
					$mapmaxValue = $this->mapmaxValue($gids);
					
					foreach($NewMapDataVal as $key => $csm)
					{	
					    /* $NewMapDataVal[$key]['value'] = $key+1;
						$NewMapDataVal[$key]['Datavalue'] = $mapmaxValue[$key]['max_value']; */
						
						$NewMapDataVal[$key]['value'] = $mapmaxValue[$key]['max_value'];
						
					}
					
					
					$getMaxValOfLastYeay = $this->maxValueOfCurrentYear($gids[0]);
					
					$jsonDataAll =  $this->makeJsonDataAll($gids);
					
					foreach($jsonDataAll as $key => $csm)
					{
					    $allData[$key] = $csm;
					}
					
					
					$stateValue  = array_values($MapData);
					
					$stateDataVal = array();
					foreach($stateValue as $keyS => $csmS)
					{  foreach($csmS as $keyV => $csmV)
					   {
					      $stateDataVal[] = $csmV;
					   }	  
					}
					
					
					/* $availableChartsNew = $this->makeChartCategories($gids);
					$allDataAllvdd = array_chunk($allData, count($availableChartsNew));
					$dataJsonValue = array();
					for($j=0;$j < count($allDataAllvdd);$j++)
					{
						$stateDataWithout = call_user_func_array('array_merge', $allDataAllvdd[$j]);
						$combine = array_combine($NewDataVal1, $stateDataWithout);
						$dataJsonValue[$j]['data'] = $combine;
						$dataJsonValue[$j]['features']['hc-key'] = $stateDataVal[$j];
					} */
					
					
					$availableChartsNew = $this->makeChartCategories($gids);
					$allDataAllvdd = array_chunk($allData, count($availableChartsNew));
					$dataJsonValue = array();
					for($j=0;$j < count($allDataAllvdd);$j++)
					{
						$stateDataWithout = call_user_func_array('array_merge', $allDataAllvdd[$j]);
						$combine = array_combine($NewDataVal1, $stateDataWithout);
						$dataJsonValue[$j]['data'] = $combine;
						$dataJsonValue[$j]['features']['hc-key'] = $stateDataVal[$j];
					}
					 
					
					/* echo "<pre>";
					print_r($dataJsonValue);
					exit;  */ 
					
					
					
					
					//$drawchart = "<script type='text/javascript'>JMA.JMAChart.initiateMap(".$map_details_json.");</script>";
					//$drawchart = "<script type='text/javascript'>JMA.JMAChart.initiateMap(".$cnt_graphs.",".$map_details_json.");</script>";
					/* $div_close=($count > 1 && $cnt_graphs!=0)?"</div>":'';
					$div_open=($count > 1 )?"<div class='col-xs-12 catpage_valuecon'>":'';
					$script_map =$div_close."<div id='Map_Dv_placeholderwewe_".$cnt_graphs."'></div><script type='text/javascript'>";
					$script_map.="JMA.JMAChart.initiateMap(".$cnt_graphs.",".$map_details_json.");";
					$script_map.="</script>".$div_open; */
					//$value = preg_replace('/'.preg_quote($matches[0][$cnt_graphs]).'/', '', $value);	
					
					
					
					/////end
					
					
					
					
				/* 	// Get available chart names 
					$availableCharts = $this->makeChartOptions($gids);
					//$isPremiumData = $this->isChartPremium($gids);
					// Get all chart fields
					$chartSelectValues = $this->makeChartSelect($gids);
					$availableChartFields = $chartSelectValues['options'];
					// Available Labels
					$availableChartLabels = $chartSelectValues['labels'];
					// Get Chart data
					$chart_prefetch_data = $this->getchartData($GIDS,$data_period_type,$availableChartLabels);
					// Is chart premium
					$isPremiumData = $chart_prefetch_data['isPremiumData']; */
				/***
				 * 
				 * Sort charts_available and charts_fields_available according to chart code order
				 * 
				 */
					/* $chart_details = array(
							'chart_actual_code' => $matches[0][$cnt_graphs],
							'chart_config' => $graph_configurations,
							'isPremiumData' => $isPremiumData,
							'charts_available' => $availableCharts,
							'charts_codes_available' => $gids,
							'chart_data_type' => $data_period_type,
							'charts_fields_available' => $availableChartFields,
							'current_chart_codes' => $GIDS,
							'chart_labels_available' => $availableChartLabels,
							'navigator_date_from' => $get_graph_data_from !=null ? $get_graph_data_from : $dateRange_from,
							'navigator_date_to' => $get_graph_data_to !=null ? $get_graph_data_to : $dateRange_to,
							'share_page_url' => 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
							'sources' => $chart_prefetch_data['sources'],
							'chart_data' => $chart_prefetch_data['data']
							
					);
					$drawchart = "<script type='text/javascript'>JMA.JMAChart.initiateMap(".$cnt_graphs.",".$map_details_json.");</script>";
					
					
					
					
					
					

					//echo "<pre>";print_r($chart_details);die;
					$chart_details_json = json_encode($chart_details);
					$div_close=($count > 1 && $cnt_graphs!=0)?"</div>":'';
					$div_open=($count > 1 )?"<div class='col-xs-12 catpage_valuecon'>":'';*/
					
					
					
					$availableCharts = $this->makeMapOptions($gids);
					$chartSelectValues = $this->makeMapSelect($gids);
					
					$availableChartFields = $chartSelectValues['options'];
					// Available Labels
					$availableChartLabels = $chartSelectValues['labels'];
					// Get Chart data
					
					 /*echo "<pre>";
					print_r($dataJsonValue);  exit; */
					
					
					
					
					
					$graph_configurations['dataType'] = $data_period_type;
					if($graph_configurations['isMultiaxis'] == true){
						$graph_configurations['chartType'] = 'multiaxisline';
					}
					if($get_graph_type!=null){
						$graph_configurations['chartType'] = $get_graph_type;
					}
					$graph_configurations['mapType']="maps";
					
					$map_details = array(
							'categories' => $NewDataVal1,
							'MapData' => $NewMapDataVal,
							'lastYearData' => $getMaxValOfLastYeay,
							'stateJsonData' => $dataJsonValue,
							'mapTitle' => $availableMapDetails[0]['title'],
							'mapSource' => $availableMapDetails[0]['source'],
							'map_config' => $graph_configurations,
							'charts_codes_available' => $gids,
							'chart_data_type' => $data_period_type,
							'current_chart_codes' => $GIDS,
							'charts_available' => $availableCharts,
							'charts_fields_available' => $availableChartFields,
							'chart_labels_available' => $availableChartLabels,
							'navigator_date_from' => $get_graph_data_from !=null ? $get_graph_data_from : $dateRange_from,
							'navigator_date_to' => $get_graph_data_to !=null ? $get_graph_data_to : $dateRange_to,
							'share_page_url' => 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
							'sources' => $availableMapDetails[0]['source']
					);
					
					
					 
					
				    $map_details_json = json_encode($map_details);
					
					
					
					
					$script_chart ="<div id='Chart_Dv_placeholder_".$cnt_graphs."'></div><script type='text/javascript'>";
					$script_chart.="$(window).load(function() { JMA.JMAChart.initiateMap(".$cnt_graphs.",".$map_details_json."); });";
					$script_chart.="</script>";
					$value = preg_replace('/'.preg_quote($matches[0][$cnt_graphs]).'/', $script_chart, $value); 
					
					//$value = preg_replace('/'.preg_quote($matches[0][$cnt_graphs]).'/','', $value);

                     					
				}
				   $drawchart = "<script type='text/javascript'>$(window).load(function() { JMA.JMAChart.drawAllCharts(); });</script>";
				
				return $value.$drawchart;
			}

			
		}
		
		// if($count = preg_match_all('/{graph[_narrow]* ((\d|,|\||-)+)}/', $value, $matches))
		if($count = preg_match_all("/{(graph[_a-z]*) ((\d|,|\||-)+)({([a-zA-Z:,\"\'&quot;]*)})*}/", $value, $matches))
		{

			if($count > 0) {
				for($cnt_graphs = 0; $cnt_graphs<$count; $cnt_graphs++){
					$graph_default_configs = $graph_default_configs_master;
					// Graph Ids
					/*graph details from URL */
					if (isset($_GET['graph_index']) && $cnt_graphs == $_GET['graph_index'] && $isFromUrl == false){
						$get_gids = $_GET['gids'];
						$get_graph_type = $_GET['graph_type'];
						$get_graph_data_from = $_GET['graph_data_from'];
						$get_graph_data_to = $_GET['graph_data_to'];
						$get_graph_index = $_GET['graph_index'];
						$isFromUrl = true;
					}else{
						$get_gids = null;
						$get_graph_type = null;
						$get_graph_data_from = null;
						$get_graph_data_to =null;
						$get_graph_index = null;
					}
					$main = explode('|', $matches[2][$cnt_graphs]);
					$gids = array();
					$GIDS = $get_gids !=null ? explode('|', $get_gids) : explode(',', $main[0]);
					$GID = $GIDS[0];
					$gid = explode('-', $GID);
					$gid = $gid[0];
					$gids = array();
					if(isset($main[1]) and !empty($main[1]))
					{
						$NGIDS = explode(',', $main[1]);
						foreach($NGIDS as $id)
						{
							$nid = explode('-', $id);
							$nid = $nid[0];
							if(in_array($nid, $gids)) continue;
							$gids[] = $nid;
						}
					}
					$gids2 = array();
					foreach($GIDS as $id)
					{
						$nid = explode('-', $id);
						$nid = $nid[0];
						if(in_array($nid, $gids)) continue;
						$gids2[] = $nid;
					}
					// All available graph ids
					$gids = array_merge($gids2, $gids);	
					// GraphId to plot
					$gid_to_plot = $main[0];	
					// Date range
					$dateRange_arr = explode(',',$main[2]);
					// Data - Date From
					$dateinfo_from = explode('-',$dateRange_arr[0]);
					// Data Date To
					$dateinfo_to = explode('-',$dateRange_arr[1]);
					
					//Graph configurations
					$data_period_type = 'monthly';
					switch ($matches[1][$cnt_graphs]){
						case 'graph':
							$data_period_type = 'monthly';
							$dateRange_from = '1-'.$dateinfo_from[1].'-'.$dateinfo_from[0];
							$dateRange_to = '1-'.$dateinfo_to[1].'-'.$dateinfo_to[0];
							break;
						case 'graph_narrow':
							$data_period_type = 'monthly';
							$dateRange_from = '1-'.$dateinfo_from[1].'-'.$dateinfo_from[0];
							$dateRange_to = '1-'.$dateinfo_to[1].'-'.$dateinfo_to[0];
							$graph_default_configs['chartLayout'] = 'narrow';
							break;
						case 'graph_anual':
							$data_period_type = 'anual';
							$dateRange_from = '1-1-'.$dateinfo_from[0];
							$dateRange_to = '1-1-'.$dateinfo_to[0];
							break;
						case 'graph_daily':
							$data_period_type = 'daily';
							$dateRange_from = $dateinfo_from[2].'-'.$dateinfo_from[1].'-'.$dateinfo_from[0];
							$dateRange_to = $dateinfo_to[2].'-'.$dateinfo_to[1].'-'.$dateinfo_to[0];
							break;
						case 'graph_quaterly':
							$data_period_type = 'quaterly';
							$dateRange_from = '1-'.$dateinfo_from[1].'-'.$dateinfo_from[0];
							$dateRange_to = '1-'.$dateinfo_to[1].'-'.$dateinfo_to[0];
							break;							
					}
					$graph_configurations = $graph_default_configs;
					if(isset($matches[4][$cnt_graphs])) {
						$graph_conf_str = html_entity_decode($matches[4][$cnt_graphs]);
						$graph_conf_arr = json_decode($graph_conf_str,true);
						if(is_array($graph_conf_arr)){
							foreach ($graph_conf_arr as $c_ky => $c_val){
								$graph_configurations[$c_ky] = $c_val;
							}
						}
					}
					
					$graph_configurations['dataType'] = $data_period_type;
					if($graph_configurations['isMultiaxis'] == true){
						$graph_configurations['chartType'] = 'multiaxisline';
					}
					if($get_graph_type!=null){
						$graph_configurations['chartType'] = $get_graph_type;
					}
					// Get available chart names
					$availableCharts = $this->makeChartOptions($gids);
					//$isPremiumData = $this->isChartPremium($gids);
					// Get all chart fields
					$chartSelectValues = $this->makeChartSelect($gids);
					
					$availableChartFields = $chartSelectValues['options'];
					// Available Labels
					$availableChartLabels = $chartSelectValues['labels'];
					// Get Chart data
					
					$chart_prefetch_data = $this->getchartData($GIDS,$data_period_type,$availableChartLabels);
					// Is chart premium
					$isPremiumData = $chart_prefetch_data['isPremiumData'];
				/***
				 * 
				 * Sort charts_available and charts_fields_available according to chart code order
				 * 
				 */
					$chart_details = array(
							'chart_actual_code' => $matches[0][$cnt_graphs],
							'chart_config' => $graph_configurations,
							'isPremiumData' => $isPremiumData,
							'charts_available' => $availableCharts,
							'charts_codes_available' => $gids,
							'chart_data_type' => $data_period_type,
							'charts_fields_available' => $availableChartFields,
							'current_chart_codes' => $GIDS,
							'chart_labels_available' => $availableChartLabels,
							'navigator_date_from' => $get_graph_data_from !=null ? $get_graph_data_from : $dateRange_from,
							'navigator_date_to' => $get_graph_data_to !=null ? $get_graph_data_to : $dateRange_to,
							'share_page_url' => 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
							'sources' => $chart_prefetch_data['sources'],
							'chart_data' => $chart_prefetch_data['data']
							
					);

				    //echo "<pre>";print_r($chart_details);die;
					$chart_details_json = json_encode($chart_details,ENT_QUOTES);
					$div_close=($count > 1 && $cnt_graphs!=0)?"</div>":'';
					$div_open=($count > 1 )?"<div class='col-xs-12 catpage_valuecon'>":'';
					$script_chart =$div_close."<div id='Chart_Dv_placeholder_".$cnt_graphs."'></div><script type='text/javascript'>";
					$script_chart.="$(window).load(function() { JMA.JMAChart.initiateChart(".$cnt_graphs.",".$chart_details_json.") });";
					$script_chart.="</script>".$div_open;
					$value = preg_replace('/'.preg_quote($matches[0][$cnt_graphs]).'/', $script_chart, $value);					
				}
			}
			
			$drawchart = "<script type='text/javascript'>$(window).load(function() { JMA.JMAChart.drawAllCharts(); });</script>";
            return $value.$drawchart;     
		}
		return $value."<script type='text/javascript'>$(window).load(function() { JMA.JMAChart.drawAllCharts(); });</script>";
		//return $value;
		
	}
	
	public function makeMapSelect($gids) {
		$graphValues = new Graphvalues();
		$options = array();
		$labels = array();
		foreach($gids as $gid)
		{
			//$charts = $db->selectQuery("select distinct y_value, y_sub_value from graph_values where gid='".$gid."' order by vid");
			$charts = $graphValues->getYAndYSubForThisGidForMap($gid);
			if($charts)
			{
				$has_sub = false;
				if($charts[0]['y_sub_value']) $has_sub = true;

				$options[$gid] = array();
				$i = 0;
				foreach($charts as $chart)
				{
					$value = htmlentities($chart['y_value'],ENT_QUOTES, "UTF-8");
					$svalue = htmlentities($chart['y_sub_value'],ENT_QUOTES, "UTF-8");

					if(!array_key_exists($value, $options[$gid]))
					{
						if($has_sub)
						$options[$gid][$value] = array();
						else {
							$ky_k = $gid."-".$i;
							$options[$gid][$value] = $ky_k;
							$labels[$ky_k] = $value;
						}
					}

					if($has_sub)
					{
						$ky_k_sub = $gid."-".$i;
						$options[$gid][$value][$svalue] = $ky_k_sub;
						$labels[$ky_k_sub] = $value.' - '.$svalue;
					}
					$i++;
				}
			}
		}

		return array('options' => $options, 'labels' => $labels);

	}

	public function makeChartSelect($gids) {
		$graphValues = new Graphvalues();
		$options = array();
		$labels = array();
		foreach($gids as $gid)
		{
			//$charts = $db->selectQuery("select distinct y_value, y_sub_value from graph_values where gid='".$gid."' order by vid");
			$charts = $graphValues->getYAndYSubForThisGid($gid);
			if($charts)
			{
				$has_sub = false;
				if($charts[0]['y_sub_value']) $has_sub = true;

				$options[$gid] = array();
				$i = 0;
				foreach($charts as $chart)
				{
					$value = htmlentities($chart['y_value'],ENT_QUOTES, "UTF-8");
					$svalue = htmlentities($chart['y_sub_value'],ENT_QUOTES, "UTF-8");

					if(!array_key_exists($value, $options[$gid]))
					{
						if($has_sub)
						$options[$gid][$value] = array();
						else {
							$ky_k = $gid."-".$i;
							$options[$gid][$value] = $ky_k;
							$labels[$ky_k] = $value;
						}
					}

					if($has_sub)
					{
						$ky_k_sub = $gid."-".$i;
						$options[$gid][$value][$svalue] = $ky_k_sub;
						$labels[$ky_k_sub] = $value.' - '.$svalue;
					}
					$i++;
				}
			}
		}

		return array('options' => $options, 'labels' => $labels);

	}
	
	public function maxValueOfCurrentYear($gids)
	{
		$graphDetails = new Graphdetails();
		$names = $graphDetails->getMaxValueOfCurrentYear($gids);
		return $names;
		
	}
	
	public function makeJsonDataAll($gids)
	{
		$graphDetails = new Graphdetails();
		$gstr = join(',', $gids);
		$names = $graphDetails->getMapDetailsForJsonDataAll($gstr);
		  $chart_names = array();
		if($names)
		{
			foreach($names as $name)
			$c_names[][$name['x_value']] = $name['value'];
			/*for($i = 0; $i < count($gids); $i++)
			$chart_names[$gids[$i]] = $c_names[$gids[$i]];*/
		}  

		return $c_names;
	}
	
	
	
	public function makeChartCategories($gids)
	{
		$graphDetails = new Graphdetails();
		$gstr = join(',', $gids);
		$names = $graphDetails->getMapDetailsForTheseComaseperatedGids($gstr);
		/* $chart_names = array();
		if($names)
		{
			foreach($names as $name)
			$c_names[$name['gid']] = $name['title'];
			for($i = 0; $i < count($gids); $i++)
			$chart_names[$gids[$i]] = $c_names[$gids[$i]];
		} */

		return $names;
	}
	
	public function mapGraphDetails($gids)
	{
		$graphDetails = new Graphdetails();
		$gstr = join(',', $gids);
		$names = $graphDetails->getMapGraphDetailsForTheseComaseperatedGids($gstr);
		/* $chart_names = array();
		if($names)
		{
			foreach($names as $name)
			$c_names[$name['gid']] = $name['title'];
			for($i = 0; $i < count($gids); $i++)
			$chart_names[$gids[$i]] = $c_names[$gids[$i]];
		} */

		return $names;
	}
	
	
	
	
	public function mapmaxValue($gids)
	{
		$graphDetails = new Graphdetails();
		$gstr = join(',', $gids);
		$names = $graphDetails->getmapmaxValueGids($gstr);
		/* $c_names = array();
		if($names)
		{
			foreach($names as $name)
			$c_names[]['hc-key'] = $name['y_sub_value'];
			/* for($i = 0; $i < count($gids); $i++)
			$chart_names[$gids[$i]] = $c_names[$gids[$i]]; */
		/* }  */

		return $names;
	}
	
	public function makeMapData($gids)
	{
		$graphDetails = new Graphdetails();
		$gstr = join(',', $gids);
		$names = $graphDetails->getMapDataDetailsForGids($gstr);
		$c_names = array();
		if($names)
		{
			foreach($names as $name)
			$c_names[]['hc-key'] = $name['y_sub_value'];
			/* for($i = 0; $i < count($gids); $i++)
			$chart_names[$gids[$i]] = $c_names[$gids[$i]]; */
		}

		return $c_names;
	}

	public function makeChartOptions($gids)
	{
		$graphDetails = new Graphdetails();
		$gstr = join(',', $gids);
		$names = $graphDetails->getGraphDetailsForTheseComaseperatedGids($gstr);
		$chart_names = array();
		if($names)
		{
			foreach($names as $name)
			$c_names[$name['gid']] = $name['title'];
			for($i = 0; $i < count($gids); $i++)
			$chart_names[$gids[$i]] = $c_names[$gids[$i]];
		}

		return $chart_names;
	}
	
	public function makeMapOptions($gids)
	{
		$graphDetails = new Graphdetails();
		$gstr = join(',', $gids);
		$names = $graphDetails->getMapGraphDetailsForTheseComaseperatedGids($gstr);
		$chart_names = array();
		if($names)
		{
			foreach($names as $name)
			$c_names[$name['gid']] = $name['title'];
			for($i = 0; $i < count($gids); $i++)
			$chart_names[$gids[$i]] = $c_names[$gids[$i]];
		}

		return $chart_names;
	}
	
	public function isChartPremium($gids){
		$gstr = join(',', $gids);
		$graphDetails = new Graphdetails();
		return $graphDetails->checkIsPremiumForTheseComaseperatedGids($gstr);
	}
	
	public function isCategoryArrayPremium($category_array) {
		$premium = false;
		foreach ($category_array as $category){
			if($category['premium_category'] == 'Y'){
				$premium = true;
				break;
			}
		}
		return $premium;		
	}
	
	public function getGraphSourcesForTheseGraphIds($gids){
		$graphDetails = new Graphdetails();
		$gids_str = '';
		foreach ($gids as $gid){
			$cGid = explode('-', $gid);
			$gids_str.=$cGid[0].',';
		}
		$response = $graphDetails->getGraphSourceForTheseComaseperatedGids(rtrim($gids_str,','));
		return $response;
	}
	
	public function getMapSourcesForTheseGraphIds($gids){
		$graphDetails = new Graphdetails();
		$gids_str = '';
		foreach ($gids as $gid){
			$cGid = explode('-', $gid);
			$gids_str.=$cGid[0].',';
		}
		$response = $graphDetails->getMapSourceForTheseComaseperatedGids(rtrim($gids_str,','));
		return $response;
	}
	
	
	
	public function getmapData($gids,$data_type,$availableChartLabels,$sate){
		//print_r($sate);
		//print_r($gids);
		$comaSeperatedGids = $gids;
		$Alaneememcached = new Memcachedclass();
	//	$tmp = implode(',', $gids).$data_type;
	//	exit($tmp);
		$alanee_memcached_ky = sha1(implode(',', $gids).$data_type);
		$indicator_values_m = $Alaneememcached->getChartData($alanee_memcached_ky);
		
		if($indicator_values_m != false && count($indicator_values_m)>0) {
			
			return $indicator_values_m;
		}else{
                

			$graphValues = new Graphvalues();
			$results = array();
			$markers = array();
			$sources = $this->getMapSourcesForTheseGraphIds($gids);
			$isPremiumData = $this->isChartPremium($gids);
			$response = '';
			$sid = 0;
			foreach($gids as $gid)
			{
				
				$y_labels = $availableChartLabels[$gid];
				$cvalues = explode(' - ', $y_labels);
				$cids = explode('-', $gid);
				//if(count($cids) != 2) $cids[] = 0;
				//$charts = $db->selectQuery("select distinct y_value, y_sub_value from graph_values where gid='".$gid."' order by vid");
				//$charts = $graphValues->getYAndYSubForThisGid($gid);
				if(count($cvalues)>1) {
					
					
					
					/* if(is_array($sate))
					{
						
						
						foreach($sate as $statename)
			            {
							
							
							//echo $statename."<br>";
							
						
							//$cvalues = array($charts[$cids[1]]['y_value'], $charts[$cids[1]]['y_sub_value']);
							//$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' and not value like '' order by year, month");
							//$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' order by year, month");
							$qry = str_replace('%','\%',"select year, month, date, value from map_values where gid='".$cids[0]."' and y_value like '".$statename."' and not value like '' order by year, month, date");
							$result = $graphValues->getThisqueryResult($qry);
							
							if(!$result)
							{
								$qry_sub = str_replace('%','\%',"select year, month, date, value from map_values where gid='".$cids[0]."' and y_value like '".$statename."'  order by year, month, date");
								$result = $graphValues->getThisqueryResult($qry_sub);
								for($i = 0; $i < count($result); $i++)
								$result[$i]['value'] = 0;
							}
							$results[] = $result;
							//$markers[] = $cvalues;
							
						}	
					}
					else
					{
							//$cvalues = array($charts[$cids[1]]['y_value'], $charts[$cids[1]]['y_sub_value']);
							//$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' and not value like '' order by year, month");
							//$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' order by year, month");
							$qry = str_replace('%','\%',"select year, month, date, value from map_values where gid='".$cids[0]."' and y_value like '".$sate."' and not value like '' order by year, month, date");
							$result = $graphValues->getThisqueryResult($qry);
							if(!$result)
							{
								$qry_sub = str_replace('%','\%',"select year, month, date, value from map_values where gid='".$cids[0]."' and y_value like '".$sate."'  order by year, month, date");
								$result = $graphValues->getThisqueryResult($qry_sub);
								for($i = 0; $i < count($result); $i++)
								$result[$i]['value'] = 0;
							}
							$results[$gid] = $result;
							//$markers[] = $cvalues;
					} */
					if(is_array($sate))
					{
					        //$cvalues = array($charts[$cids[1]]['y_value'], $charts[$cids[1]]['y_sub_value']);
							//$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' and not value like '' order by year, month");
							//$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' order by year, month");
							$replaceValue = array('%');
							$replacementValue = array('\%');
							
							$qry = str_replace($replaceValue,$replacementValue,"select year, month, date, value from map_values where gid='".$cids[0]."' and y_value like '".$sate[$sid]."' and not value like '' order by year, month, date");
							$result = $graphValues->getThisqueryResult($qry);
							if(!$result)
							{
								$qry_sub = str_replace($replaceValue,$replacementValue,"select year, month, date, value from map_values where gid='".$cids[0]."' and y_value like '".$sate[$sid]."'  order by year, month, date");
								$result = $graphValues->getThisqueryResult($qry_sub);
								for($i = 0; $i < count($result); $i++)
								$result[$i]['value'] = 0;
							}
							$results[$gid] = $result;
							//$markers[] = $cvalues;
							
					}
					else
					{
						
						    //$cvalues = array($charts[$cids[1]]['y_value'], $charts[$cids[1]]['y_sub_value']);
							//$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' and not value like '' order by year, month");
							//$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' order by year, month");
							$replaceValue = array('%');
							$replacementValue = array('\%');
							
							$qry = str_replace($replaceValue,$replacementValue,"select year, month, date, value from map_values where gid='".$cids[0]."' and y_value like '".$sate."' and not value like '' order by year, month, date");
							$result = $graphValues->getThisqueryResult($qry);
							if(!$result)
							{
								$qry_sub = str_replace('%','\%',"select year, month, date, value from map_values where gid='".$cids[0]."' and y_value like '".$sate."'  order by year, month, date");
								$result = $graphValues->getThisqueryResult($qry_sub);
								for($i = 0; $i < count($result); $i++)
								$result[$i]['value'] = 0;
							}
							$results[$gid] = $result;
							//$markers[] = $cvalues;

					}						 
				         
					
				}	
				
				$sid++;
			}
			
		
			$indicator_values = array();
			$start_end_details = $this->getStartAndEndDateDetails($results);
		//	echo '<pre>';
		//	print_r($start_end_details); exit;
			$start_year = $start_end_details['start_year'];
			$end_year = $start_end_details['end_year'];
			$start_month = $start_end_details['start_month'];
			$end_month = $start_end_details['end_month'];
			$start_date = $start_end_details['start_date'];
			$end_date = $start_end_details['end_date'];
			$is_start_date_considered = false;
			$is_start_month_considered = false;
			$is_start_year_considered = false;
			
			$chart_formatted_array = array();
			foreach ($results as $chart_code_ky => $val_rows){
				//print_r($val_rows);
				$data_raw = array();
				foreach ($val_rows as $val_row){
					$val_row_year = $val_row['year'];
					$val_row_month = sprintf("%02s",$val_row['month']);
					$val_row_date = $val_row['date'];
					$val_row_value = $val_row['value'];
					switch ($data_type){
						case 'anual':
							$data_raw[$val_row_year] = $val_row_value;
							break;
						case 'quaterly':
							$data_raw[$val_row_year][$val_row_month] = $val_row_value;
							break;
						case 'monthly':
							$data_raw[$val_row_year][$val_row_month] = $val_row_value;
							break;
						case 'daily':
							$data_raw[$val_row_year][$val_row_month][$val_row_date] = $val_row_value;
							break;
					}
				}
				$chart_formatted_array[$chart_code_ky] = $data_raw;			
			}
		//	echo '<pre>';
		//	print_r($chart_formatted_array); //exit;
			foreach ($chart_formatted_array as $chart_code => $chart_value_rows) {
				$pre_val_to_fill = null;
				$indicator_values[$chart_code] = array();
				for($i_year = $start_year; $i_year <= $end_year ; $i_year++){
					switch ($data_type){
						case 'anual':
							$php_time = '1-1-'.$i_year;
							$php_timestamp = strtotime('1-1-'.$i_year);
							$js_timestamp = ($php_timestamp*1000);
							$filled_value = isset($chart_value_rows[$i_year]) ? $chart_value_rows[$i_year] : null;
							$indicator_values[$chart_code][] = array($php_time,$filled_value);
							break;
						case 'quaterly':
							for($i_month = 1; $i_month <= 12; $i_month++){
								if($i_month == 3 || $i_month == 6 || $i_month == 9 || $i_month == 12) {
									$ky_month = sprintf("%02s", $i_month);
									$php_time = '1-'.$i_month.'-'.$i_year;
									//$php_timestamp = strtotime('1-'.$i_month.'-'.$i_year);
									//$js_timestamp = ($php_timestamp*1000);
									if($end_month >= (int)$i_year.$ky_month){
										//$pre_val_to_fill = isset($chart_value_rows[$i_year][$ky_month]) ? $chart_value_rows[$i_year][$ky_month] : $pre_val_to_fill;
										$filled_value = isset($chart_value_rows[$i_year][$ky_month]) ? $chart_value_rows[$i_year][$ky_month] : null;
										$indicator_values[$chart_code][] = array($php_time,$filled_value);
									}
								}
							}
							break;
						case 'monthly':
							for($i_month = 1; $i_month <= 12; $i_month++){
								$ky_month = sprintf("%02s", $i_month);
								$php_time = '1-'.$i_month.'-'.$i_year;
								//$php_timestamp = strtotime('1-'.$i_month.'-'.$i_year);
								//$js_timestamp = ($php_timestamp*1000);
							//	$js_timestamp = '1-'.$i_month.'-'.$i_year;
								if($end_month >= (int)$i_year.$ky_month){
									$filled_value = isset($chart_value_rows[$i_year][$ky_month]) ? $chart_value_rows[$i_year][$ky_month] : null;
									$indicator_values[$chart_code][] = array($php_time,$filled_value);
								}
							}
							break;
						case 'daily':
							for($i_month = 1; $i_month <= 12; $i_month++){
								$ky_month = sprintf("%02s", $i_month);
								if($end_year == $i_year && $end_month == $i_month){
									$no_of_days = $end_date;
								}else{
									$no_of_days = cal_days_in_month(CAL_GREGORIAN, $ky_month, $i_year);
								}
								for($i_date = 1; $i_date <= $no_of_days; $i_date++){
									$php_time = $i_date.'-'.$i_month.'-'.$i_year;
								//	echo $php_time;
								//	echo '<br>';
									//$php_timestamp = strtotime($i_date.'-'.$i_month.'-'.$i_year);
									//$js_timestamp = ($php_timestamp*1000);
									$ky_date = sprintf("%02s", $i_date);
									$filled_value = isset($chart_value_rows[$i_year][$ky_month][$ky_date]) ? $chart_value_rows[$i_year][$ky_month][$ky_date] : null;
									$indicator_values[$chart_code][] = array($php_time,$filled_value);
								}
							}
							break;
					}				
				}
			}
			
			
			
			$response_chartData = array(
				'sources' => $sources,
				'isPremiumData' => $isPremiumData,
				'data' => $indicator_values
			);
			
			/* echo "<pre>";
			print_r($indicator_values);
			exit; */
			
			
			$mem_stat = $Alaneememcached->setChartData($alanee_memcached_ky,$response_chartData);
			
			return $response_chartData;
		}
	}


	public function getchartData($gids,$data_type,$availableChartLabels){
		$comaSeperatedGids = $gids;
		$Alaneememcached = new Memcachedclass();
	//	$tmp = implode(',', $gids).$data_type;
	//	exit($tmp);
		$alanee_memcached_ky = sha1(implode(',', $gids).$data_type);
		$indicator_values_m = $Alaneememcached->getChartData($alanee_memcached_ky);
		if($indicator_values_m != false && count($indicator_values_m)>0) {
			return $indicator_values_m;
		}else{


			$graphValues = new Graphvalues();
			$results = array();
			$markers = array();
			$sources = $this->getGraphSourcesForTheseGraphIds($gids);
			$isPremiumData = $this->isChartPremium($gids);
			$response = '';
			foreach($gids as $gid)
			{
				
				$y_labels = $availableChartLabels[$gid];
				$cvalues = explode(' - ', $y_labels);
				$cids = explode('-', $gid);
				//if(count($cids) != 2) $cids[] = 0;
				//$charts = $db->selectQuery("select distinct y_value, y_sub_value from graph_values where gid='".$gid."' order by vid");
				//$charts = $graphValues->getYAndYSubForThisGid($gid);
				if(count($cvalues)>1) {
					//$cvalues = array($charts[$cids[1]]['y_value'], $charts[$cids[1]]['y_sub_value']);
					//$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' and not value like '' order by year, month");
					//$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' order by year, month"); Coarse&#039;s cereals
					//echo htmlspecialchars_decode($cvalues[0]); exit;
					// echo htmlspecialchars_decode(html_entity_decode($cvalues[0]),ENT_QUOTES); exit;
					 
					 
					 $firstCvalue = htmlspecialchars_decode(html_entity_decode($cvalues[0]),ENT_QUOTES);
					 
					 $splitArrayCvalues =  explode('&',$firstCvalue);
					
					 if(isset($splitArrayCvalues[0]) && $splitArrayCvalues[0] != '')
					 {
						 $cvaluesFirst = current($splitArrayCvalues).'%';
						 $cvaluesend = '%'.str_replace("amp;","",end($splitArrayCvalues));
						 
						 
						$qry = "select year, month, date, value from graph_values where gid='".$cids[0]."' and y_value like '".$cvaluesFirst."' and y_value LIKE '".$cvaluesend."' and y_sub_value='".$cvalues[1]."' and not value like '' order by year, month, date";
					 }
					 else
					 {
						  $qry = str_replace('%','\%',"select year, month, date, value from graph_values where gid='".$cids[0]."' and y_value like '".addslashes($firstCvalue)."' and y_sub_value='".$cvalues[1]."' and not value like '' order by year, month, date");
					 }
					
					 
					$result = $graphValues->getThisqueryResult($qry);

					if(!$result)
					{
						
						 $firstCvalue = htmlspecialchars_decode(html_entity_decode($cvalues[0]),ENT_QUOTES);
						
						 $splitArrayCvalues =  explode('&',$firstCvalue);
						 if($splitArrayCvalues[1] != '')
						 {
							 $cvaluesFirst = current($splitArrayCvalues).'%';
							 $cvaluesend = '%'.str_replace("amp;","",end($splitArrayCvalues));
							 
							 
							 $qry_sub = "select year, month, date, value from graph_values where gid='".$cids[0]."' and y_value like '".$cvaluesFirst."' and y_value like '".$cvaluesend."' and y_sub_value='".$cvalues[1]."' order by year, month, date";
						 }
						 else
						 {
							  $qry_sub = str_replace('%','\%',"select year, month, date, value from graph_values where gid='".$cids[0]."' and y_value like '".addslashes($firstCvalue)."' and y_sub_value='".$cvalues[1]."' order by year, month, date");
						 }
						
						
						$result = $graphValues->getThisqueryResult($qry_sub);
						for($i = 0; $i < count($result); $i++)
						$result[$i]['value'] = 0;
					}
					$results[$gid] = $result;
					//$markers[] = $cvalues;
				}
			}
			
			$indicator_values = array();
			$start_end_details = $this->getStartAndEndDateDetails($results);
		//	echo '<pre>';
		//	print_r($start_end_details); exit;
			$start_year = $start_end_details['start_year'];
			$end_year = $start_end_details['end_year'];
			$start_month = $start_end_details['start_month'];
			$end_month = $start_end_details['end_month'];
			$start_date = $start_end_details['start_date'];
			$end_date = $start_end_details['end_date'];
			$is_start_date_considered = false;
			$is_start_month_considered = false;
			$is_start_year_considered = false;
			
			$chart_formatted_array = array();
			foreach ($results as $chart_code_ky => $val_rows){
				$data_raw = array();
				foreach ($val_rows as $val_row){
					$val_row_year = $val_row['year'];
					$val_row_month = sprintf("%02s",$val_row['month']);
					$val_row_date = $val_row['date'];
					$val_row_value = $val_row['value'];
					switch ($data_type){
						case 'anual':
							$data_raw[$val_row_year] = $val_row_value;
							break;
						case 'quaterly':
							$data_raw[$val_row_year][$val_row_month] = $val_row_value;
							break;
						case 'monthly':
							$data_raw[$val_row_year][$val_row_month] = $val_row_value;
							break;
						case 'daily':
							$data_raw[$val_row_year][$val_row_month][$val_row_date] = $val_row_value;
							break;
					}
				}
				$chart_formatted_array[$chart_code_ky] = $data_raw;			
			}
		//	echo '<pre>';
		//	print_r($chart_formatted_array); //exit;
			foreach ($chart_formatted_array as $chart_code => $chart_value_rows) {
				$pre_val_to_fill = null;
				$indicator_values[$chart_code] = array();
				for($i_year = $start_year; $i_year <= $end_year ; $i_year++){
					switch ($data_type){
						case 'anual':
						    
							$php_time = '1-1-'.$i_year;
							$php_timestamp = strtotime('1-1-'.$i_year);
							$js_timestamp = ($php_timestamp*1000);
							$filled_value = isset($chart_value_rows[$i_year]) ? $chart_value_rows[$i_year] : null;
							$indicator_values[$chart_code][] = array($php_time,$filled_value);
							break;
						case 'quaterly':
							for($i_month = 1; $i_month <= 12; $i_month++){
								if($i_month == 3 || $i_month == 6 || $i_month == 9 || $i_month == 12) {
									$ky_month = sprintf("%02s", $i_month);
									$php_time = '1-'.$i_month.'-'.$i_year;
									//$php_timestamp = strtotime('1-'.$i_month.'-'.$i_year);
									//$js_timestamp = ($php_timestamp*1000);
									if($end_month >= (int)$i_year.$ky_month){
										//$pre_val_to_fill = isset($chart_value_rows[$i_year][$ky_month]) ? $chart_value_rows[$i_year][$ky_month] : $pre_val_to_fill;
										$filled_value = isset($chart_value_rows[$i_year][$ky_month]) ? $chart_value_rows[$i_year][$ky_month] : null;
										$indicator_values[$chart_code][] = array($php_time,$filled_value);
									}
								}
							}
							break;
						case 'monthly':
							for($i_month = 1; $i_month <= 12; $i_month++){
								$ky_month = sprintf("%02s", $i_month);
								$php_time = '1-'.$i_month.'-'.$i_year;
								//$php_timestamp = strtotime('1-'.$i_month.'-'.$i_year);
								//$js_timestamp = ($php_timestamp*1000);
							//	$js_timestamp = '1-'.$i_month.'-'.$i_year;
								if($end_month >= (int)$i_year.$ky_month){
									$filled_value = isset($chart_value_rows[$i_year][$ky_month]) ? $chart_value_rows[$i_year][$ky_month] : null;
									$indicator_values[$chart_code][] = array($php_time,$filled_value);
								}
							}
							break;
						case 'daily':
							for($i_month = 1; $i_month <= 12; $i_month++){
								$ky_month = sprintf("%02s", $i_month);
								if($end_year == $i_year && $end_month == $i_month){
									$no_of_days = $end_date;
								}else{
									$no_of_days = cal_days_in_month(CAL_GREGORIAN, $ky_month, $i_year);
								}
								for($i_date = 1; $i_date <= $no_of_days; $i_date++){
									$php_time = $i_date.'-'.$i_month.'-'.$i_year;
								//	echo $php_time;
								//	echo '<br>';
									//$php_timestamp = strtotime($i_date.'-'.$i_month.'-'.$i_year);
									//$js_timestamp = ($php_timestamp*1000);
									$ky_date = sprintf("%02s", $i_date);
									$filled_value = isset($chart_value_rows[$i_year][$ky_month][$ky_date]) ? $chart_value_rows[$i_year][$ky_month][$ky_date] : null;
									$indicator_values[$chart_code][] = array($php_time,$filled_value);
								}
							}
							break;
					}				
				}
			}
			$response_chartData = array(
				'sources' => $sources,
				'isPremiumData' => $isPremiumData,
				'data' => $indicator_values
			);
			$mem_stat = $Alaneememcached->setChartData($alanee_memcached_ky,$response_chartData);
			
			return $response_chartData;
		}
	}	
	
	protected function getStartAndEndDateDetails($results){
		$response = array(
			'start_year' => 0,
			'end_year' => 0,
			'start_month' => 0,
			'end_month' => 0,
			'start_date' => 0,
			'end_date' => 0		
		);
		foreach ($results as $rw_flt_val){
			$response['start_year'] = $response['start_year'] == 0 ? $rw_flt_val[0]['year'] : ($rw_flt_val[0]['year'] < $response['start_year'] ? $rw_flt_val[0]['year'] : $response['start_year']);
			$response['start_month'] = $response['start_month'] == 0 ? $rw_flt_val[0]['month'] : ($rw_flt_val[0]['month'] < $response['start_month'] ? $rw_flt_val[0]['month'] : $response['start_month']);
			$response['start_date'] = $response['start_date'] == 0 ? $rw_flt_val[0]['date'] : ($rw_flt_val[0]['date'] < $response['start_date'] ? $rw_flt_val[0]['date'] : $response['start_date']);
			
			$end_rw_flt_val = end($rw_flt_val);
			
			$response['end_year'] = $response['end_year'] == 0 ? $end_rw_flt_val['year'] : ($end_rw_flt_val['year'] > $response['end_year'] ? $end_rw_flt_val['year'] : $response['end_year']);
			$response['end_month'] = $response['end_month'] == 0 ? (int)$response['end_year'].$end_rw_flt_val['month'] : ((int)$response['end_year'].$end_rw_flt_val['month'] > $response['end_month'] ? (int)$response['end_year'].$end_rw_flt_val['month'] : $response['end_month']);
			$response['end_date'] = $response['end_date'] == 0 ? $end_rw_flt_val['date'] : ($end_rw_flt_val['date'] > $response['end_date'] ? $end_rw_flt_val['date'] : $response['end_date']);
		}
		return $response;
	}
	
	
	public function getFilePath($gids)
	{
		$graphDetails = new Graphdetails();
		$gstr = join(',', $gids);
		$results = $graphDetails->getFilepathForTheseComaseperatedGids($gstr);
		$ret = array();
		foreach($results as $res)
		$ret[$res['gid']] = urlencode($res['filepath']);
		return $ret;
	}

	public function cleanMyCkEditor($value){
		$value = str_replace('\r\n', "", $value);
		$value = str_replace('<p> </p>', "", $value);
		$value = str_replace('<p>&nbsp;</p>', "", $value);
		$value = str_replace('\\\&quot;', "", $value);
		$value = str_replace('\\', "", $value);
		return $value;
	}

	public function editorfix($value){

		$order   = array("\\r\\n", "\\n", "\\r", "rn","<p>&nbsp;</p>","\\","\'");

		$replace = array(" ", " ", "", "","","","","'");

		$value = str_replace($order, $replace, $value);

		return $value;

	}
	public function createPassword($length) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,$length);
	}
}