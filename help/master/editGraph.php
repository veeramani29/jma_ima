<?php include('header.php');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
extension_loaded('zip');
ini_set('memory_limit', '3000M');
?>



<script language="javascript">
    $(document).ready(function() {
        $('#add_graph').submit(function() {
            var ret = true;
			$('#graph_source_error').html('');
			$('#graph_title_error').html('');
			$('#graph_txt_error').html('');
			$('#graph_File_error').html('');
			$('#updated_page').html('');
			var Gsource       =  $('#graph_source').val();
            var title         =   $('#graph_title').val();
            var editorcontent = CKEDITOR.instances['graph_txt'].getData().replace(/<[^>]*>/gi, '');
            var gFile         =   $('#graph_File').val(); 
            var updated_page         =   $('#updated_page').val(); 
            
			if(Gsource == ''){
                $('#graph_source_error').html('Please enter Graph source.');
                ret =  false;
            }
            
            if(title == ''){
                $('#graph_title_error').html('Please enter Title.');
                ret =  false;
            }
            if(updated_page == ''){
                 $('#updated_page_error').html('Please enter updated page.');
                ret =  false;
            }
             if(editorcontent.length){}
            else{
                $('#graph_txt_error').html('Please enter Description.');
                ret =  false;
            }
			
			 if(gFile != '' && checkFile(gFile) == false){
                $('#graph_File_error').html('Please upload a valid file.');
                ret =  false;
            }
            
             
            return ret;
     });
    });
	
	function checkFile(filePath) {
    var pathLength  = filePath.length;
    var lastDot     = filePath.lastIndexOf(".");
    var fileType    = filePath.substring(lastDot,pathLength);
   if((fileType == ".xls")) //|| (fileType == ".xlsx")  || (fileType == ".csv")
   {
    return true;
    } else {
    return false;
    }
    }  
    
</script>

