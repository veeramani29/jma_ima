@extends('templates.default')
@section('content')
<style type="text/css">
.content_leftside{display: none;}
table.list-view tr.exhibit  {
  position: relative;
  /** More li styles **/
}
table.list-view tr.exhibit :before {
  position: absolute;
  /** Define arrowhead **/
}
.modal .h_graph_tab_area{
  display: block !important;
}
</style>
<div class="show_How_To_SaveInFolderVedio col-xs-12" style="display:none">
  <div class="main-title">
    <h1 class="folder-title " id="">How to add chart in your folders </h1>
    <div class="mttl-line"></div>
  </div>
  <div class="col-xs-12 col-md-8 col-md-offset-2">
    <div class="embed-responsive embed-responsive-16by9">
      <iframe width="560" class="text-center" height="315" src="https://www.youtube.com/embed/0ONE0ovoubc" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
</div>
<div class="col-xs-12 myfolder_wholediv">
  <!-- <div id="veera"></div> -->
  <!-- tabs start here -->
  <div class="folderpage_tabs">
    <!-- Nav tabs -->
    <div class="folnav_stipos full-width"></div>
    <?php if(Session::get('user.isAuthor') == "Y"){ ?>
    <ul class="nav nav-tabs folnav_stick" role="tablist">
     <li class="fpt_large active" role="presentation">
       <a href="#fpt_large"  aria-controls="fpt_large" role="tab" data-toggle="tab">
         <i class="fa fa-th-large" aria-hidden="true"></i> Large
       </a>
     </li>
     <li class="fpt_list" role="presentation" >
       <a href="#fpt_list" aria-controls="fpt_list" role="tab" data-toggle="tab">
         <i class="fa fa-list-ul" aria-hidden="true"></i> List
       </a>
     </li>
     <li class="fpt_small" role="presentation">
       <a href="#fpt_small" aria-controls="fpt_small" role="tab" data-toggle="tab">
         <i class="fa fa-th" aria-hidden="true"></i> Small
       </a>
     </li>
   </ul>
   <?php } ?>
   <!-- Tab panes -->
   <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="fpt_large">
      <!-- Large view strat-->
      <div class="content_midsection full-width" id="content_midsection">
        <div class="main-title">
          <h1 class="folder-title " id="Dv_folder_content_title"></h1>
          <div class="mttl-line"></div>
        </div>
        <div class="right-menus mychart_exppri">
          <ul class="top-m list-inline">
           <?php if(Session::get('user.isAuthor') == "Y"){ ?>
            <li>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chaboo_desc">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add Description
              </button>
            </li>
            <?php } ?>
         
            <?php if(Session::get('user.user_type_id')== 2 || Session::get('user.user_type_id') == 3) { ?>
            <li class="save_to_chart_chart">
              <a href="javascript:void(0);" class="btn btn-primary">
                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                <span>Save In My chart</span>
              </a>
            </li>
            <?php } ?>
          </ul>
        </div>          <!--  -->
        <div class="progress_exportfile" style="display:none;">
          <div class="progress">
            <div  class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" > </div>
          </div>
          <h4>Please Wait...</h4>
        </div>
        <div id="Dv_folder_content">
        </div>
        <div>
          <form action="<?php echo url('chart/downloadxls');?>" id="form_mychart_download_data" method="post">
            <input type="hidden" id="frm_input_download_chart_codes" name="chart_codes" value=""> <input type="hidden" id="frm_input_download_chart_datatype" name="chart_datatype" value="">
            <input type="hidden"  name="_token" value="<?php echo csrf_token();?>">
          </form>
        </div>
      </div>
<!--   <div id="content_midsectiondd">
</div> -->
  @include('mycharts.script_template') 
<!-- Large View Close -->
</div>
<div role="tabpanel" class="tab-pane" id="fpt_list">
</div>
<div role="tabpanel" class="tab-pane" id="fpt_small">
  <div id="Dv_folder_content_smallView" > </div>
</div>
</div>
</div>
</div>

<!-- Edit Folder Content Modal Start-->
<div class="modal fade mychart_edimod" title="Edit Chart"  id="Dv_modal_edit_folder_content" data-uuid="0" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-success">Edit Folder Content</h4>
      </div>
      <div class="modal-body">
        <div id='Chart_Dv_placeholder_0'> </div>
        <div class="col-xs-12 mcem_updbtn">
          <input type="button" class="btn btn-primary" Value="Update to myChartBook" onclick="JMA.myChart.updateThisEditedChartBook()">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit Folder Content End-->
