@extends('templates.default')
@section('content')
<style type="text/css">
.content_leftside{display: none;}
</style>
<script type="text/javascript" src="<?php  echo asset("assets/plugins/elevateZoom/jquery.elevateZoom.min.js");?>" ></script>
<div class="abochar_container">
  <div class="col-xs-12">
    <h1 class="text-center">With My Chart, making chart book is never easier</h1>
    <div class="spacer10"></div>
    <div class="main-title">
      <h1>You can save your favorite charts online.</h1>
      <div class="mttl-line"></div>
    </div>
    <div class="spacer10"></div>
  </div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="acc_zoom" src='<?php echo images_path("about_chart/find_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/find_chart.png");?>" alt="find charts" />
    <h3>You can go to indicator pages to find charts you need.</h3>
  </div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="" src='<?php echo images_path("about_chart/save_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/save_chart.png");?>" alt="Save chart" />
    <h3>Saving is easy with two clicks</h3>
  </div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="" src='<?php echo images_path("about_chart/my_folder.png");?>' data-zoom-image="<?php echo images_path("about_chart/my_folder.png");?>" alt="My Folder" />
    <h3>Saved charts are in My Folder</h3>
    <p><b>Note:</b>With a free account, you can save edit up to 4 charts tables in your personal online folder. If you wish to save more than 5 charts, please upgrade to a STANDARD or CORPORATE account.</p>
  </div>
  <div class="spacer10"></div>
  <div class="col-xs-12"><hr></div>
  <div class="clearfix"></div>
  <h1 class="text-center">You can edit charts directly from My Folder.</h1>
  <div class="spacer10"></div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="acc_zoom" src='<?php echo images_path("about_chart/range_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/range_chart.png");?>" alt="Chart Range" />
    <h3>You can change the range of your chart...</h3>
  </div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="acc_zoom" src='<?php echo images_path("about_chart/update_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/update_chart.png");?>" alt="Update Chart" />
    <h3>... and add new series to charts. Click update to return to My folder</h3>
  </div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="" src='<?php echo images_path("about_chart/duplicate_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/duplicate_chart.png");?>" alt="Duplicate Chart" />
    <h3>You can duplicate a chart...</h3>
  </div>
  <div class="clearfix"></div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="" src='<?php echo images_path("about_chart/table_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/table_chart.png");?>" alt="Table Chart" />
    <h3>…and change the second chart into a table</h3>
  </div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="" src='<?php echo images_path("about_chart/note_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/note_chart.png");?>" alt="Add Note" />
    <h3>You can make a note to add your comments</h3>
  </div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="acc_zoom" src='<?php echo images_path("about_chart/drag_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/drag_chart.png");?>" alt="Order Chart" />
    <h3>You can drag-and-drop the charts to change order</h3>
  </div>
  <div class="spacer10"></div>
  <div class="col-xs-12"><hr></div>
  <h1 class="text-center">Now your chartbook is ready to go.</h1>
  <div class="spacer10"></div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="acc_zoom" src='<?php echo images_path("about_chart/ppt_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/ppt_chart.png");?>" alt="Download Powerpoint" />
    <h3>Export to PowerPoint slides with just one click.</h3>
  </div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="acc_zoom" src='<?php echo images_path("about_chart/print_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/print_chart.png");?>" alt="Print Chart" />
    <h3>Or use the printed version as a presentation material</h3>
  </div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="acc_zoom" src='<?php echo images_path("about_chart/toggle_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/toggle_chart.png");?>" alt="Toggle Chart" />
    <h3>You can switch Large View / List View to change the order easily.</h3>
  </div>
  <div class="spacer10"></div>
  <div class="col-xs-12"><hr></div>
  <h1 class="text-center">More Features for Standard/Corporate</h1>
  <div class="spacer10"></div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="acc_zoom" src='<?php echo images_path("about_chart/addfol_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/addfol_chart.png");?>" alt="Add Folders" />
    <h3>You can add unlimited number of Folders</h3>
  </div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="acc_zoom" src='<?php echo images_path("about_chart/chatab_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/chatab_chart.png");?>" alt=" Charts And Tables" />
    <h3>..and save as many charts & tables as you like.</h3>
  </div>
  <div class="col-xs-12 col-md-4 acc_scon">
    <img class="acc_zoom" src='<?php echo images_path("about_chart/small_chart.png");?>' data-zoom-image="<?php echo images_path("about_chart/small_chart.png");?>" alt="Chart small view" />
    <h3>Small view helps you to move charts & tables as you like.</h3>
  </div>
</div> 
<script type="text/javascript">
$(document).ready(function(){
  $('.acc_zoom').elevateZoom({
    borderSize    : 2,
    zoomType : "lens",
    lensShape : "round",
    lensSize : 200
  });
});
</script>
@stop