<?php
function curPageName() {
	return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
function cleanInputArray($arrRecord){
	$inputArray = array();
	foreach ($arrRecord as $fieldName => $fieldValue) {
		if (is_string($fieldValue))
			$inputArray[$fieldName] = cleanInputField($fieldValue);
		else
			$inputArray[$fieldName] = $fieldValue;
	}
	return $inputArray;
}
function cleanInputField($value){
	$db	     = new mysql();
	$db->open();
	$value = mysql_real_escape_string($value);
        $db->close();
	return $value;	
}

function getFilePath($gids)
{
	
	global $db;
	$gstr = join(',', $gids);
	$results = $db->selectQuery("select gid, filepath from graph_details where gid in ($gstr)");
	$ret = array();
	foreach($results as $res)
		$ret[$res['gid']] = urlencode($res['filepath']);
		return $ret;
}

function makeChartOptions($gids)
{
	global $db;
	$gstr = join(',', $gids);
	$names = $db->selectQuery("select gid, title from graph_details where gid in ($gstr)");
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

function makeChartSelect($gids)
{
	global $db;

$options = array();
foreach($gids as $gid)
{
	//$charts = $db->selectQuery("select distinct y_value, y_sub_value from graph_values where gid='".$gid."' order by vid");
	$charts = $db->selectQuery("SELECT y_value, y_sub_value, min(vid) FROM graph_values where gid = '".$gid."' GROUP BY y_value, y_sub_value order by min(vid)");
	if($charts)
	{
		$has_sub = false;
		if($charts[0]['y_sub_value']) $has_sub = true;

		$options[$gid] = array();
		$i = 0;
		foreach($charts as $chart)
		{
			$value = $chart['y_value'];
			$svalue = $chart['y_sub_value'];
			
			if(!array_key_exists($value, $options[$gid]))
			{
				if($has_sub)
					$options[$gid][$value] = array();
				else
					$options[$gid][$value] = $gid."-".$i;
			}

			if($has_sub)
			{
					$options[$gid][$value][$svalue] = $gid."-".$i;
			}
			$i++;
		}
	}
}

return $options;
//return "options = ".json_encode($options)."; chart_names = ".json_encode($chart_names).";";

}


function makeChart($value){
	//echo $value;exit();
	
	if($count = preg_match_all('/{graph ((\d|,|\||-)+)}/', $value, $matches))
	{
		$script = "
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script type='text/javascript' src='http://www.phpied.com/files/rgbcolor/rgbcolor.js'></script>
<script type='text/javascript' src='https://canvg.googlecode.com/svn-history/r152/trunk/canvg.js'></script>

<script type='text/javascript'>
var options = [];
var chart_names = [];
var chart_files = [];

var startd = [];
var endd = [];

var dashboard = [];
var range = [];
var chart = [];
</script>
";

$script_end = "
<script type='text/javascript'>

	$('.graph').on('change', '.chart-select', function(){
		var arr = new Array();
		var index = $(this).parents('.graph').attr('id').split('_')[1];

		$('#graph_'+index+' .chart-select').each(function(){
			arr.push($(this).val());	
		});

		changeShare(index);
		
		$.getJSON('getchart.php', {gid: arr.join('|')}, function(data){
			 alert(data);
			var dt = new google.visualization.DataTable();
            dt.addColumn('date', data[0][0]);
            for(var i = 1; i < data[0].length; i++)
                dt.addColumn('number', data[0][i]);
            dt.addRows(data.length - 1);
            for(var i = 1; i < data.length; i++)
            {
                var somedate = data[i][0].split('/');
				if(i == 1) startd[index] = new Date(somedate[0], somedate[1]-1);
				if(i == data.length - 1) endd[index] = new Date(somedate[0], somedate[1]-1);
                dt.setCell(i-1, 0, new Date(somedate[0], somedate[1]-1), data[i][0]);
                for(var j = 1; j < data[0].length; j++)
                    dt.setCell(i-1, j, data[i][j]);
            }
            dashboard[index].draw(dt);
			var state = range[index].getState();
			if(!state.range)
			{
				range[index].setState({range:{start: startd[index], end: endd[index]}});
				range[index].draw();
			}
				
    	});
	});

	$('.addmore-button').click(function() {

		var index = $(this).parents('.graph').attr('id').split('_')[1];
		createSelect($('#graph_'+index+' .addmore-select').val(), index);

		$('#graph_'+index+' .graph-line:first-child select.chart-select').change();

	});
	$('.graph').on('click', '.graph-remove', function() {
		var index = $(this).parents('.graph').attr('id').split('_')[1];
		$(this).parents('.graph-line').remove();
		$('#graph_'+index+' .graph-list .graph-line:first-child select.chart-select').change();
		$('#graph_'+index+' .graph-addmore').css('display', 'block');
	});

	$('.graph .graph-export').click(function(){
		var index = $(this).parents('.graph').attr('id').split('_')[1];
		var chartContainer = document.getElementById('chart_'+index);
		var chartArea = chartContainer.children[0];
		var svg = chartArea.innerHTML.substring(chartArea.innerHTML.indexOf('<svg'), chartArea.innerHTML.indexOf('</svg>') + 6);
		//svg = svg.replace(/&nbsp;/g,' ');
		var canvas = document.createElement('canvas');
		canvas.setAttribute('width', chartArea.offsetWidth);
		canvas.setAttribute('height', chartArea.offsetHeight);
		canvas.setAttribute('style',
			'position: absolute; ' +
			'top: ' + (-chartArea.offsetHeight * 2) + 'px;' +
			' left: ' + (-chartArea.offsetWidth * 2) + 'px;');
		document.body.appendChild(canvas);
		canvg(canvas, svg);
		var imgData = canvas.toDataURL('image/png');
		
		var field = document.getElementById('graph-hidden');
		field.value = imgData;
		document.forms['getimage'].submit();	

		// Populate img tag
		//var img = document.createElement('img');
		//img.src = imgData;
		//document.body.appendChild(img);
		//window.location = imgData.replace('image/png', 'image/octet-stream');

	});

    function changeShare(index)
	{
		var arr = new Array();
		$('#graph_'+index+' .chart-select').each(function(){
			arr.push($(this).val());	
		});
		var params = arr.join('|');
		var s = window.location.search.replace('?', '').split('&');
		var gets = {}
		for(var i = 0; i < s.length; i++)
			gets[s[i].split('=')[0]] = s[i].split('=')[1];			
		var page = '';
		if(gets['cat_id'])
			page += 'cat_id=' + gets['cat_id'] + '&';
		if(gets['id'])
			page += 'id=' + gets['id'] + '&';

		state = range[index].getState();
		var date_filter = '';
		if(state.range)
		{
			date_filter += '&date=' + 
					state.range.start.getFullYear() + '-' +
					state.range.start.getMonth() + '|' +	
					state.range.end.getFullYear() + '-' +
					state.range.end.getMonth()
		}

		var url = window.location.protocol + '//' + window.location.host + window.location.pathname + '?' + page + 'gid=' + params + date_filter  + '&index=' + index;
		var link = 'mailto:?subject=Japan Macro Advisors Graph&body=Personal Message:%0APlease check the chart and its very useful!%0A%0A'+encodeURIComponent(url)+'%0A%0A%0A............................................................................................................%0AIf you are unable to click on the link above, please copy and paste the URL below into a web browser%0A'+encodeURIComponent(url);
		$(this).attr('href', link);
		$('#graph_'+index+' .graph-share').attr('href', link);
	}

	$('.graph .graph-share').click(function(){

	});

	$('.graph-print').click(function(){
		var index = $(this).parents('.graph').attr('id').split('_')[1];
		$('.graph').removeClass('printme');
		$('#graph_'+index).addClass('printme');


		window.print();
	});

	$('.graph .graph-range a').click(function(){
		var index = $(this).parents('.graph').attr('id').split('_')[1];

		var state = range[index].getState();
		var from_date = state.range.start;
		var to_date = state.range.end;
		if($(this).text() == '1 year')
			new_date = new Date(to_date.getFullYear() - 1, to_date.getMonth());
		if($(this).text() == '2 year')
			new_date = new Date(to_date.getFullYear() - 2, to_date.getMonth());
		if($(this).text() == '5 year')
			new_date = new Date(to_date.getFullYear() - 5, to_date.getMonth());
		if($(this).text() == '10 year')
			new_date = new Date(to_date.getFullYear() - 10, to_date.getMonth());
		if($(this).text() == '20 year')
			new_date = new Date(to_date.getFullYear() - 20, to_date.getMonth());
		if($(this).text() == '40 year')
			new_date = new Date(to_date.getFullYear() - 40, to_date.getMonth());

		if(new_date > startd[index])
		{
			range[index].setState({range:{start:new_date, end: to_date}});
		}
		else
			range[index].setState({range:{start:startd[index], end: to_date}});

		range[index].draw();
		changeShare(index);
	});

google.load('visualization', '1', {packages:['controls']});
google.setOnLoadCallback(drawChart);
$('head').append('<link rel=\"stylesheet\" href=\"css/print.css\" type=\"text/css\" media=\"print\" />');


</script>
<form id='getimage' action='getimage.php' method='post'><input id='graph-hidden' name='data' type='hidden' /></form>

";

		$script_draw = "
<script type='text/javascript'>
function drawChart() { ";

		
		for($index = 0; $index < $count; $index++)
		{

		$main = explode('|', $matches[1][$index]);
		$GIDS = explode(',', $main[0]);
		$GID = $GIDS[0];
		
		$gid = explode('-', $GID);
		$gid = $gid[0];
		//echo $gid;exit();
		

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

		$gids = array_merge($gids2, $gids);

		$sgids = array();
		
		$createselect = '';
		if(isset($_GET['gid']) && isset($_GET['index']) && $_GET['index'] == $index)
			$sgids = explode('|', $_GET['gid']);

		if(isset($sgids[0]))
			$createselect  = "createSelect('".$sgids[0]."', '".$index."');";
		else
			$createselect  = "createSelect('".$GID."', '".$index."');";

		if(isset($sgids[1]))
			$createselect  .= "createSelect('".$sgids[1]."', '".$index."');";
		else if(isset($GIDS[1]))
			$createselect  .= "createSelect('".$GIDS[1]."', '".$index."');";
		if(isset($sgids[2]))
			$createselect  .= "createSelect('".$sgids[2]."', '".$index."');";
		else if(isset($GIDS[2]))
			$createselect  .= "createSelect('".$GIDS[2]."', '".$index."');";

		$date_state = '';
		if(isset($_GET['date']) && isset($_GET['index']) && $_GET['index'] == $index)
		{
			$dates = explode('|', $_GET['date']);
			$from = explode('-', $dates[0]);
			$to = explode('-', $dates[1]);
			
			$date_state = "state: { range: { 
							start: new Date(".$from[0].",".$from[1]."),
							end: new Date(".$to[0].",".$to[1]."),
						  }},";
		}
		else if(isset($main[2]) and !empty($main[2]))
		{
			$dates = explode(',', $main[2]);
			$from = explode('-', $dates[0]);
			$to = explode('-', $dates[1]);
			
			$date_state = "state: { range: { 
							start: new Date(".$from[0].",".$from[1]."),
							end: new Date(".$to[0].",".$to[1]."),
						  }},";
		}

		$select = makeChartSelect($gids);
		$options = makeChartOptions($gids);
		$selection = "<select class='addmore-select' id='addmore-select_$index'>";
		foreach($options as $fkey => $fvalue)
		{
				$selected = '';
				if($fkey == $gid) $selected = " selected='selected'";
				$selection .= "<option value='$fkey' $selected>".$fvalue."</option>";
		}
		$selection .= "</select>";
$script_vars = "
<script type='text/javascript'>

options[$index] = ".json_encode($select).";
chart_names[$index] = ".json_encode($options).";
chart_files[$index] = ".json_encode(getFilePath($gids)).";
</script>";


		$script_draw .= "

	dashboard[$index] = new google.visualization.Dashboard(
             document.getElementById('dashboard_$index'));

	range[$index] = new google.visualization.ControlWrapper({
		$date_state
   		'controlType': 'ChartRangeFilter',
       	'containerId': 'filter_$index',
       	'options': {
        	'filterColumnLabel': 'Year/Month',
			'ui': {
    			//'chartType': 'ComboChart',
    			'chartOptions': {
					'backgroundColor': '#fbfbfb',
					'hAxis': {/*gridlines: {color:'#fbfbfb'},*/ textPosition:'out', format:'y', baselineColor: '#fbfbfb'},
					'chartArea':{height:35},
    			},
			}
       	}
	});
	
	google.visualization.events.addListener(range[$index], 'statechange', changeHandler$index);
	function changeHandler$index(e){
		changeShare($index);
	};
	
	chart[$index] = new google.visualization.ChartWrapper({
    	'chartType': 'LineChart',
       	'containerId': 'chart_$index',
       	'options': {
			'title': '".strtoupper($options[$gid])."',
			'titlePosition': 'out',
			'titleTextStyle': {color: '#202020', fontSize: 14},
       		'width': 578,
           	'height': 267,
			'backgroundColor': '#fbfbfb',
			//'chartArea': {left:50, top: 60, width:488, height:152},
			'chartArea': {left:50, top: 50, width:393, height:187},
			'focusTarget': 'category',
			'fontSize': 10,
			'hAxis': {format:'y/MM'},
			//'legend': {position: 'right', alignment: 'center'},
			'legend': {position: 'right', alignment: 'center'},
			
		}
	});
	
	dashboard[$index].bind(range[$index], chart[$index]);

	$createselect

";
//echo print_r($gids);exit();
	
	$script_html = "
<div class='graph' id='graph_$index'>
<div class='graph-left'>
<div id='dashboard_$index'>
	<div id='chart_$index'></div>
	<div class='graph-filter' id='filter_$index'></div>
</div>
<div class='graph-range'>
  <a>1 year</a><a>2 year</a>
  <a>5 year</a><a>10 year</a><a>20 year</a><a>40 year</a>
</div>
</div>
<div class='graph-right'>
<div class='graph-list'></div>
<div class='graph-addmore'>
<span class='addmore'>Add More Series</span>
<div>Only ".count($options)." items listed below</div>
$selection
<div><a class='addmore-button'>Add more</a></div>
</div>
<div class='graph-control'>
<a class='graph-export'>Export</a> &nbsp; 
<a  class='graph-download' href='downloadxls.php?download_file=".urlencode(implode(",",getFilePath($gids)))."'>Download</a> &nbsp; 
<a class='graph-share' target='_blank'>Share</a> &nbsp; 
<a class='graph-print'></a>
</div>
</div>
</div>
";
		

			$script_united = $script_vars . $script_html;
			if($index == $count - 1) $script_united .= $script_draw . "
	$('.graph-line:first-child select.chart-select').change();
}</script>" . $script_end;
			if($index == 0) $script_united = $script . $script_united;
		
			$value = preg_replace('/'.preg_quote($matches[0][$index]).'/', $script_united, $value);	
			
		}
	}
    //return "<textarea style='width:600px; height: 800px;'>".$value."</textarea>";
    return $value;
}

