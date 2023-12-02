@extends('templates.default')
@section('content')

<?php 
function addParagraphs($text){
		   // Add paragraph elements
		   $lf = chr(10);
		   return preg_replace('/
		      \n
		     (.*)
		     \n
		     /Ux' , $lf.'<p>'.$lf.'$1'.$lf.'</p>'.$lf, $text);
		}
		?>
<div class="col-md-10 col-xs-12">
<div class="first-section">
<div class="sec-title sec-date">
<?php //if(!empty($result[0]['post_released'])) {?>
<!-- <span class="released ">
<?php echo stripslashes($result[0]['post_released']);?>
</span> -->
<?php// }?>
<h1><?php echo stripslashes($result[0]['post_title']);?> for {{$result[0]['updated_date']}}</h1>
<div class="sttl-line"></div>
</div>
<h5><?php echo stripslashes($result[0]['post_heading']);?> <!-- <small>({{$result[0]['updated_date']!=null?substr($result[0]['updated_date'],0,10):substr($result[0]['post_datetime'],0,10)}})</small> --></h5> 
<div itemprop="articleBody">
<?php 
	$doc=addParagraphs(PHP_EOL.$result["graph"].PHP_EOL);
	//$doc=stripslashes($doc);
echo $doc; 
?>
</div>
<p>
<?php //echo isset($result[0]['post_cms'])?$result[0]['post_cms']:''; ?>
</p>


</div>

</div>
@stop