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
/*svg g.highcharts-legend rect{
x: 10px !important;
font-size: 4px !important;
font-weight: normal !important;
width: 100% !important;
}
svg g.highcharts-legend-item  text{
font-size: 4px !important;
font-weight: normal !important;
}*/
</style>
<div class="show_How_To_SaveInFolderVedio col-xs-12">
  <div class="main-title">
    <h1 class="folder-title " id="">How to add chart in your folders </h1>
    <div class="mttl-line"></div>
  </div>
  <div class="col-xs-12 col-md-8 col-md-offset-2">
    <div class="embed-responsive embed-responsive-16by9">
      <iframe class="text-center" src="https://www.youtube.com/embed/_4RA3oRRbho" frameborder="0" allowfullscreen></iframe>
    </div>  
  </div>
</div>  
<div class="col-xs-12 myfolder_wholediv">
  <!-- <div id="veera"></div> -->
  <!-- tabs start here -->
  <div class="folderpage_tabs">
    <!-- Nav tabs -->
    <div class="folnav_stipos full-width"></div>
    <ul class="nav nav-tabs folnav_stick" role="tablist">
      <li class="fpt_large active" role="presentation">
        <a href="#fpt_large"  aria-controls="fpt_large" role="tab" data-toggle="tab">
          <i class="fa fa-th-large" aria-hidden="true"></i> <span>Large</span>
        </a>
      </li>
      <li class="fpt_list" role="presentation" >
        <a href="#fpt_list" aria-controls="fpt_list" role="tab" data-toggle="tab">
          <i class="fa fa-list-ul" aria-hidden="true"></i> <span>List</span>
        </a>
      </li>

      <li class="fpt_small" role="presentation">
        <a href="#fpt_small" aria-controls="fpt_small" role="tab" data-toggle="tab">
          <i class="fa fa-th" aria-hidden="true"></i> <span>Small</span>
        </a>
      </li>

    </ul>
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
              <li>
                <a href="javascript:;" class="btn btn-primary ppt-mycharts">
                  <i class="fa fa-download"></i>
                  <span>
                    Export to Powerpoint <i></i>
                  </span>
                </a>
              </li>
              <!-- <li>
                <a href="#" class="btn btn-primary print-mycharts">
                  <i class="fa fa-print"></i>
                  <span>Print</span>
                </a>
              </li> -->
            </ul>
          </div>
          <div id="Dv_folder_content">
          </div>
          <div>
            <form action="<?php echo url('chart/downloadxls');?>" id="form_mychart_download_data" method="post">
              <input type="hidden" id="frm_input_download_chart_codes" name="chart_codes" value=""> <input type="hidden" id="frm_input_download_chart_datatype" name="chart_datatype" value="">
              <input type="hidden" id="frm_input_download_map_state" name="map_selectState" value="">
              <input type="hidden" id="title_map_state" name="title_map_state" value="">
			  <input type="hidden"  name="_token" value="{{csrf_token()}}">
            </form>
          </div>
        </div>
 @include('mycharts.script_template')
<!-- Large View Close -->
</div>
<div role="tabpanel" class="tab-pane" id="fpt_list">
  <table  class="table fpt_table list-view">
    <!-- if removed then list is not visible -->
  </table>
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
          <input type="button" class="btn btn-primary" Value="Update to myChart" onclick="JMA.myChart.updateThisEditedChart()">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit Folder Content End-->