<?php
function changeFileName($name)
{
$characters= array("<", ">", ":", '"', "/", "\\", "|", "?", "*","%"," ");
$new = str_replace($characters, "_", $name); 
return $new;
}
function detectDelimiter($filename) {
    $handle = fopen($filename, "r");
    if ($handle) {
        $line=fgets($handle, 4096);
        fclose($handle);            

        $test=explode(',', $line);
        if (count($test)>1) $delimiter= ',';

        $test=explode(';', $line);
        if (count($test)>1) $delimiter= ';';
		
	    $test=explode('	', $line);
			if (count($test)>1) $delimiter= '	';
		
		$test=explode('|', $line);
        if (count($test)>1) $delimiter= '|';
        
    }
    //return default delimiter
    return $delimiter;
}
function editorfix($value)
{
// sometimes FCKeditor wants to add \r\n, so replace it with a space 
// sometimes FCKeditor wants to add <p>&nbsp;</p>, so replace it with nothing

$order   = array("\\r\\n", "\\n", "\\r", "rn","<p>&nbsp;</p>");
$replace = array(" ", " ", "", "","","");
$value = str_replace($order, $replace, $value); 
return $value;
}
function getCol($matrix, $col)
	{
	$column =array();
	for( $i=0; $i<=count($matrix); $i++)
	{
	if($i!=0)
	{
	if(!$matrix[$i][$col])
	{
	$matrix[$i][$col]=0;
	}
	//if($col!=1){$column[]=floatval($matrix[$i][$col]);}else{ $column[]=$matrix[$i][$col];}
	if($col!=1){if($matrix[$i][$col]!=""){$column[]=floatval($matrix[$i][$col]);}else{$column[]="";}}else{ $column[]=$matrix[$i][$col];}
	}
	}
	return $column;
	}
		$id=$_REQUEST['id'];
		$condition="gid = '$id'";
		$getGraphArr = $chartObj->getGraphList($condition); //print_r($getGraphArr);
		$source=$getGraphArr[0]['source'];
		$title=$getGraphArr[0]['title'];
		$description =stripslashes($getGraphArr[0]['description']);
		$isPremium = $getGraphArr[0]['isPremium'];
		$isMap = $getGraphArr[0]['type'];
		$xlFile =$filepath =$getGraphArr[0]['filepath'];
	 	$updated_page = $getGraphArr[0]['updated_page'];
		$errorMsg = '';
		if(isset($_POST['addGraph'])){ 
			
		
		if($_POST['addGraph']){
		$graphSource = trim($_POST['graph_source']); 
		$graphTitle	 = trim($_POST['graph_title']);	
		$graphTxt    = addslashes(editorfix($_POST['graph_txt']));
		$updated_page = $_POST['updated_page'];
		$graphIsPremium = (trim($_POST['isPremium']) == '' ? 'n' : 'y');
		 $isMap = (trim($_POST['isMap']) == '' ? 'Graph' : 'Map');
		
		if($graphSource == ''|| $graphTxt == '' || $graphTitle == ''){
		$errorMsg ='Please enter all mandatory field<br/>';
		}
		else{  
		//File upload
		$file2Uploaded =0;  
		//$doc_time=date('dmY').date('His');
		//$doc_path1 = '';
		
		if($_FILES['graph_File']['name'] != ''){                       
		$xlFile = changeFileName($_FILES['graph_File']['name']);
		$fileSize  = $_FILES["graph_File"]["size"];
		$ext='.';
		$ext=  explode('.',$_FILES['graph_File']['name']);
		$ext =  end($ext);
		$ext = '.'.$ext;
		 $file_ext = array(".xls", ".xlsx", ".csv");
		//$doc_path1=$doc_time.$ext;
		 if(!in_array($ext, $file_ext)){// && $ext!='.csv'
		$errorMsg = 'File must be xls';
		}
		else{
		if(file_exists('../public/uploads/xls/'.$xlFile))
			{
				$extArr=  explode('.',$_FILES['graph_File']['name']);
			    $xlFile=$extArr[0].date('dmyhis').$ext;
			}
		if(move_uploaded_file($_FILES['graph_File']['tmp_name'],'../public/uploads/xls/'.$xlFile))
		{   
		$file2Uploaded = 1;
		}
		// edit excel file values --start
	    if($file2Uploaded == 1){
		$chartObj->deletegraph_values($id);							
		$sheetno=0;
		/*include 'reader.php';
		$excel = new Spreadsheet_Excel_Reader();
		$dataArray1=array();$dataArray2=array();
		$excel->read('../public/uploads/xls/'.$xlFile); // set the excel file name here   
		$x=1;
		while($x<=$excel->sheets[$sheetno]['numRows']) 
		{ // reading row by row 
		$y=1;
		while($y<=$excel->sheets[$sheetno]['numCols']) 
		{// reading column by column 
		$cell = isset($excel->sheets[$sheetno]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
		$dataArray1[$x][$y]=$cell;
		$y++;
		}
		$x++;
		}*/
		/** Include path **/
		$inputFileName ='../public/uploads/xls/'.$xlFile;
if($ext=='.xls' || $ext=='.xlsx')
{
//set_include_path(get_include_path() . PATH_SEPARATOR . 'voucherImport/Classes/');

include 'voucherImport/Classes/PHPExcel/IOFactory.php';

//$inputFileName ='../public/uploads/xls/'.$xlFile;
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
PHPExcel_Settings::setZipClass(PHPExcel_Settings::ZIPARCHIVE);

	$dataArray1=array();$dataArray2=array();
//$dataArray1[] = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
####################################
$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
	//foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				//echo '- ' . $worksheet->getTitle() . "\r\n";
			$x=1;
				foreach ($objWorksheet->getRowIterator() as $row) {
				
					//echo '    - Row number: ' . $row->getRowIndex() . "\r\n";
			
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
					$y=1;
					foreach ($cellIterator as $cell) {
					
						//if (!is_null($cell)) {
							//echo '        - Cell: ' . $cell->getCoordinate() . ' - ' . $cell->getCalculatedValue() . "\r\n";
							//echo ' voucher : '.$cell->getCalculatedValue() . "\r\n";
							if($x==1 && $y==1){$dataArray1[$x][$y] = "";}
							else{$dataArray1[$x][$y] = $cell->getFormattedValue();}
							
						
							
							
							
							
					$y++;
						//}
					}
					//.......
					$x++;
				}
			//}
			}
			if($ext=='.csv')
{
try
{
	$delimiter = detectDelimiter($inputFileName);
	$handle = fopen($inputFileName, "r");
	if($handle)
	{
			while (($line_array = fgetcsv($handle, 8000, $delimiter)) !== false)
	 		{
				$dataArray2[]=$line_array;
			}
			fclose($handle);
			$x=1;
			for($c=0;$c<count($dataArray2);$c++)
			{
				$y=1;
			    for($k=0;$k<count($dataArray2[0]);$k++)
	 			 {
	 				// if($dataArray2[0][$k]!="")
		 			// {
	 					 if($c==0 && $k==0){$cellval="";}else{$cellval=$dataArray2[$c][$k];}
		    			 $dataArray1[$x][$y] =($cellval!='')?trim($cellval):'';
					// }
			        $y++;
	             }
	            $x++;
			}
    }
	}
catch (Exception $e) {
    //die("Error loading file: ".$e->getMessage()."<br />\n");
	$errorMsg ="Can't read File!!";
}
}
if($ext=='.xlsxx')
{			
require('XLSXReader.php');
$xlsx = new XLSXReader($inputFileName);
$sheetNames = $xlsx->getSheetNames();
$sheet = $xlsx->getSheet($sheetNames[1]);
	//array2Table($sheet->getData());
	$x=1;
	foreach($sheet->getData() as $key1=>$row) {
	$y=1;
		foreach($row as  $key2=>$cell) {
		if($key1==0 && $key2==0){$cellval="";}else{$cellval=$cell;}
		$dataArray1[$x][$y] =$cellval;
		$y++;
		}
		$x++;
	}

			
			}
######################################
		//Coloumnwise data###########################################################
		$data=array();$data1=array();
		for($i=0;$i<=count($dataArray1[1]);$i++)
		{ 
		$ar=array();
		if($i!=0)
		{
		$ar=getCol($dataArray1,$i);
		array_push($data,$ar);
		}
		//  $data1[]=array_splice($data,1);
		}
		
		#echo "<pre>";print_r($dataArray1[3]);echo "</pre>";exit;
		 
		$insertxlArray = array();//$x=1;
		for($xval=1;$xval<count($data[0]);$xval++)
		{
									for($yval=1;$yval<=count($dataArray1[1]);$yval++)
									{
									if($dataArray1[1][$yval])
									{	//if($xval!=$x){ echo "######################################################################################<br>";}
									//echo $data[0][$xval].','.$dataArray1[1][$yval].','.$dataArray1[$xval+1][$yval];echo "<br>";
									if($data[0][$xval]!='0' || $data[0][$xval]!=0)
									{
							       		$yearmonth=explode('/', trim($data[0][$xval]));
										if(empty($yearmonth[1])){$month=0;}else{ $month=$yearmonth[1]; }
										//if($dataArray1[$xval+1][$yval]){ $value=$dataArray1[$xval+1][$yval];}else{$value=0;}
										$value=$dataArray1[$xval+1][$yval];
										$insertxlArray = array();//$x=$xval;
										$insertxlArray['gid']      = $id;
										$insertxlArray['x_value']  = trim($data[0][$xval]);
										$insertxlArray['date']  = empty($yearmonth[2]) ? 0 : $yearmonth[2];
										$insertxlArray['month']  = $month;
										$insertxlArray['year']  = $yearmonth[0];
										$insertxlArray['y_value']  = $dataArray1[1][$yval];
										$date = DateTime::createFromFormat('Y/m', $dataArray1[2][1]);
										if($date == false) 
										{
										$insertxlArray['y_sub_value']  = $dataArray1[2][$yval];
										}
										else
										{  
										$insertxlArray['y_sub_value']  ="";
										}
										if($isMap == 'Map') {
										$insertxlArray['region']  = ($dataArray1[3][$yval]!=null)?trim($dataArray1[3][$yval]):'';
										}
										$insertxlArray['value']  = ($value!=null)?trim($value):'';
										$insertxlArray['data_row']  = $xval;
										$insertxlArray['data_coloumn']  = $yval;
										$chartObj->addValues($insertxlArray);
									//$successMsg = "Values added successfully.";
									}
									}
									}
									}
		//echo  $successMsg;
       

	   // edit excel values -- end
		} else { $xlFile = $filepath; } 
		
		}
		 }
		}
		}
		$source      = $graphSource; 
		$title       = $graphTitle;
		$txt         = $graphTxt; 
		$is_premium  = $graphIsPremium;
		$xfile       = $xlFile;
		$updated_page       = $updated_page;
		$isMap = $isMap;
		$chartObj->updateGraphdetails($id,$source,$title,$txt,$is_premium,$xfile,$updated_page,$isMap);
		// Clear memcached
		try{
			$alaneeMemcached = new Alaneememcached();
			$alaneeMemcached->deleteAllChartData();
		}catch (Exception $ex){
		
		}		
		$successMsg = "Graph updated successfully.";
	//	echo $successMsg;
		header("Location:editGraph.php?id=$id");
		}