function cleanMyCkEditor($value){
	//echo $value;exit();
    $value = str_replace('\r\n', "", $value);
    $value = str_replace('<p> </p>', "", $value);
    $value = str_replace('<p>&nbsp;</p>', "", $value);
    $value = str_replace('\\\&quot;', "", $value);
    $value = str_replace('\\', "", $value);
    return $value;
}
function checkUploadedImagesAreCorrectOrNot($totalFiles,$allowedimagetype)
{
	$errorReturn = 0;
	for($f=1;$f<=$totalFiles;$f++){
		if(isset($_FILES['file_'.$f]['name'])){ 
			if($_FILES['file_'.$f]['name']){
				$imageName = $_FILES['file_'.$f]['name'];
				$imgExp    = explode('.', $imageName);
				$imageType = end($imgExp);						
				if(($imageName =='')||(!in_array($imageType, $allowedimagetype))) {
					$errorReturn = 1;	
				}
			}
		}
	}
	return $errorReturn;
}

function clearTextArea($ticketDetails){
	$ticketDetails = str_replace('\n', "<br>", $ticketDetails);
	$ticketDetails = str_replace('\r', " ", $ticketDetails);
	$ticketDetails = stripslashes($ticketDetails);
	$ticketDetails = stripslashes($ticketDetails);
	$ticketDetails = stripslashes($ticketDetails);
	return $ticketDetails;
}

