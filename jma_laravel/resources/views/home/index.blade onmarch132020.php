
@extends('templates.default')
@section('content')
   
<div class="col-xs-12 col-md-7">
<?php
$resn = $result['news'];
?>
<div id="dv_home_mn_graph" class="row">
  <div class="col-xs-12">
    <?php echo $result['homepagegraph'];  ?>
  </div>
</div>
<div class="main-title">
  <h1>Recently published reports</h1>
  <div class="mttl-line"></div>
</div>
<?php
$count = count($resn);
if($count==0)
{
  ?>
  <div class="row">
    <div class="col-xs-12">
      <h3>Sorry, <span>No news found</span></h3>
    </div>
  </div>
  <?php
}
else
{
  for($i=0;$i<$count;$i++)
  {
    $today =  date('y-m-d');
    $today =  strtotime($today);
    $today = strtotime("-7 day", $today);
    $resn_date =  strtotime($resn[$i]['post_released']);
    $news_link_url =$resn[$i][0];
    /*if(($resn[$i]['premium_news']=='Y' || $resn[$i]['post_url']=='kuroda-tried-to-end-the-speculation-that-10yr-rate-may-rise-soon') && ((Session::has('user') && Session::get('user.user_type_id')==1) || !Session::has('user'))){
    if(Session::get('user.user_type_id')==1){
    $news_link_url='javascript:JMA.User.showUpgradeBox("premium","'. url('news/view/'.$resn[$i]['post_url']).'")';
    }else{
    $news_link_url='javascript:JMA.User.showLoginBox("premium","'. url('news/view/'.$resn[$i]['post_url']).'")';
    }
    }else{
    $news_link_url =url('news/view/'.$resn[$i]['post_url']); 
    }*/

    ?>
    <div class="">
      <div class="home_recpub <?php if ($i == 0) echo "first-section";?> <?php if ($i == $count - 1) echo "last-section";?>">
        <div class="sec-title">
          <?php if ($resn_date > $today) echo '<span class="latest">Latest</span>'; ?>
          <?php if(!empty($resn[$i]['post_released'])) {?>
          <span class="released <?php if ($resn_date > $today) echo "first"; ?>">
            <?php echo stripslashes($resn[$i]['post_released']);?>
          </span>
          <?php }?>
          <h1>
            <a class="title-link" href='<?php echo $news_link_url;?>'>
              <?php echo stripslashes($resn[$i]['post_title']);?>
            </a>
          </h1>
          <div class="sttl-line"></div>
        </div>
        <?php if(!empty($resn[$i]['post_heading'])) {?> <h5><?php echo stripslashes($resn[$i]['post_heading']);?></h5><?php }?>
        <?php if(!empty($resn[$i]['post_subheading'])) {?><h3><?php echo stripslashes($resn[$i]['post_subheading']);?></h3><?php }?>
        <p><?php echo $resn[$i]['post_cms_small']; // cleanMyCkEditor($resn[$i]['post_cms_small']);?></p>
        <a class="readmore pull-right" href='<?php echo $news_link_url;?>'> Read more.. </a>
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
 