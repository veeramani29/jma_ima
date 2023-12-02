<?php
namespace App\Lib;
if (!defined('SERVER_ROOT')) exit('No direct script access allowed');

use App\Model\Graphdetails;
use App\Model\Graphvalues;
use App\Model\Memcachedclass;
use Session;
class CommonClass
{
     
     
     public function makeChart($value, $isNavigator = true,$isRecent = false)
     {
               //if($isRecent){
     	//Commented by Veera On March 12
            /*   if(!Session::has('user')){
                    $popup_link_url="href='javascript:JMA.User.showLoginBox(".'"premium","'.url()->current().'"'.");'";
               }else{
           $popup_link_url="data-toggle='modal' data-target='#Dv_modal_upgrade_premium_content'";  
               }
               if(!Session::has('user') || (Session::has('user') && Session::get('user.user_type_id')==1 )){ 
               if((Session::has('user') && Session::get('user.user_type_id')==1 )){ 
$text_msg="<p>If you are a Free account user registered before Jan 2018, please upgrade your subscription status from <a href=".url('user/myaccount/subscription').">here</a>. </p>";
}else{

$text_msg="<p>If you are already a JMA subscriber please <a class='subscriber_login' ".$popup_link_url." >login</a></p>";
}

                 // if(!Session::has('user')){
               $Recent_Postfix = strstr($value, 'Recent'); 
               $onlyRecent_data_ = strstr($Recent_Postfix, 'Brief',true);
               $onlyRecent_datarplc_ = str_ireplace(array('Recent data trend :','Recent data trend:','Recent data trend'),'',$onlyRecent_data_);
               $sub_resent_data =substr(strip_tags($onlyRecent_datarplc_),0,500);

               $value = str_ireplace($onlyRecent_datarplc_, "<p class='rdt_readmore'>".$sub_resent_data."...</p><p><div style='padding: 20px 20px 11px;background-color: #dddddd;'><p> To read more, please become a our Standard subscriber.</p><a target='_blank' href='".url('products')."' class='rdt_modal btn btn-success'  >Start a subscription with 30-days Free Trial <i class='fa fa-angle-right' aria-hidden='true'></i></a>".$text_msg."
                   </div></p>", $value);
              
               // }

         }*/

         //Commented by Veera On March 12

          $time_start                   = microtime(true);
          /*    $php_timestamp = strtotime('0-0-1990');
          $js_timestamp = ($php_timestamp*1000);
          
          echo $js_timestamp;
          
          exit;
          */
          $isFromUrl                    = false;
          $chart_details                = array();
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
          // if($count = preg_match_all('/{graph[_narrow]* ((\d|,|\||-)+)}/', $value, $matches))
          if ($count = preg_match_all("/{(graph[_a-z]*|map[_a-z]*) ((\d|,|\||-)+)({([a-zA-Z:,\"\'&quot;]*)})*}/", $value, $matches)) {


               
               if ($count > 0) {
                    
                    
                    for ($cnt_graphs = 0; $cnt_graphs < $count; $cnt_graphs++) {
                         $graph_default_configs = $graph_default_configs_master;
                         // Graph Ids
                         /*graph details from URL */
                         if (isset($_GET['graph_index']) && $cnt_graphs == $_GET['graph_index'] && $isFromUrl == false) {
                              $get_gids            = $_GET['gids'];
                              $get_graph_type      = $_GET['graph_type'];
                              $get_graph_data_from = $_GET['graph_data_from'];
                              $get_graph_data_to   = $_GET['graph_data_to'];
                              $get_graph_index     = $_GET['graph_index'];
                              $isFromUrl           = true;
                         } else {
                              $get_gids            = null;
                              $get_graph_type      = null;
                              $get_graph_data_from = null;
                              $get_graph_data_to   = null;
                              $get_graph_index     = null;
                         }
                         $main = explode('|', $matches[2][$cnt_graphs]);
                         $gids = array();
                         $GIDS = $get_gids != null ? explode('|', $get_gids) : explode(',', $main[0]);
                         $GID  = $GIDS[0];
                         $gid  = explode('-', $GID);
                         $gid  = $gid[0];
                         $gids = array();
                         if (isset($main[1]) and !empty($main[1])) {
                              $NGIDS = explode(',', $main[1]);
                              foreach ($NGIDS as $id) {
                                   $nid = explode('-', $id);
                                   $nid = $nid[0];
                                   if (in_array($nid, $gids))
                                        continue;
                                   $gids[] = $nid;
                              }
                         }
                         $gids2 = array();
                         foreach ($GIDS as $id) {
                              $nid = explode('-', $id);
                              $nid = $nid[0];
                              if (in_array($nid, $gids))
                                   continue;
                              $gids2[] = $nid;
                         }
                         // All available graph ids
                         $gids          = array_merge($gids2, $gids);
                         $all_the_gids  = $gids;
                         // GraphId to plot
                         $gid_to_plot   = $main[0];
                         // Date range
                         $dateRange_arr = explode(',', isset($main[2]) ? $main[2] : '');

                         // Data - Date From
                         $dateinfo_from = explode('-', $dateRange_arr[0]);
                         // Data Date To
                         $dateinfo_to   = explode('-', isset($dateRange_arr[1]) ? $dateRange_arr[1] : '');
                          
                         //Graph configurations
                         $data_period_type = 'monthly';
                         switch ($matches[1][$cnt_graphs]) {
                              case 'graph_yield':
                                   $data_period_type                   = 'yield';
                                   $dateRange_from                     = $dateinfo_from[0];
                                   $dateRange_to                       = $dateinfo_to[0];
                                   $graph_default_configs['chartType'] = 'yield_line';
                                   break;
                              
                              case 'graph_yield_narrow':
                                   $data_period_type                     = 'yield';
                                   $dateRange_from                       = $dateinfo_from[0];
                                   $dateRange_to                         = $dateinfo_to[0];
                                   $graph_default_configs['chartType']   = 'yield_line';
                                   $graph_default_configs['chartLayout'] = 'narrow';
                                   break;
                              case 'graph_yield_daily':
                                   $data_period_type                   = 'yield_daily';
                                   $dateRange_from                     = $dateinfo_from[0];
                                   $dateRange_to                       = $dateinfo_to[0];
                                   $graph_default_configs['chartType'] = 'yield_line';
                                   break;
                              case 'graph_yield_monthly':
                                   $data_period_type                   = 'yield_monthly';
                                   $dateRange_from                     = $dateinfo_from[0];
                                   $dateRange_to                       = $dateinfo_to[0];
                                   $graph_default_configs['chartType'] = 'yield_line';
                                   break;
                              case 'graph':
                                   $data_period_type = 'monthly';
                                   $dateRange_from   = '1-' . $dateinfo_from[1] . '-' . $dateinfo_from[0];
                                   $dateRange_to     = '1-' . $dateinfo_to[1] . '-' . $dateinfo_to[0];
                                   break;
                              case 'graph_narrow':
                                   $data_period_type                     = 'monthly';
                                   $dateRange_from                       = '1-' . $dateinfo_from[1] . '-' . $dateinfo_from[0];
                                   $dateRange_to                         = '1-' . $dateinfo_to[1] . '-' . $dateinfo_to[0];
                                   $graph_default_configs['chartLayout'] = 'narrow';
                                   break;
                              case 'graph_anual':
                                   $data_period_type = 'anual';
                                   $dateRange_from   = '1-1-' . $dateinfo_from[0];
                                   $dateRange_to     = '1-1-' . $dateinfo_to[0];
                                   break;
                                 /*  case 'map_anual':
                                   $data_period_type = 'anual';
                                   $dateRange_from   = '1-1-' . $dateinfo_from[0];
                                   $dateRange_to     = '1-1-' . $dateinfo_to[0];
                                   break;*/
                              case 'graph_daily':
                                   $data_period_type = 'daily';
                                   $dateRange_from   = $dateinfo_from[2] . '-' . $dateinfo_from[1] . '-' . $dateinfo_from[0];
                                   $dateRange_to     = $dateinfo_to[2] . '-' . $dateinfo_to[1] . '-' . $dateinfo_to[0];
                                   break;
                              case 'graph_quaterly':
                                   $data_period_type = 'quaterly';
                                   $dateRange_from   = '1-' . $dateinfo_from[1] . '-' . $dateinfo_from[0];
                                   $dateRange_to     = '1-' . $dateinfo_to[1] . '-' . $dateinfo_to[0];
                                   break;
                         }
                         $graph_configurations = $graph_default_configs;
                         
                         /* $graph_conf_str = html_entity_decode($matches[4][$cnt_graphs]);
                         $graph_conf_arr = json_decode($graph_conf_str,true);
                         echo $graph_conf_arr['chartType']; */
                         
                         if (isset($matches[4][$cnt_graphs])) {
                              
                              $graph_conf_str = html_entity_decode($matches[4][$cnt_graphs]);
                              $graph_conf_arr = json_decode($graph_conf_str, true);
                              
                              if (is_array($graph_conf_arr)) {
                                   foreach ($graph_conf_arr as $c_ky => $c_val) {
                                        $graph_configurations[$c_ky] = $c_val;
                                   }
                              }
                         }
                         
                         $graph_configurations['dataType'] = $data_period_type;
                         if ($graph_configurations['isMultiaxis'] == true) {
                              $graph_configurations['chartType'] = 'multiaxisline';
                         }
                         if ($get_graph_type != null) {
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

                              $extra_Para=array();

                              if($graph_configurations['chartType']=='map'){
                              $extra_Para['map']=$matches[1][$cnt_graphs];
                               $dateinfo_   = explode('-', isset($dateRange_arr[2]) ? $dateRange_arr[2] : '');
                              $extra_Para['year_select']=($data_period_type=='anual')?(int)$dateinfo_[0]:$dateRange_arr[2];
                               $graph_configurations['default_year'] = ($data_period_type=='anual')?(int)$dateinfo_[0]:$dateRange_arr[2];
                             
                              }
                         $chart_prefetch_data  = $this->getchartData($GIDS, $data_period_type, $availableChartLabels, $all_the_gids,$cnt_graphs,$graph_default_configs['chartLayout'],$extra_Para);
                         
                         // Is chart premium
                         $isPremiumData = $chart_prefetch_data['isPremiumData'];
                         /***
                          * 
                          * Sort charts_available and charts_fields_available according to chart code order
                          * 
                          */
                         
                         // print_r($graph_configurations);
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
                              'navigator_date_from' => $get_graph_data_from != null ? $get_graph_data_from : $dateRange_from,
                              'navigator_date_to' => $get_graph_data_to != null ? $get_graph_data_to : $dateRange_to,
                              'share_page_url' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                              'sources' => $chart_prefetch_data['sources'],
                              'chart_data' => $chart_prefetch_data['data']
                              
                         );
                         
                         //echo "<pre>";print_r($chart_details);die;
                         $chart_details_json = json_encode($chart_details);
                         $div_close          = ($count > 1 && $cnt_graphs != 0) ? "</div>" : '';
                         $div_open           = ($count > 1) ? "<div class='col-xs-12 catpage_valuecon'>" : '';
                         $script_chart       = $div_close . "<div id='Chart_Dv_placeholder_" . $cnt_graphs . "'></div><script type='text/javascript'>";
                         $script_chart .= "$(window).load(function() { initiateChart_(" . $cnt_graphs . "," . $chart_details_json . ");   });";
                         $script_chart .= "</script>" . $div_open;
                         $value = preg_replace('/' . preg_quote($matches[0][$cnt_graphs]) . '/', $script_chart, $value);
                    }
               }
               
          }
          /*$time_end = microtime(true);
          $time = $time_end - $time_start;
          echo "Process Time: {$time}";die;*/
          return $value;
     }
     
     
     
