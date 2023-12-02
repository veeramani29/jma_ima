@extends('templates.default')
@section('content')
<?php
$count = count($result['search']);
?>
<div class="col-md-10 seares_page">
  <div class="main-title resp_ttl">
    <h1>Found <?php echo $count; ?> results for <span>"<?php echo $result['searchKeyword']; ?>"</span></h1>
    <div class="mttl-line"></div>
  </div>
  <?php
  $res = $result['search'];
  if(!empty($res)){
  $j = count($res);
  for($i=0;$i<$j;$i++){
  ?>
  <div class="home_recpub">
    <div class="sec-title sec-date">
      <h5> <a class="title-link" target="_blank" href="<?php echo $res[$i]['url']; ?>"><?php echo $res[$i]['title']; ?></a> </h5>
      <div class="sttl-line"></div>
    </div>
  </div>
  <?php } } ?>
</div>
@stop