<script type="text/javascript" src="<?php echo js_path("Sortable.min.js");?>"></script>
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
  $('a.ppt-mycharts').on('click',function(){
    var n = $( "div#Dv_folder_content div#grids div.exhibit" ).length;
    var total_chart_len = $( "div#Dv_folder_content div#grids div.exhibit div.data-views div.graph-view:not(.hide)" ).length;
    if(n>0){
      $('<i class="fa fa-spinner fa-spin ppt-spin"></i>').insertAfter('a.ppt-mycharts span');
//if(total_chart_len>0){}
var chartArray = [];var chartTitleArray = [];var chartsourceArray = [];var chartNotesArray = [];
var i=0;
$( "div.exhibit" ).each(function( index, element ) {
  var chart_title =$(this).find('h5.exhibit-title').text();
  chartTitleArray.push(chart_title);
  if(!$(this).hasClass('note')){
    var chartOrder=$(this).find('ul.exhibit-tab li').data('order');
    var chart_content =$(this).find('div.data-views div.graph-view div.highcharts-container').clone().wrap('<span>').parent().html();
    var chart_source =$(chart_content).find("span").text();
    chartsourceArray[index]=chart_source;
    if(!$(this).find('div.data-views div.graph-view').hasClass('hide')){

      var chart=JMA.myChart.myFolder.currentFolder.charts[chartOrder].chart_object;
      console.log(chart);
      var chart_svg = chart.getSVG({
        chart:{
          backgroundColor: '#FFF'
        },
        credits: {
          enabled: false
        },
        scrollbar : {
          enabled : false
        },
        legend:{
          width: 350
        }
      });
//
var find_image =$(chart_svg).find("image").remove().clone().wrap('<div>').parent().html();
chart_svg = chart_svg.replace(find_image, '');
var exp_data = {
  svg: chart_svg,
  type: 'png',
  width: 900,
  height: 400,
  async: true
};
// Local sertver
exportUrl = JMA.baseURL+'chart/exportChartpptx';
// Highchart sertver
/*if (window.location.protocol != "https:"){
exportUrl=chart.options.exporting.url;
}else{
exportUrl='https://export.highcharts.com/';
}*/
$.ajax({
  type: "POST",
  url: exportUrl,
  data: exp_data,
  cache:false,
  async:true,
  crossDomain:true,
  success: function (data) {
    chartArray[index]=({"chart":data});
  },
  error: function(data) {
    console.log(data.statusText+data.status);
    chartArray[index]=({"chart":data.status});
  }
});
chartNotesArray[index]='';
}else{
  var chartOrder=$(this).find('ul.exhibit-tab li').data('order');
  var Datas=JMA.myChart.myFolder.currentFolder.charts[chartOrder];
  var each_tbl_row_len=$(this).find('div.data-views div.table-view table tbody tr').length;
  var each_tbl_content = $(this).find('div.data-views div.table-view');
  var $add_tr=0;
  if(($.browser.mozilla || $.browser.msie) && Datas.chart_data_type != 'daily') {
//if (window.location.protocol == "https:"){
  if(Datas.chart_data_type == 'monthly'){
    $add_tr=3;
  }
//}
}
if(Datas.chart_data_type == 'daily' && ($.browser.mozilla || $.browser.msie)){
  var winscrollTop     = $(window).scrollTop();
  var elementOffset = each_tbl_content.offset().top;
  var elementdistance      = (elementOffset - winscrollTop);
  $add_tr=Math.floor(elementdistance/30);
  var firstToprows=isScrolledtopMoz(each_tbl_content);
  firstToprows=(firstToprows<100)?firstToprows:firstToprows + $add_tr;
}else{
  var firstToprows=findTopVisibleRow(each_tbl_content) + $add_tr ;
}
var lastrows=firstToprows  + 11;
var data_formated = [];var tableArray;var data_heading = [];
$.each(Datas.data.chartDataSeries,function(order,series){
  data_heading[order]=series.name;
  $.each(series.data,function(i_order,dataset){
    if(i_order>=firstToprows && i_order<=lastrows){
      if(Array.isArray(data_formated[i_order]) == true){
        data_formated[i_order].push(dataset[1]);
      }else{
        if(Datas.chart_data_type == 'monthly'){
          var dte = Highcharts.dateFormat('%b',dataset[0])+" "+Highcharts.dateFormat('%Y',dataset[0]);
        }else if(Datas.chart_data_type == 'quaterly'){
          if (Highcharts.dateFormat('%b', dataset[0]) == 'Mar') {
            var dte = "Q1 "+Highcharts.dateFormat('%Y',dataset[0]);
          }
          if (Highcharts.dateFormat('%b', dataset[0]) == 'Jun') {
            var dte = "Q2 "+Highcharts.dateFormat('%Y',dataset[0]);
          }
          if (Highcharts.dateFormat('%b', dataset[0]) == 'Sep') {
            var dte = "Q3 "+Highcharts.dateFormat('%Y',dataset[0]);
          }
          if (Highcharts.dateFormat('%b', dataset[0]) == 'Dec') {
            var dte = "Q4 "+Highcharts.dateFormat('%Y',dataset[0]);
          }
        }else if(Datas.chart_data_type == 'anual'){
          var dte = Highcharts.dateFormat('%Y',dataset[0]);
        }else if(Datas.chart_data_type == 'daily'){
          var dte = Highcharts.dateFormat('%e',dataset[0])+" "+Highcharts.dateFormat('%b', dataset[0])+", "+Highcharts.dateFormat('%Y',dataset[0]);
        }
        data_formated[i_order] = [dte,dataset[1]];
      }
    }
  });
});
tableArray=({"heading":data_heading,"data":JSON.stringify(data_formated)});
chartArray[index]=({"table":tableArray});
}
}else{
  chartNotesArray[index]=$(this).find('div.noteContent').html();
  chartArray[index]='';
}
i++;
});
if(total_chart_len==0){
//Just trigger one ajax if it is not atleaet one chart
$.ajax({
  type: "POST",
  url: JMA.baseURL,
  data: 1,
  cache:false,
  async:true,
  crossDomain:true,
  success: function (data) {
  }
});
}
//If all the ajax is complete it will start to process
$(document).one("ajaxStop", function() {
  $.ajax({
    type: "POST",
    url: JMA.baseURL+"mycharts/power_point",
    data: {data:chartArray,titleArray:chartTitleArray,sourceArray:chartsourceArray,NotesArray:chartNotesArray,title:$('h1.folder-title').text()},
    dataType: "json",
    beforeSend: function (xhr) {
    },
    success: function(data){
      if(data.msg==true){
        $('i.ppt-spin').remove();
        var hidden_a = document.createElement("a");
        hidden_a.setAttribute("href", JMA.baseURL+data.dir+data.file);
        hidden_a.setAttribute("download", data.file);
        document.body.appendChild(hidden_a);
        if($.browser.safari){
          hidden_a.onclick=function(){
            document.body.removeChild(hidden_a);
          }
          var cle = document.createEvent("MouseEvent");
          cle.initEvent("click", true, true);
          hidden_a.dispatchEvent(cle);
        }else{
          hidden_a.click();
          document.body.removeChild(hidden_a);
        }
      }else{
        alert(data.msg);
      }
    },
    error: function(data) {
      alert(data.statusText+data.status+' Something went wrong');
    }
  });
});
}else{
  alert ('you dont have any charts');
}
});
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