     public function makeChartSelect($gids)
     {
          $graphValues = new Graphvalues();
          $options     = array();
          $labels      = array();
          foreach ($gids as $gid) {
               //$charts = $db->selectQuery("select distinct y_value, y_sub_value from graph_values where gid='".$gid."' order by vid");
               $charts = $graphValues->getYAndYSubForThisGid($gid);
               if ($charts) {
                    $has_sub = false;
                    if ($charts[0]['y_sub_value'])
                         $has_sub = true;
                    
                    $options[$gid] = array();
                    $i             = 0;
                    foreach ($charts as $chart) {
                         $value  = htmlentities($chart['y_value'], ENT_QUOTES, "UTF-8");
                         $svalue = htmlentities($chart['y_sub_value'], ENT_QUOTES, "UTF-8");
                         
                         if (!array_key_exists($value, $options[$gid])) {
                              if ($has_sub)
                                   $options[$gid][$value] = array();
                              else {
                                   $ky_k                  = $gid . "-" . $i;
                                   $options[$gid][$value] = $ky_k;
                                   $labels[$ky_k]         = $value;
                              }
                         }
                         
                         if ($has_sub) {
                              $ky_k_sub                       = $gid . "-" . $i;
                              $options[$gid][$value][$svalue] = $ky_k_sub;
                              $labels[$ky_k_sub]              = $value . ' - ' . $svalue;
                         }
                         $i++;
                    }
               }
          }
          
          return array(
               'options' => $options,
               'labels' => $labels
          );
          
     }
     
