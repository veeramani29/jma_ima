<?php
ini_set('max_execution_time', 999999);
set_time_limit(0);
ini_set("memory_limit",-1);

 
class pointLocation {
    var $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?
 
    function pointLocation() {
    }
 
    function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;
 
        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array(); 
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }
 
        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {

            return "vertex";
        }
 
        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);
        /*echo "<pre>";
        print_r($point);
          echo "<pre>";
        print_r($vertices);*/
       /* for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];*/
      
           # echo "<pre>";
     #  print_r($vertex1);
         #   echo "<pre>";
       # print_r($vertex2);#die;
           /* if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                  echo "<pre>";
                  print_r($i);
                return "boundary";
            }*/
            if ($point['y'] > min(array_column($vertices, 'y')) and $point['y'] <= max(array_column($vertices, 'y')) and $point['x'] <= max(array_column($vertices, 'x')) ) { 
                 echo "<pre>";
                  print_r($point);
               # $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
               /* if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                     echo "<pre>";
                     print_r($i);
                    return "Boundary";
                }*/
               /* if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }*/
            } 
      #  } 
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }
 
    function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
 
    }
 
    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }
 
}

$pointLocation = new pointLocation();
$points = array("50 70","70 40","-20 30","100 10","-10 -10","40 -20","110 -20");
$polygon = array("-50 30","50 70","100 50","80 10","110 -10","110 -30","-20 -50","-30 -40","10 -10","-10 10","-30 -20","-50 30");
// The last point's coordinates must be the same as the first one's, to "close the loop"
foreach($points as $key => $point) {
    echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon) . "<br>";
}





die;
require_once('Xml_to_array.php');

$a=new Xml_to_array();
$temp = file_get_contents('LowFareSearchReq.xml');
$b=$a->XmlToArray($temp);
if($b['ResponseMessage']=='Success'){
	$c=$b['Cruises']['CruiseIndex'];
	foreach ($c as $i => $v) {
    unset($v['Itinerary']);
    #unset($v['DoubleOccupancyFares']);
    #unset($v['SingleOccupancyFares']);
    if(isset($v['DoubleOccupancyFares']) && !empty($v['DoubleOccupancyFares'])){
    	$DoubleOccupancyFares=$v['DoubleOccupancyFares'];
    	if(isset($DoubleOccupancyFares['@attributes']) && !empty($DoubleOccupancyFares['@attributes'])){
    	 $DoubleOccupancyCategory=$DoubleOccupancyFares['@attributes'];
    	 $v['DoubleOccupancyCategory']=$DoubleOccupancyFares['@attributes'];
        }
        if(isset($DoubleOccupancyFares['PriceList']['Price']) && !empty($DoubleOccupancyFares['PriceList']['Price'])){
        	 $DoubleOccupancyPriceList=$DoubleOccupancyFares['PriceList']['Price'];
        	  $v['DoubleOccupancyPriceList']=$DoubleOccupancyFares['PriceList']['Price'];
        }
    }

    if(isset($v['SingleOccupancyFares']) && !empty($v['SingleOccupancyFares'])){
    	$SingleOccupancyFares=$v['SingleOccupancyFares'];
    	if(isset($SingleOccupancyFares['@attributes']) && !empty($SingleOccupancyFares['@attributes'])){
    	 $SingleOccupancyCategory=$SingleOccupancyFares['@attributes'];
    	  $v['SingleOccupancyCategory']=$SingleOccupancyFares['@attributes'];
        }
        if(isset($SingleOccupancyFares['PriceList']['Price']) && !empty($SingleOccupancyFares['PriceList']['Price'])){
        	 $SingleOccupancyPriceList=$SingleOccupancyFares['PriceList']['Price'];
        	   $v['SingleOccupancyPriceList']=$SingleOccupancyFares['PriceList']['Price'];
        }
    }
		echo "<pre>";
       print_r($v);
	}
}


?>