?>
<script type="text/javascript" src="../public/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../public/plugins/ckeditor/ckfinder.js"></script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Edit graph</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="<?php echo $themeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="slider images" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="<?php echo $themeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="slider images" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	              
	
		<!-- start id-form -->
                 <form action="" name="add_graph" enctype="multipart/form-data" id="add_graph" method="post">
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                          <tr>
                            <th valign="top">Source:</th>
                            <td colspan="2">
                                <input type="text" name="graph_source" id="graph_source" class="inp-form" value="<?php echo $source;?>" />
                                <label for="graph_source" class="error" id="graph_source_error"></label>                            </td>
                            <td></td>
                          </tr> 
						   
                          <tr>
                            <th valign="top">Title:</th>
                            <td colspan="2">
                                <input type="text" name="graph_title" id="graph_title" class="inp-form" value="<?php echo $title; ?>"/>
                                <label for="graph_title" class="error" id="graph_title_error"></label>                            </td>
                            <td></td>
                          </tr>
                            

                    <tr>
                            <th valign="top">Text:</th>
                            <td colspan="2">
                               
                                <textarea  name="graph_txt" id="graph_txt" cols="22" rows="8"  ><?php echo editorfix($description); ?></textarea>
                                                    
                                <label for="graph_txt" class="error" id="graph_txt_error"></label>                            </td>
                            <td></td>
                    </tr>
					<tr>
                            <th valign="top">Is premium:</th>
                            <td colspan="2">
                               
                                <input type="checkbox" name="isPremium" value="y" <?php if($isPremium == 'y') { echo 'checked'; } ?> >
                                                    
                                <label for="graph_premium" class="error" id="graph_premium_error"></label>                            </td>
                            <td></td>
                    </tr>
                 <tr>
                            <th>Upload File:</th>
                            <td>
                                <input type="file" name="graph_File" id="graph_File" class="file_1" /><br /><?php echo $filepath; ?>
                                <label for="graph_File" class="error" id="graph_File_error"></label>                            </td>
                           
                            <td>(Note. 
Please use .xls file,<br />
The file should contain dates as first coloumn,<br />
Click here <a href="../downloadxls.php?download_file=sample/sample.xls" > <img src="../images/xlsicon.jpg" alt="sample file" width="30px"  height="30px" /></a> for sample excel format )</td>
                 </tr>  

                  <tr>
                            <th valign="top">In which page is updated?:</th>
                           <td colspan="2">
                                <input type="text" name="updated_page" id="updated_page" class="inp-form" value="<?php echo $updated_page;?>" />
                               <label for="updated_page" class="error" id="updated_page_error"></label>                            </td>
                            <td></td>
                          </tr> 



                          <tr>
                            <th valign="top">Is Map:</th>
                            <td colspan="2">
                               
                                <input type="checkbox" name="isMap" value="y" <?php if($isMap == 'Map') { echo 'checked'; } ?> >
                                                    
                                <label for="graph_map" class="error" id="graph_map_error"></label>                            </td>
                            <td></td>
                    </tr>


                 <tr>

                <tr>
                    <th>&nbsp;</th>
                    <td colspan="2" valign="top">
                            <input type="submit" value="Submit" name="addGraph" class="form-submit" />                    </td>
                    <td></td>
                </tr>
                </table>
          </form>
	<!-- end id-form  -->

	</td>
	<td>


</td>
</tr>

</table>
 
<div class="clear"></div>
 

</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>



<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<?php include('footer.php');?>