     public function makeChartOptions($gids)
     {
          $graphDetails = new Graphdetails();
          $gstr         = join(',', $gids);
          $names        = $graphDetails->getGraphDetailsForTheseComaseperatedGids($gstr);
          $chart_names  = array();
          if ($names) {
               foreach ($names as $name)
                    $c_names[$name['gid']] = $name['title'];
               for ($i = 0; $i < count($gids); $i++)
                    $chart_names[$gids[$i]] = $c_names[$gids[$i]];
          }
          
          return $chart_names;
     }
     
     public function isChartPremium($gids)
     {
          $gstr         = join(',', $gids);
          $graphDetails = new Graphdetails();
          return $graphDetails->checkIsPremiumForTheseComaseperatedGids($gstr);
     }
     
     public function isCategoryArrayPremium($category_array)
     {
          $premium = false;
          foreach ($category_array as $category) {
               if ($category['premium_category'] == 'Y') {
                    $premium = true;
                    break;
               }
          }
          return $premium;
     }
     
     public function getGraphSourcesForTheseGraphIds($gids)
     {
          $graphDetails = new Graphdetails();
          $gids_str     = '';
          foreach ($gids as $gid) {
               $cGid = explode('-', $gid);
               $gids_str .= $cGid[0] . ',';
          }
          $response = $graphDetails->getGraphSourceForTheseComaseperatedGids(rtrim($gids_str, ','));
          return $response;
     }
     
