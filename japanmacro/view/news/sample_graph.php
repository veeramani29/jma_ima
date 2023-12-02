	
	 <div class="row">
	 <div class="col-md-12">
		<h3><?php echo $this->resultSet['result']['title'];?></h3>
                               
		<?php echo $this->resultSet['result']['chart']; // makeChart(cleanMyCkEditor($resn[0]['post_cms']));?>
	 </div>
	  </div>
   
<?php 
 // include('view/templates/rightside.php');
?>
<form name="download" id="download" method="post" action="<?php echo $this->url('chart/downloadxls')?>">
<input type="hidden" name="data" id="data" value="" />
</form>