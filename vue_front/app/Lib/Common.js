"use strict";
class Common {
    constructor(file) {
        this.db_ = Sync_MySqlcon;
         this.db = sql;
       
    }

        makeChart($value,$isNavigator = true) {
        
    
        var $isFromUrl = false;
        var $chart_details = [];
        var $graph_default_configs_master ={
            'chartType' : 'line',
            'ViewOption' : 'chart',
            'isMultiaxis' : false,
            'isChartTypeSwitchable' : 'Y',
            'chartLayout' : 'normal',
            'isNavigator' : true,
            'chartExport' : {
                    'image_size_available' : {
                            'small' : 400,
                            'medium' : 800,
                            'large' : 1200
                    },
                    'types_available' : {
                        'jpeg' : 'image/jpeg',
                        'png' : 'image/png',
                        'pdf' : 'application/pdf'
                    }
            }
        };

 var $count = $value.match(/{(graph[_a-z]*) ((\d|,|\||-)+)({([a-zA-Z:,\"\'&quot;]*)})*}/gi); 
 if($count.length > 0) {
                for(var $cnt_graphs = 0; $cnt_graphs<$count.length; $cnt_graphs++){  
                    var $graph_default_configs = $graph_default_configs_master;  


                    // Graph Ids
                    /*graph details from URL */
                    if (typeof req !== 'undefined' && typeof req.graph_index !== 'undefined'  && $cnt_graphs == req.graph_index && $isFromUrl == false){
                        var $get_gids = $_GET['gids'];
                        var $get_graph_type = $_GET['graph_type'];
                        var $get_graph_data_from = $_GET['graph_data_from'];
                        var $get_graph_data_to = $_GET['graph_data_to'];
                        var $get_graph_index = $_GET['graph_index'];
                        var $isFromUrl = true;
                    }else{
                        var $get_gids = null;
                        var $get_graph_type = null;
                        var $get_graph_data_from = null;
                        var $get_graph_data_to =null;
                        var $get_graph_index = null;
                    }
                    var main = ($count[$cnt_graphs]).replace(/'{ |}|{|(graph[_a-z]*)| }|\s/gi, function (x) {
                    return '';
                    });
                   
                    var $main = (main).split('|'); 
                    var $gids =[];
                    var $GIDS = $get_gids !=null ? $get_gids.split('|') : $main[0].split(',');
                    var $GID = $GIDS[0]; 
                    var $gid = $GID.split('-');
                    var $gid = $gid[0];
                    var $gids = [];

                    if($main[1]!== 'undefined' && $main[1]!='')
                    {  
                        var $NGIDS = ($main[1]).split(',');
                         $NGIDS.forEach(function(element,index){ 
                       
                         var $nid = element.split('-');
                           var  $nid = $nid[0];
                            if($gids.includes($nid)) return;
                            $gids.push($nid);
                           // var $gids[item] = $nid;
                       });
                    }
                  
                    var $gids2 =[]; //console.log($GIDS);
                     $GIDS.forEach(function(item){ 
                   
                        var $nid = item.split('-');
                        var $nid = $nid[0];
                        if($gids.includes($nid)) return;
                            $gids2.push($nid);
                   });


                    // All available graph ids
                    var $gids = $gids.concat($gids2); //Object.assign($gids2, $gids); 
                    // GraphId to plot
                    var $gid_to_plot = $main[0];    
                    // Date range
                    var $dateRange_arr = ($main[2]).split(',');
                    // Data - Date From
                    var $dateinfo_from = ($dateRange_arr[0]).split('-');
                    // Data Date To
                    var $dateinfo_to = ($dateRange_arr[1]).split('-');
                    
                    //Graph configurations
                    var $dateRange_from,$dateRange_to;
                    var $data_period_type = 'monthly';
                    var $DataPeriodTtype = ($count[$cnt_graphs]).match(/(graph[_a-z]*)/gi);
                    switch ($DataPeriodTtype){
                        case 'graph':
                            $data_period_type = 'monthly';
                            $dateRange_from = '1-'+$dateinfo_from[1]+'-'+$dateinfo_from[0];
                            $dateRange_to = '1-'+$dateinfo_to[1]+'-'+$dateinfo_to[0];
                            break;
                        case 'graph_narrow':
                            $data_period_type = 'monthly';
                            $dateRange_from = '1-'+$dateinfo_from[1]+'-'+$dateinfo_from[0];
                            $dateRange_to = '1-'+$dateinfo_to[1]+'-'+$dateinfo_to[0];
                            $graph_default_configs['chartLayout'] = 'narrow';
                            break;
                        case 'graph_anual':
                            $data_period_type = 'anual';
                            $dateRange_from = '1-1-'+$dateinfo_from[0];
                            $dateRange_to = '1-1-'+$dateinfo_to[0];
                            break;
                        case 'graph_daily':
                            $data_period_type = 'daily';
                            $dateRange_from = $dateinfo_from[2]+'-'.$dateinfo_from[1]+'-'+$dateinfo_from[0];
                            $dateRange_to = $dateinfo_to[2]+'-'+$dateinfo_to[1]+'-'+$dateinfo_to[0];
                            break;
                        case 'graph_quaterly':
                            $data_period_type = 'quaterly';
                            $dateRange_from = '1-'+$dateinfo_from[1]+'-'+$dateinfo_from[0];
                            $dateRange_to = '1-'+$dateinfo_to[1]+'-'+$dateinfo_to[0];
                            break;                          
                    }
                    var $graph_configurations = $graph_default_configs;
                    $graph_configurations['dataType'] = $data_period_type;
                    if($graph_configurations['isMultiaxis'] == true){
                        $graph_configurations['chartType'] = 'multiaxisline';
                    }
                    if($get_graph_type!=null){
                        $graph_configurations['chartType'] = $get_graph_type;
                    }
                    // Get available chart names
                    var $availableCharts = this.makeChartOptions($gids);
                    //$isPremiumData = $this->isChartPremium($gids);
                    // Get all chart fields
                    var $chartSelectValues = this.makeChartSelect($gids);
                    
                    var $availableChartFields = $chartSelectValues['options'];
                    // Available Labels
                    var $availableChartLabels = $chartSelectValues['labels'];
                    // Get Chart data
                     console.log($graph_configurations);
                }
            }

    }

   makeChartOptions($gids)
    {
        $graphDetails = new Graphdetails();
        $gstr = $gids.join(',');
        $names = $graphDetails->getGraphDetailsForTheseComaseperatedGids($gstr);
        $chart_names = [];
        if($names)
        {
            foreach($names as $name)
            $c_names[$name['gid']] = $name['title'];
            for($i = 0; $i < count($gids); $i++)
            $chart_names[$gids[$i]] = $c_names[$gids[$i]];
        }

        return $chart_names;
    }
   makeChartSelect($gids) {
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

       isChartPremium($gids){
        $gstr = join(',', $gids);
        $graphDetails = new Graphdetails();
        return $graphDetails->checkIsPremiumForTheseComaseperatedGids($gstr);
    }
   

    getLatestMediaAsNotice(limit,callback) {
        var qry='SELECT * FROM `media` where `media_notice`=1 order by `media_sort` asc, `media_date` desc limit 0,'+limit;
        return this.db.query(qry, function(err,rows){
            callback(err,rows)
        })
    }
    getLatestMedia(limit,callback) {
         var qry='SELECT * FROM `media` where `media_notice` =0 order by `media_sort` asc, `media_date` desc limit 0,'+limit;
        return this.db.query(qry, 
            function(err,rows){
            callback(err,rows)
        })
    }

   
}

module.exports = Common