     public function getchartData_($gids, $data_type, $availableChartLabels, $sources, $isPremiumData, $start_end_details, $file_name_json)
     {
          ini_set('memory_limit', '-1');
     
         // dd($gids);
          $graphValues                 = new Graphvalues();
          $finalArray['sources']       = $sources;
          $finalArray['isPremiumData'] = $isPremiumData;
          $finalArray['datas']         = array();
          $json_result['All_data']     = array();
          $resultArray                 = array();
          $i=0;
          foreach ($gids as $gid) {
             
               if (strpos($data_type, 'yield') !== false) {
                              
                              $order_by = '* 1';
                         } else {
                            
                              $order_by = ', `month`, `date`';
                         }

               $qry               = str_replace('%', '\%', "select  * from `graph_values` where `gid`=" . $gid . " and not `value` like '' order by `year`  $order_by");
              
               $resultArray[$gid] = $graphValues->getThisqueryResult($qry);
              
           $i++;
          } 
        
          // dd($resultArray);die;
          
          if (is_array($resultArray)) {
               foreach ($resultArray as $chart_key_code => $chart_key_code_value) {
                    foreach ($chart_key_code_value as $eachKey => $eachValue) {


                    $chart_code_data_coloumn=$chart_key_code."-" .($eachValue['data_coloumn'] - 2);
                         $val_row_year    = $eachValue['year'];
                         $val_row_x_value = (strpos($data_type, 'yield') !== false) ? $eachValue['x_value'] : null;
                         $val_row_month = sprintf("%02s", $eachValue['month']);
                         $val_row_date  = $eachValue['date'];
                         $val_row_value = $eachValue['value'];
                         switch ($data_type) {
                              case 'yield':
                              case 'yield_daily':
                              case 'yield_monthly':
                                    $json_result['All_data'][$chart_code_data_coloumn][$val_row_x_value] = $val_row_value;
                                    break;
                                   case 'anual':
                               $json_result['All_data'][$chart_code_data_coloumn][$eachValue['year']] = $eachValue['value'];
                                break;
                              case 'quaterly':
                               $json_result['All_data'][$chart_code_data_coloumn][$val_row_year][$val_row_month] = $val_row_value;
                                break;
                              case 'monthly':
                               $json_result['All_data'][$chart_code_data_coloumn][$val_row_year][$val_row_month] = $val_row_value;
                               break;
                              case 'daily':
                              $json_result['All_data'][$chart_code_data_coloumn][$val_row_year][$val_row_month][$val_row_date] = $val_row_value;
                              break;
                         }
                         
                        
                         
                    }

               }
          }
          
         
          if (is_array($json_result['All_data'])) {

               if (strpos($data_type, 'yield') !== false) {
                    $start_end_details['start_year'] = 0;
                    $start_end_details['end_year']   = 0;
               }

               foreach ($json_result['All_data'] as $All_data_key_code => $All_data_key_code_value) {
                    
                         $last_manth=end($All_data_key_code_value);
                          if (strpos($data_type, 'yield') === false) {
                         $last_year=key($All_data_key_code_value);
                         if($start_end_details['end_year']<$last_year){
                         $start_end_details['end_year']=$last_year;
                         }
                         }
                         if(is_array($last_manth)){
                               end($last_manth);
                          $last_manth_key = key($last_manth);
                          $last_manth_key_value=$start_end_details['end_year'].$last_manth_key;
                         if($start_end_details['end_month']<$last_manth_key_value){
                            $start_end_details['end_month']=$last_manth_key_value;
                         }else{
                              $start_end_details['end_month']=$start_end_details['end_month'];
                         }
                         }
                                  

                    for ($i_year = $start_end_details['start_year']; $i_year <= $start_end_details['end_year']; $i_year++) {
                        
                      
                          switch ($data_type) {
                              case 'anual':
                                   $php_time                        = '1-1-' . $i_year;
                                    $filled_value   = isset($All_data_key_code_value[$i_year]) ? $All_data_key_code_value[$i_year] : null;
                    $finalArray['datas'][$All_data_key_code][] = array($php_time,$filled_value);
                                  
                                   break;
                              case 'quaterly':
                                   for ($i_month = 1; $i_month <= 12; $i_month++) {
                                        if ($i_month == 3 || $i_month == 6 || $i_month == 9 || $i_month == 12) {
                                             $ky_month = sprintf("%02s", $i_month);
                                             $php_time = '1-' . $i_month . '-' . $i_year;
                                            
                                             if ($start_end_details['end_month'] >= (int) $i_year . $ky_month) {
                                                 
                                                  $filled_value                    = isset($All_data_key_code_value[$i_year][$ky_month]) ? $All_data_key_code_value[$i_year][$ky_month] : null;
                                                   $finalArray['datas'][$All_data_key_code][] = array($php_time,$filled_value);
                                             }
                                        }
                                   }
                                   break;
                              case 'monthly':
                                   
                                   for ($i_month = 1; $i_month <= 12; $i_month++) {
                                        $ky_month = sprintf("%02s", $i_month);
                                        $php_time = '1-' . $i_month . '-' . $i_year;
                                       
                                        if ($start_end_details['end_month'] >= (int) $i_year . $ky_month) {
                                             $filled_value                    = isset($All_data_key_code_value[$i_year][$ky_month]) ? $All_data_key_code_value[$i_year][$ky_month] : null;
                                             $finalArray['datas'][$All_data_key_code][] = array($php_time,$filled_value);
                                        }
                                   }
                                   break;
                              case 'daily':
                                   for ($i_month = 1; $i_month <= 12; $i_month++) {
                                        $ky_month = sprintf("%02s", $i_month);
                                        if ($start_end_details['end_year'] == $i_year && $start_end_details['end_month'] == $i_month) {
                                             $no_of_days = $end_date;
                                        } else {
                                             $no_of_days = cal_days_in_month(CAL_GREGORIAN, $ky_month, $i_year);
                                        }
                                        for ($i_date = 1; $i_date <= $no_of_days; $i_date++) {
                                             $php_time                        = $i_date . '-' . $i_month . '-' . $i_year;
                                            
                                             $ky_date                         = sprintf("%02s", $i_date);
                                             $filled_value                    = isset($All_data_key_code_value[$i_year][$ky_month][$ky_date]) ? $All_data_key_code_value[$i_year][$ky_month][$ky_date] : null;
                                            $finalArray['datas'][$All_data_key_code][] = array($php_time,$filled_value);
                                        }
                                        
                                   }
                                   break;
                              case 'yield': //veera 
                              case 'yield_daily': //veera 
                              case 'yield_monthly':
                                   foreach ($All_data_key_code_value as $key => $chart_value_row) {
                                         $finalArray['datas'][$All_data_key_code][] = array($key,$chart_value_row);
                                     
                                   }
                                   break;
                                   
                                   
                         }

                    }
                    
               }
          }
          
          
          /*echo "<pre>";print_r($finalArray);die;
          $json_result['y_value']=array();
          $json_result['y_sub_value']=array();
          $json_result['date_value']=array();*/
          
          
          
          
          
          
         
          
          if (is_array($finalArray)) {
               
               $fp = fopen(getcwd().'/storage/json_logs/' . date('Ym') . $file_name_json . '.json', 'w');
               fwrite($fp, json_encode($finalArray));
               fclose($fp);
          }
          
     }
     public function getchartData($gids, $data_type, $availableChartLabels, $all_the_gids = NULL,$cnt_graphs = NULL, $chartLayout = NULL,$extra_Para=null)
     {
          if(isset($all_the_gids['map']) && empty($extra_Para)){
               $extra_Para=$all_the_gids;
          }
          #dd($all_the_gids);
       
          $comaSeperatedGids   = $gids;
          $Memcached           = new Memcachedclass();
             //echo $tmp = implode(',', $gids).$data_type;
             // exit($tmp);
        $alanee_memcached_ky = sha1(implode(',', $gids) . $data_type).(isset($extra_Para['year_select'])?$extra_Para['year_select']:'');
          $indicator_values_m  = $Memcached->getChartData($alanee_memcached_ky);
          if ($indicator_values_m != false && count($indicator_values_m) > 0) {
               return $indicator_values_m;
          } else {
               $graphValues   = new Graphvalues();
               $results       = array();
               $markers       = array();
               $sources       = $this->getGraphSourcesForTheseGraphIds($gids);
               $isPremiumData = $this->isChartPremium($gids);  
               $response      = '';
               foreach ($gids as $gid) {
                    $y_labels = $availableChartLabels[$gid];
                    $cvalues  = explode(' - ', $y_labels);
                    $cids     = explode('-', $gid);
                    
                    
                    
                    //if(count($cids) != 2) $cids[] = 0;
                    //$charts = $db->selectQuery("select distinct y_value, y_sub_value from graph_values where gid='".$gid."' order by vid");
                    //$charts = $graphValues->getYAndYSubForThisGid($gid);
                    if (count($cvalues) >= 1) {
                         
                         //$cvalues = array($charts[$cids[1]]['y_value'], $charts[$cids[1]]['y_sub_value']);
                         //$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' and not value like '' order by year, month");
                         //$results[] = $db->selectQuery("select year, month, value from graph_values where gid='".$gid."' and y_value like '".$cvalues[0]."' and y_sub_value like '".$cvalues[1]."' order by year, month");
                         if (strpos($data_type, 'yield') !== false) {
                             if($cids[0]==304 || $cids[0]==6){
                              $day__="CONVERT(SUBSTRING_INDEX(`x_value`,' ',-1),UNSIGNED INTEGER) AS `day_`, ";
                              $day__sort=", day_ asc";
                              }else{
                                   $day__='';
                                   $day__sort='';
                              }
                              $x_value  = "$day__ `x_value` ,";
                              $order_by = "* 1 $day__sort";
                         } else {
                              $x_value  = " ";
                              $order_by = ", `month`, `date`";
                         }
                         $wherecon='';
                         if(isset($extra_Para['map'])){ 
                              $selCOL=($data_type=='daily')?"x_value":"year";
                               $x_value  = "`region` as `hc-key`,";
                               $wherecon="and $selCOL='".str_replace("-", "/", $extra_Para['year_select'])."'";
                         }
                         $qry    = str_replace('%', '\%', "select $x_value `year`, `month`, `date`, `value` from `graph_values` where `gid`='" . $cids[0] . "' and `y_value` like '" . $cvalues[0] . "' and `y_sub_value` like '" . $cvalues[1] . "' and not `value` like '' $wherecon order by `year` $order_by");
                         $result = $graphValues->getThisqueryResult($qry);
                         
                         if (!$result) {
                              $qry_sub = str_replace('%', '\%', "select $x_value `year`, `month`, `date`, `value` from `graph_values` where `gid`='" . $cids[0] . "' and `y_value` like '" . $cvalues[0] . "' and `y_sub_value` like '" . $cvalues[1] . "' $wherecon order by `year`, `month`, `date`");
                              $result  = $graphValues->getThisqueryResult($qry_sub);
                              for ($i = 0; $i < count($result); $i++)
                                   $result[$i]['value'] = 0;
                         }
                         $results[$gid] = $result;
                         //$markers[] = $cvalues;
                    }
               }
               
               
              
               $indicator_values  = array();
               $start_end_details = $this->getStartAndEndDateDetails($results);
                  # echo '<pre>';
                   #print_r($start_end_details); exit;
               $start_year        = $start_end_details['start_year'];
               $end_year          = $start_end_details['end_year'];
               $start_month       = $start_end_details['start_month'];
               $end_month         = $start_end_details['end_month'];
               $start_date        = $start_end_details['start_date'];
               $end_date          = $start_end_details['end_date'];
               if (strpos($data_type, 'yield') !== false) {
                    $start_year = 0;
                    $end_year   = 0;
               }
               $is_start_date_considered  = false;
               $is_start_month_considered = false;
               $is_start_year_considered  = false;
               
               
               $chart_formatted_array = array();
               foreach ($results as $chart_code_ky => $val_rows) {
                    $data_raw = array();
                    foreach ($val_rows as $val_row_ky =>$val_row) {  
                              if(strpos($data_type, 'yield') === false){
                              $find_Month=array_column($val_rows, 'month');
                              $find_Year=array_column($val_rows, 'year');

                              if(abs($find_Month[1]-$find_Month[0])==3){
                              $data_type='quaterly';
                              }elseif(abs($find_Month[1]-$find_Month[0])==1 || abs($find_Month[1]-$find_Month[0])==11){
                              $data_type='monthly';
                              }elseif(abs($find_Month[1]-$find_Month[0])==0 && $find_Year[1]!=$find_Year[0]){
                              $data_type='anual';
                              }elseif(abs($find_Month[1]-$find_Month[0])==0 && $find_Year[1]==$find_Year[0]){
                              $data_type='daily';
                              }else{
                              $data_type=$data_type;
                              }
                              }

                          $cids_= explode('-', $chart_code_ky);
                          $static_mix=array(163);
                          if(in_array($cids_[0], $static_mix)){
                             $data_type='monthly';  
                          }

                       if(isset($extra_Para['map'])){
                          $data_type='map_anual';
                        }
                         $val_row_year    = $val_row['year'];
                         $val_row_x_value = (strpos($data_type, 'yield') !== false) ? $val_row['x_value'] : null;
                         
                         $val_row_month = sprintf("%02s", $val_row['month']);
                         $val_row_date  = $val_row['date'];
                         $val_row_value = $val_row['value'];
                         switch ($data_type) {
                              case 'yield':
                              case 'yield_daily':
                              case 'yield_monthly':
                                    $data_raw['Data_Type'] = $data_type;
                                   $data_raw[$val_row_x_value] = $val_row_value;
                                   break;
                              case 'map_anual':
                                    $data_raw['Data_Type'] = $data_type;
                                   $data_raw[$val_row_ky] = array($val_row['hc-key'],(float) $val_row_value);
                                   break;
                              case 'anual':
                                    $data_raw['Data_Type'] = $data_type;
                                   $data_raw[$val_row_year] = $val_row_value;
                                   break;
                              case 'quaterly':
                                   $data_raw['Data_Type'] = $data_type;
                                   $data_raw[$val_row_year][$val_row_month] = $val_row_value;
                                   break;
                              case 'monthly':
                                   $data_raw['Data_Type'] = $data_type;
                                   $data_raw[$val_row_year][$val_row_month] = $val_row_value;
                                   break;
                              case 'daily':
                                $data_raw['Data_Type'] = $data_type;
                                   $data_raw[$val_row_year][$val_row_month][$val_row_date] = $val_row_value;
                                   break;
                         }
                    }
                    
                    
                    $chart_formatted_array[$chart_code_ky] = $data_raw;
               }
                   #echo '<pre>';
                  # print_r($chart_formatted_array); //exit;
               foreach ($chart_formatted_array as $chart_code => $chart_value_rows) {
                    $data_type=$chart_value_rows['Data_Type'];
                    unset($chart_value_rows['Data_Type']); 
                    $pre_val_to_fill               = null;
                    $indicator_values[$chart_code] = array();
                  /*  if(isset($extra_Para['map'])){
                         $indicator_values[$chart_code] = $chart_value_rows;
                         break;
                    }*/

                    for ($i_year = $start_year; $i_year <= $end_year; $i_year++) {
                         switch ($data_type) {
                              case 'anual':
                                   $php_time                        = '1-3-' . $i_year;
                                   $php_timestamp                   = strtotime('1-1-' . $i_year);
                                   $js_timestamp                    = ($php_timestamp * 1000);
                                   $filled_value                    = isset($chart_value_rows[$i_year]) ? $chart_value_rows[$i_year] : null;
                                   $indicator_values[$chart_code][] = array(
                                        $php_time,
                                        $filled_value
                                   );
                                   break;
                              case 'quaterly':
                              if($start_year == $i_year){ $MoStart = ($start_month==0)?"1":"$start_month"; }else{ $MoStart=1; }
                              if($end_year == $i_year){ $MoEnd = substr($end_month, -2);$MoEnd ="$MoEnd"; }else{ $MoEnd=12; }
                                   for($i_month = intval($MoStart); $i_month <= intval($MoEnd); $i_month++){
                                        if ($i_month == 3 || $i_month == 6 || $i_month == 9 || $i_month == 12) {
                                             $ky_month = sprintf("%02s", $i_month);
                                             $php_time = '1-' . $i_month . '-' . $i_year;
                                             //$php_timestamp = strtotime('1-'.$i_month.'-'.$i_year);
                                             //$js_timestamp = ($php_timestamp*1000);
                                             if ($end_month >= (int) $i_year . $ky_month) {
                                                  //$pre_val_to_fill = isset($chart_value_rows[$i_year][$ky_month]) ? $chart_value_rows[$i_year][$ky_month] : $pre_val_to_fill;
                                                  $filled_value                    = isset($chart_value_rows[$i_year][$ky_month]) ? $chart_value_rows[$i_year][$ky_month] : null;
                                                  $indicator_values[$chart_code][] = array(
                                                       $php_time,
                                                       $filled_value
                                                  );
                                             }
                                        }
                                   }
                                   break;
                              case 'monthly':
                                   if($start_year == $i_year){ $MoStart = ($start_month==0)?"1":"$start_month"; }else{ $MoStart=1; }
                              if($end_year == $i_year){ $MoEnd = substr($end_month, -2);$MoEnd ="$MoEnd"; }else{ $MoEnd=12; }
                                   for($i_month = intval($MoStart); $i_month <= intval($MoEnd); $i_month++){
                                        $ky_month = sprintf("%02s", $i_month);
                                        $php_time = '1-' . $i_month . '-' . $i_year;
                                        //$php_timestamp = strtotime('1-'.$i_month.'-'.$i_year);
                                        //$js_timestamp = ($php_timestamp*1000);
                                        //    $js_timestamp = '1-'.$i_month.'-'.$i_year;
                                        if ($end_month >= (int) $i_year . $ky_month) {
                                             $filled_value                    = isset($chart_value_rows[$i_year][$ky_month]) ? $chart_value_rows[$i_year][$ky_month] : null;
                                             $indicator_values[$chart_code][] = array(
                                                  $php_time,
                                                  $filled_value
                                             );
                                        }
                                   }
                                   break;
                              case 'daily':
                              if($start_year == $i_year){ $MoStart = ($start_month==0)?"1":"$start_month"; }else{ $MoStart=1; }
                              if($end_year == $i_year){ $MoEnd = substr($end_month, -2);$MoEnd ="$MoEnd"; }else{ $MoEnd=12; }
                                   for($i_month = intval($MoStart); $i_month <= intval($MoEnd); $i_month++){
                                        $ky_month = sprintf("%02s", $i_month);
                                        if($start_year == $i_year && $start_month == $ky_month){
                                             $DtStart = ($start_date==0)?1:$start_date;
                                        }else{
                                             $DtStart=1;
                                        }

                                        if($end_year == $i_year && $end_month == $i_year.$ky_month){
                                             $no_of_days = $end_date;
                                        }else{
                                             $no_of_days = cal_days_in_month(CAL_GREGORIAN, $ky_month, $i_year);
                                        }
                                        for ($i_date = $DtStart; $i_date <= $no_of_days; $i_date++) {
                                             $php_time                        = $i_date . '-' . $i_month . '-' . $i_year;
                                             //    echo $php_time;
                                             //    echo '<br>';
                                             //$php_timestamp = strtotime($i_date.'-'.$i_month.'-'.$i_year);
                                             //$js_timestamp = ($php_timestamp*1000);
                                             $ky_date                         = sprintf("%02s", $i_date);
                                             $filled_value                    = isset($chart_value_rows[$i_year][$ky_month][$ky_date]) ? $chart_value_rows[$i_year][$ky_month][$ky_date] : null;
                                             $indicator_values[$chart_code][] = array(
                                                  $php_time,
                                                  $filled_value
                                             );
                                        }
                                        
                                   }
                                   break;
                                    case 'map_anual':
                                     foreach ($chart_value_rows as $key => $chart_value_row) {
                                        $indicator_values[$chart_code][] = $chart_value_row;
                                   }
                                    break;
                              case 'yield': //veera 
                              case 'yield_daily': //veera 
                              case 'yield_monthly':
                              case 'map_anual':
                                   foreach ($chart_value_rows as $key => $chart_value_row) {
                                        $indicator_values[$chart_code][] = array(
                                             $key,
                                             $chart_value_row
                                        );
                                   }
                                   break;
                                   
                                   
                         }
                         
                    }
               }
        
               # && (strpos($data_type, 'yield') === false)
               /*if ($chartLayout!='narrow' && thisController() != 'home' && (strpos(url()->previous(), 'mycharts') === false) && (strpos($data_type, 'yield') === false)) {
                  
                    $filenamearray  = array_slice(explode('/', rtrim(url()->current(), "/")), -3, 3, true);
                    $file_name_json = implode('_', $filenamearray).'-'.$cnt_graphs;
                    
                    if (file_exists(getcwd().'/storage/json_logs/' . date('Ym', strtotime(' -1 month')) . $file_name_json . '.json')) {
                         unlink(getcwd().'/storage/json_logs/' . date('Ym', strtotime(' -1 month')) . $file_name_json . '.json');
                    }
                    if (!file_exists(getcwd().'/storage/json_logs/' . date('Ym') . $file_name_json . '.json')) {
                         
                         $this->getchartData_($all_the_gids, $data_type, $availableChartLabels, $sources, $isPremiumData, $start_end_details, $file_name_json,$chartLayout);
                    }
               }*/
               $response_chartData = array(
                    'sources' => $sources,
                    'isPremiumData' => $isPremiumData,
                    'data' => $indicator_values
               );
               $mem_stat           = $Memcached->setChartData($alanee_memcached_ky, $response_chartData);
               return $response_chartData;
          }
     }
     
