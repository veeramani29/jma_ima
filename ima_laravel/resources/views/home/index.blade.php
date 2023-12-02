@extends('templates.default')
@section('content')
<div class="col-xs-12 col-md-7">
  <?php
  $resn = $result['news'];
 // dd($resn); exit;
  ?>
  <div id="dv_home_mn_graph" class="row">
    <div class="col-xs-12">
      <?php echo $result['homepagegraph'];  ?>
    </div>
  </div>
  <div class="main-title">
    <h1>Recently updated pages</h1>
    <div class="mttl-line"></div>
  </div>
  <?php
  $count = count($resn);
  if($count==0) {
    ?>
    <div class="row">
      <div class="col-xs-12">
        <h3>Sorry, <span>No news found</span></h3>
      </div>
    </div>
    <?php
  } else {
    for($i=0;$i<$count;$i++) {
      $today =  date('y-m-d');
      $today =  strtotime($today);
      $today = strtotime("-7 day", $today);
      $resn_date =  strtotime($resn[$i]['post_released']);
	  $news_link_url =url('page/category/'.$resn[$i]['category_path']); 
	   if($resn[$i]['post_type'] == "N")
		   {
		   	$news_link_url =url('reports/view/reports/'.$resn[$i]['post_url']); 
		   }
      ?>
      <div class="">
        <div class="home_recpub <?php if ($i == 0) echo "first-section";?> <?php if ($i == $count - 1) echo "last-section";?>">
          <div class="sec-title sec-date">
            <?php if ($resn_date > $today) echo '<span class="latest">Latest</span>'; ?>
            <?php if(!empty($resn[$i]['post_released'])) {?>
            <span class="released <?php if ($resn_date > $today) echo "first"; ?>">
              <?php echo stripslashes($resn[$i]['post_released']);?>
            </span>
            <?php }?>
            <h1>
              <a class="title-link" href="<?php echo $news_link_url;?>">
                <?php echo stripslashes($resn[$i]['post_title']);?>
              </a>
            </h1>
            <div class="sttl-line"></div>
          </div>
          <?php if(!empty($resn[$i]['post_heading'])) {?> <h5><?php echo stripslashes($resn[$i]['post_heading']);?></h5><?php }?>
          <?php if(!empty($resn[$i]['post_subheading'])) {?><h3><?php echo stripslashes($resn[$i]['post_subheading']);?></h3><?php }?>
          <p>
		  
		  <?php 
		   
		   if($resn[$i]['post_type'] == "N")
		   {
			   
				$resent_data = $resn[$i]['post_cms_small']; 
				
			  
				echo  $string = (strlen($resent_data) > 500) ? substr($resent_data,0,500).'...' : $resent_data;
		   }
		   else
		   {
				$post =  $resn[$i]['post_cms']; 
			  
				$delimiter = '#';
				$startTag = 'Recent Data Trend';
				$endTag = 'Brief';
				$regex = $delimiter . preg_quote($startTag, $delimiter) 
								. '(.*?)' 
								. preg_quote($endTag, $delimiter) 
								. $delimiter 
								. 's';
				preg_match($regex,$post,$matches);

				$variables = array("Recent Data Trend", "Brief","Recent Data Trend:",":");
				$replacements   = array("","","","");
				$resent_data = "";
				if(isset($matches[0]))
				{
					$resent_data = str_replace($variables, $replacements, $matches[0]);
				}
			  
				echo  $string = (strlen($resent_data) > 500) ? substr($resent_data,0,500).'...' : $resent_data;
				
				if($string=="")
				{
						$delimiter = '#';
						$startTag = 'Brief Overview';
						$endTag = 'For more information';
						$regex = $delimiter . preg_quote($startTag, $delimiter) 
									. '(.*?)' 
									. preg_quote($endTag, $delimiter) 
									. $delimiter 
									. 's';
						preg_match($regex,$post,$matches);

						$variables = array("Recent Data Trend", "Brief Overview","Recent Data Trend:",":");
						$replacements   = array("","","","");
						
						$resent_data = "";
						if(isset($matches[0]))
						{
							$resent_data = str_replace($variables, $replacements, $matches[0]);
						}

						echo  $string = (strlen($resent_data) > 500) ? substr($resent_data,0,500).'...' : $resent_data;
				}
			  
			  
			 
		   
		 } 
		 
		  // cleanMyCkEditor($resn[$i]['post_cms_small']);?></p>
		  <?php if(strlen($resent_data) > 500){ ?><a class="readmore pull-right" href="<?php echo $news_link_url;?>"> Read more.. </a><?php } ?>
		   
		   
		   
		   
		   
		   
        </div>
      </div>
      <?php
    }
  }
  ?>
</div>
<form name="download" id="download" method="post" action="<?php echo url('chart/downloadxls')?>">
  <input type="hidden" name="data" id="data" value="" />
</form>
 @include('templates.rightside')
@stop