<!-- Download ppt modal -->
<div class="modal fade" id="modal_pptdownload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Export Your Files</h4>
      </div>
      <div class="modal-body">
        <ul class="list-unstyled pptdowd_list">
          <li>
            Download All <a href="#" class="btn btn-primary pull-right"><i class="fa fa-download"></i>Download</a>
          </li>
          <li>
            Page 1 <a href="#" class="btn btn-primary pull-right"><i class="fa fa-download"></i>Download</a>
          </li>
          <li>
            Page 2 <a href="#" class="btn btn-primary pull-right"><i class="fa fa-download"></i>Download</a>
          </li>
          <li>
            Page 3 <a href="#" class="btn btn-primary pull-right"><i class="fa fa-download"></i>Download</a>
          </li>
          <li>
            Page 4 <a href="#" class="btn btn-primary pull-right"><i class="fa fa-download"></i>Download</a>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="chaboo_desc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Chart book Description</h4>
      </div>
      <div class="modal-body">
        <textarea class="form-control" rows="5" placeholder="Add your description here" name="text_chartbook_desc" id="text_chartbook_desc"></textarea>
      </div>
      <div id="err_desc_cb"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary description-chartbook-single">Save description</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function isScrolledtopMoz(elem) {
  var first = null;
  var ret_row = 0;
  $(elem).find("table tbody tr").each(function(){
    if(isScrolledtopView($(this)) && !first) {
      first = $(this);
      ret_row=$(this).index();
//$('.message').text(first.text());
return false;
}
});
  return ret_row;
}
function isScrolledtopView(elem) {
  var docViewTop = $(window).scrollTop();
  var docViewBottom = docViewTop + $(window).height();
  var elemTop = $(elem).offset().top;
  var elemBottom = elemTop + $(elem).height();
  return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}
function findTopVisibleRow($el){
  var rows = $($el).find('table tbody tr');
  var offset =$($el).find('table tbody').scrollTop();
  var visibleIndex = 0;
  var height = 0;
  rows.each(function (index, item) {
    if (offset == 0) {
      height = 0;
      visibleIndex = 0
      return false;
    }
    height += $(this).height();
    if (height > offset) {
      visibleIndex = index + 1;
      height = 0;
      return false;
    }
  })
//$('.message').text('The text of the first fully visible div is ' + rows.eq(visibleIndex).text());
return visibleIndex;
}
$(document).ready(function(){
  $(document).on('touchstart click', '.ppt-mycharts', function(e){
    e.preventDefault();
    e.stopPropagation();
    $('i.ppt-spin').show();
    $(this).attr("disabled" ,"disabled");
    var n = $( "div#Dv_folder_content div#grids div.exhibit" ).length;
    var total_chart_len = $( "div#Dv_folder_content div#grids div.exhibit div.data-views div.graph-view:not(.hide)" ).length;
    if(n>0){
      JMA.exportPPT(this,total_chart_len);
    }else{
     $(this).removeAttr("disabled");
     alert ('you dont have any charts');
   }
 });
  $(document).on('touchstart click', '.page_downseparate', function(e){
//closest('.ftps_holcon').filter('.exhibit').length
    //$(this).parents('.col-xs-12').nextUntil(".page2").addClass("current-ppt");
    if($(this).hasClass('small-view')){
     var total_chart_len=$(this).parents('.ftps_holconmin').find('.exhibit').length;
   }else{
     var total_chart_len=$(this).parents('.col-xs-12').nextUntil(".page2").filter('.exhibit').length;
   }
   if(total_chart_len>0){
    $('<i class="fa fa-spinner fa-spin"></i>').insertAfter($(this).find('i'));
    JMA.exportPptperPage($(this),total_chart_len);
  }else{
    alert ('You dont have any charts under this page');
  }
});
/*  var term1 = document.getElementById( "term-1" );
$( "#term-3" ).prevUntil( term1, "dd" )
.css( "color", "green" );*/
});
$(document).ready(function(){
  var $table = $('table.mychart_table'),
  $bodyCells = $table.find('tbody tr:first').children(),
  colWidth;
// Adjust the width of thead cells when window resizes
$(window).resize(function() {
// Get the tbody columns width array
colWidth = $bodyCells.map(function() {
  return $(this).width();
}).get();
// Set the width of thead columns
$table.find('thead tr').children().each(function(i, v) {
  $(v).width(colWidth[i]);
});
}).resize();
});
</script>
@stop