     protected function getStartAndEndDateDetails($results)
     {

         
          $response = array(
               'start_year' => 0,
               'end_year' => 0,
               'start_month' => 0,
               'end_month' => 0,
               'start_date' => 0,
               'end_date' => 0
          );
          foreach ($results as $rw_flt_val) {
               $response['start_year']  = $response['start_year'] == 0 ? $rw_flt_val[0]['year'] : ($rw_flt_val[0]['year'] < $response['start_year'] ? $rw_flt_val[0]['year'] : $response['start_year']);
               $response['start_month'] = $response['start_month'] == 0 ? $rw_flt_val[0]['month'] : ($rw_flt_val[0]['month'] < $response['start_month'] ? $rw_flt_val[0]['month'] : $response['start_month']);
               $response['start_date']  = $response['start_date'] == 0 ? $rw_flt_val[0]['date'] : ($rw_flt_val[0]['date'] < $response['start_date'] ? $rw_flt_val[0]['date'] : $response['start_date']);
               
               $end_rw_flt_val = end($rw_flt_val);
               
               $response['end_year']  = $response['end_year'] == 0 ? $end_rw_flt_val['year'] : ($end_rw_flt_val['year'] > $response['end_year'] ? $end_rw_flt_val['year'] : $response['end_year']);
               $response['end_month'] = $response['end_month'] == 0 ? (int) $response['end_year'] . $end_rw_flt_val['month'] : ((int) $response['end_year'] . $end_rw_flt_val['month'] > $response['end_month'] ? (int) $response['end_year'] . $end_rw_flt_val['month'] : $response['end_month']);
               $response['end_date']  = $response['end_date'] == 0 ? $end_rw_flt_val['date'] : ($end_rw_flt_val['date'] > $response['end_date'] ? $end_rw_flt_val['date'] : $response['end_date']);
          }
          return $response;
     }
     
     
     public function getFilePath($gids)
     {
          $graphDetails = new Graphdetails();
          $gstr         = join(',', $gids);
          $results      = $graphDetails->getFilepathForTheseComaseperatedGids($gstr);
          $ret          = array();
          foreach ($results as $res)
               $ret[$res['gid']] = urlencode($res['filepath']);
          return $ret;
     }
     
     public function cleanMyCkEditor($value)
     {
          $value = str_replace('\r\n', "", $value);
          $value = str_replace('<p> </p>', "", $value);
          $value = str_replace('<p>&nbsp;</p>', "", $value);
          $value = str_replace('\\\&quot;', "", $value);
          $value = str_replace('\\', "", $value);
          return $value;
     }
     
     public function editorfix($value)
     {
          
          $order = array(
               "\\r\\n",
               "\\n",
               "\\r",
               "rn",
               "<p>&nbsp;</p>",
               "\\",
               "\'"
          );
          
          $replace = array(
               " ",
               " ",
               "",
               "",
               "",
               "",
               "",
               "'"
          );
          
          $value = str_replace($order, $replace, $value);
          
          return $value;
          
     }
     public function createPassword($length)
     {
          $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
          return substr(str_shuffle($chars), 0, $length);
     }
}