function check_email($email) {
        if (preg_match("/^(\w+((-\w+)|(\w.\w+))*)\@(\w+((\.|-)\w+)*\.\w+$)/",$email)){
        return true;
        }
        else {
        return false;
        }
}

 function getHowLongAgo($date, $display = array('year', 'month', 'day', 'hour', 'minute', 'second'), $ago = 'ago')
{
    $date = getdate(strtotime($date));
    $current = getdate();
    $p = array('year', 'mon', 'mday', 'hours', 'minutes', 'seconds');
    $factor = array(0, 12, 30, 24, 60, 60);

    for ($i = 0; $i < 6; $i++) {
        if ($i > 0) {
            $current[$p[$i]] += $current[$p[$i - 1]] * $factor[$i];
            $date[$p[$i]] += $date[$p[$i - 1]] * $factor[$i];
        }
        if ($current[$p[$i]] - $date[$p[$i]] > 1) {
            $value = $current[$p[$i]] - $date[$p[$i]];
            return $value . ' ' . $display[$i] . (($value != 1) ? 's' : '') . ' ' . $ago;
        }
    }

    return '';
}

function thumbnailCreation($sourceDirectory,$destinationDirectory,$fileName,$width,$height){
    
             /* Opening the thumbnail directory and looping through all the thumbs: */
            $dir_handle = @opendir($sourceDirectory); //Open Full image dirrectory
            if ($dir_handle > 1){ //Check to make sure the folder opened
            $allowed_types=array('jpg','jpeg','gif','png');
            $file_parts=array();
            $ext='';
            $title='';
            $i=0;

            $file = $fileName;
            
                /* Skipping the system files: */
                if($file=='.' || $file == '..') continue;

                $file_parts = explode('.',$file);    //This gets the file name of the images
                $ext = strtolower(array_pop($file_parts));

                /* Using the file name (withouth the extension) as a image title: */
                $title = implode('.',$file_parts);
                $title = htmlspecialchars($title);

                /* If the file extension is allowed: */
                if(in_array($ext,$allowed_types))
                {

                    /* If you would like to inpute images into a database, do your mysql query here */

                    /* The code past here is the code at the start of the tutorial */
                    /* Outputting each image: */

                    $nw = 150;
                    $nh = 100;
                    
                    $source = "$sourceDirectory{$file}";
                    $stype = explode(".", $source);
                    $stype = $stype[count($stype)-1];
                    $dest  = "$destinationDirectory{$file}";

                    $size = getimagesize($source);
                    $w = $size[0];
                    $h = $size[1];

                    switch($stype) {
                        case 'gif':
                            $simg = imagecreatefromgif($source);
                            break;
                        case 'jpg':
                            $simg = imagecreatefromjpeg($source);
                            break;
                        case 'png':
                            $simg = imagecreatefrompng($source);
                            break;
                    }

                    $dimg = imagecreatetruecolor($nw, $nh);
                    $wm = $w/$nw;
                    $hm = $h/$nh;
                    $h_height = $nh/2;
                    $w_height = $nw/2;

                    if($w> $h) {
                        $adjusted_width = $w / $hm;
                        $half_width = $adjusted_width / 2;
                        $int_width = $half_width - $w_height;
                        imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
                    } elseif(($w <$h) || ($w == $h)) {
                        $adjusted_height = $h / $wm;
                        $half_height = $adjusted_height / 2;
                        $int_height = $half_height - $h_height;

                        imagecopyresampled($dimg,$simg,0,-$int_height,0,0,$nw,$adjusted_height,$w,$h);
                    } else {
                        imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);
                    }
                        imagejpeg($dimg,$dest,100);
                    }
            

            /* Closing the directory */
            @closedir($dir_handle);

            }
}

function deleteImage($original,$thumb,$fileName){
    
    $original = $original.$fileName;
    $thumb    = $thumb.$fileName;
    
    if(file_exists($original)){
        unlink($original);
    }
    
    if(file_exists($thumb)){
        unlink($thumb);
    }
}

