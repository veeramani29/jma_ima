<!-- Templates Start -->
<script type="text/html" id="template_graph_full" > 


<div class="h_graph_wrap notranslate pad0 {{#if chart_details.isRightPannel}}col-md-8 col-xs-12{{else}}{{/if}}" id="h_graph_wrap_{{chart_details.chartIndex}}">
<div class="h_graph_graph_area">
<div class="h_graph_top_area">
{{#if chart_details.isRightPannel}}
{{#unless mychart_details.isMyChart}}
<div class="EDHeading">
<ul class="list-inline list_graphhead">
<li class="nav_edittabs">
<div class="ExportHeading graph-nav">
<div class="nav-txt nav-txt-export"> 
<i class="fa fa-pencil" style="color:#e60013"></i>&nbsp;Edit
</div>
</li>
<li>
<div class="ExportHeading graph-nav" id="EXDOW" >
<div class="nav-txt nav-txt-export"> 
<i class="fa fa-download" style="color:#e60013"></i>&nbsp;EXPORT
</div>
<div class="Exports sub-nav">
<div id="FloatLeft"></div>
<div id="" class="ExportItem1">
<select id="export_chart_image_select_format_{{chart_details.chartIndex}}" class="addmore-select form-control">
<option value="csv">Data (CSV)</option>
<option value="jpeg">Image (JPEG)</option>
<option value="png">Image (PNG)</option>
<option value="pdf">Document (PDF)</option>
<option value="ppt">PowerPoint (PPTX)</option>
</select>
<input type="button" class="btn btn-primary btn-sm" value="Export" id="export" onClick="exportChart_({{chart_details.chartIndex}});">
</div>
</div>
</div>
</li>
<li>
<div class="ExportHeading graph-nav" id="EXDOW" >
<div class="nav-txt nav-txt-save"> <i class="fa fa-line-chart" style="color:#e60013"></i>&nbsp;SAVE</div>
<div class="Folders sub-nav">
<div id="FloatLeft"></div>
<div id="" class="ExportItem1">
<select id="save_chart_select_folder_{{chart_details.chartIndex}}" class="addmore-select form-control mychart-select-addto-folder">
{{#mychart_details.folderList}}
<option value="{{folder_id}}">{{folder_name}}</option>
{{/mychart_details.folderList}}
</select>
<input type="button" class="btn btn-primary btn-sm" value="Save" id="save" onClick="saveThisChartToFolder_({{chart_details.chartIndex}});">
</div>
</div>
</div>
</li>
<li>
{{#if mychart_details.isAuthor}}
<div class="ExportHeading graph-nav" id="EXDOW" >
<a class="nav-txt nav-txt-save"> <i class="fa fa-area-chart" aria-hidden="true"></i>&nbsp; Save Chartbook</a>
<div class="Folders sub-nav">
<div id="FloatLeft"></div>
<div id="" class="ExportItem1">
<select id="save_chartbook_select_folder_{{chart_details.chartIndex}}" class="addmore-select form-control chartBook-select-addto-folder">
{{#mychart_details.chartBookLists}}
<option value="{{folder_id}}">{{folder_name}}</option>
{{/mychart_details.chartBookLists}}
</select>
<input type="button" class="btn btn-primary btn-sm" value="Save" id="save" onClick="saveThisChartToBook_({{chart_details.chartIndex}});">
</div>
</div>
</div>
{{/if}}
</li>
</ul>
</div>

</div>
{{/unless}}
{{else}}
{{#unless mychart_details.isMyChart}}
<div class="EDHeading">
<ul class="list-inline list_graphhead">
<li>
<div class="ExportHeading graph-nav" id="EXDOW" >
<a href="javascript:;" class="nav-txt nav-txt-export"><i class="fa fa-file-image-o"></i> EXPORT</a>
<div class="Exports sub-nav">
<div id="FloatLeft"></div>
<div id="" class="ExportItem1">
<select id="export_chart_image_select_format_{{chart_details.chartIndex}}" class="addmore-select form-control">
<option value="csv">Data (CSV)</option>
<option value="jpeg">Image (JPEG)</option>
<option value="png">Image (PNG)</option>
<option value="pdf">Document (PDF)</option>
<option value="ppt">PowerPoint (PPTX)</option>
</select>
<input type="button" class="btn btn-primary btn-sm" value="Export" id="export" onClick="exportChart_({{chart_details.chartIndex}});">
</div>
<div id="" class="ExportItem2" style="display:none">
<select id="export_chart_image_size_{{chart_details.chartIndex}}" class="addmore-select form-control">
<option value="small">Small</option>
<option value="medium">Medium</option>
<option value="large">Large</option>
</select>
<input type="button" class="btn btn-primary btn-sm" value="Export" id="export" onClick="exportChart_({{chart_details.chartIndex}});">
</div>
</div>
</div>
</li>
<!-- <li>
<div class="DownloadHeading graph-nav" id="EXDOW">
<a href="javascript:;"><i class="fa fa-download"></i> DOWNLOAD</a>
<div class="Downloads sub-nav">
<select id="download_data_select_format_{{chart_details.chartIndex}}" class="addmore-select form-control" >
<option value="csv">Comma seperated Value (CSV)</option>
</select>
<input type="button"  class="btn btn-primary btn-sm" value="Download" onClick="downloadChartData_({{chart_details.chartIndex}});" />
</div>
</div>
</li> -->
<li>
<div class="ExportHeading graph-nav" id="EXDOW" >
<a href="javascript:;" class="nav-txt nav-txt-save"><i class="fa fa-line-chart"></i> SAVE</a>
<div class="Folders sub-nav">
<div id="FloatLeft"></div>
<div id="" class="ExportItem1">
<select id="save_chart_select_folder_{{chart_details.chartIndex}}" class="addmore-select form-control mychart-select-addto-folder ">
{{#mychart_details.folderList}}
<option value="{{folder_id}}">{{folder_name}}</option>
{{/mychart_details.folderList}}
</select>
<input type="button" class="btn btn-primary btn-sm" value="Save" id="save" onClick="saveThisChartToFolder_({{chart_details.chartIndex}});">
</div>
</div>
</li>
<li>
{{#if mychart_details.isAuthor}}
<div class="ExportHeading graph-nav" id="EXDOW" >
<a class="nav-txt nav-txt-save"> <i class="fa fa-area-chart" aria-hidden="true"></i>&nbsp; SAVE CHARTBOOK</a>
<div class="Folders sub-nav">
<div id="FloatLeft"></div>
<div id="" class="ExportItem1">
<select id="save_chartbook_select_folder_{{chart_details.chartIndex}}" class="addmore-select form-control chartBook-select-addto-folder">
{{#mychart_details.chartBookLists}}
<option value="{{folder_id}}">{{folder_name}}</option>
{{/mychart_details.chartBookLists}}
</select>
<input type="button" class="btn btn-primary btn-sm" value="Save" id="save" onClick="saveThisChartToBook_({{chart_details.chartIndex}});">
</div>
</div>
</div>
{{/if}}
</li>
</ul>
</div>
</div>
{{/unless}}
{{/if}}
<form name="frm_download_chart_data_{{chart_details.chartIndex}}" id="frm_download_chart_data_{{chart_details.chartIndex}}" method="post" action="<?php echo $this->url('chart/downloadxls');?>">
<input type="hidden" id="frm_input_download_chart_codes_{{chart_details.chartIndex}}" name="chart_codes" value="">
<input type="hidden" id="frm_input_download_chart_datatype_{{chart_details.chartIndex}}" name="chart_datatype" value="">
</form>
</div>
<div class="h_graph_content_area" >
<div class="" id="Jma_chart_container_{{chart_details.chartIndex}}">
</div>
</div>
</div>
</div>
{{#if chart_details.isRightPannel}}
<div class="mcem_toggle">
  <div class="mcemt_ttl">
    <div class="mcemt_bg"></div>
    <i class="fa fa-angle-left"></i>
  </div>
</div>
<div class="col-md-4 col-xs-12 pad0 h_graph_tab_area">
<ul class="nav nav-tabs navtab-sm">
<li class="active"><a data-toggle="tab" chart_index="{{chart_details.chartIndex}}" href="#Dv_dataseries_{{chart_details.chartIndex}}">Series</a></li>
<li><a data-toggle="tab"  chart_index="{{chart_details.chartIndex}}"  href="#Dv_download_{{chart_details.chartIndex}}">Download</a></li>
{{#unless mychart_details.isMyChart}}
<li class="mdl Graph_tabset_tab_head_share"><a data-toggle="tab"  chart_index="{{chart_details.chartIndex}}"  href="#Dv_share_{{chart_details.chartIndex}}">Share</a></li>
{{/unless}}
</ul>
<div class="tab-content">
<div id="Dv_dataseries_{{chart_details.chartIndex}}" class="tab-pane fade in active">
&nbsp;
</div>
<div id="Dv_download_{{chart_details.chartIndex}}" class="tab-pane fade">
<div>
<div><h5 class="addmore">Export Chart</h5></div>
<div>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr><td align="left">
Export as
</tr></td>
<tr><td align="center">
<select id="tab_export_chart_image_select_format_{{chart_details.chartIndex}}" class="addmore-select form-control">
<option value="csv">Data (CSV)</option>
<option value="jpeg">Image (JPEG)</option>
<option value="png">Image (PNG)</option>
<option value="pdf">Document (PDF)</option>
<option value="ppt">PowerPoint (PPTX)</option>
</select>
</tr></td>
<tr><td align="left" style="display:none">
Select size
</tr></td>
<tr><td align="center" style="display:none">
<select id="export_chart_image_size_{{chart_details.chartIndex}}" class="addmore-select form-control">
<option value="small">Small</option>
<option value="medium">Medium</option>
<option value="large">Large</option>
</select>
</tr></td>
<tr><td align="center">
<input type="button" class="btn btn-primary btn-sm" value="Export" onClick="exportTabChart_({{chart_details.chartIndex}});">&nbsp;&nbsp;
<input type="button" class="btn btn-primary btn-sm" value="Print" onClick="printChart_({{chart_details.chartIndex}});">
</tr></td>
</table>
</div>
</div>
</div>
<div id="Dv_share_{{chart_details.chartIndex}}" class="tab-pane fade" >
<div class="hgta_socsha">
<h5>Share on Social Media</h5>
<ul class="list-inline">
<li><a href="javascript:void(0)" class="share" link_input_id="graph_share_url_{{chart_details.chartIndex}}" stype="facebook"title="Share on facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
<li><a href="javascript:void(0)" class="share" link_input_id="graph_share_url_{{chart_details.chartIndex}}" stype="twitter"title="Share on twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
<li><a href="javascript:void(0)" class="share" link_input_id="graph_share_url_{{chart_details.chartIndex}}" stype="google" title="Share on google+"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
<li><a href="javascript:void(0)" class="share" link_input_id="graph_share_url_{{chart_details.chartIndex}}" stype="linkedin" title="Share on linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
</ul>
</div>
<div>
<div class="spacer10"></div>
<div class="social_share_buttons">
<h5 class="">Share Link</h5>
<div class="social_share_button">
<input type="text" class="graph_share_input form-control" name="graph_share_url_{{chart_details.chartIndex}}" id="graph_share_url_{{chart_details.chartIndex}}" value="<?php echo '//'.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'];?>" onclick="this.select()" readonly>
<button class="btn btn-primary clipboard_copy" data-clipboard-action="copy" data-clipboard-target="#graph_share_url_{{chart_details.chartIndex}}" data-placement="bottom">Copy URL</button>
</div>
</div>
</div>
</div>
</div>
</div>
{{/if}}
</div>
</div>
</script>
<script type="template/alanee" id="template_graph_section_series">

<div>
<div class="graph-list" id="Dv_placeholder_graph_series_section_{{chartIndex}}">
{{#each current_series}} 
<div class="graph-line" id="Dv_placeholder_graph_currentseries_select_{{../chartIndex}}_{{@index}}">
<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-minus" onClick="SeriesColorDropdown_({{../chartIndex}},{{@index}},this)" ></i>
</div>
<select class="form-control" onChange="populateYSubDropdown_({{../chartIndex}},{{@index}},this)">
{{#each series}}
<option value="{{@index}}" {{#if isCurrent}}selected{{/if}}>{{label}}</option>
{{/each}}
</select>

</div>


{{#each series}}
{{#if isCurrent}}
<div class="Dv_placeholder_graph_currentseries_ysub_select">
{{#if ../../../isYieldDailyChart}}

{{#ifCond ../../../../chart_data_type '==' 'yield_monthly'}}
<input placeholder="yyyy/mm"  type="text" data-first='{{series.[0].label}}'  onChange="replaceThisGraphCode_({{../../../../../chartIndex}},{{@../index}},this)" data-last='{{get_lastelm series}}' data-chartindex='{{../../../../../chartIndex}}' value="{{find_Currentval series}}" maxlength="10" data-value="{{series.0.code}}"  class="form-control yield_monthly_datepicker"  />
{{else}}


<input placeholder="yyyy/mm/dd"  type="text" data-first='{{series.[0].label}}'  onChange="replaceThisGraphCode_({{../../../../../chartIndex}},{{@../index}},this)" data-last='{{get_lastelm series}}' data-chartindex='{{../../../../../chartIndex}}' value="{{find_Currentval series}}" maxlength="10" data-value="{{series.0.code}}"  class="form-control yield_daily_datepicker"  />
{{/ifCond}}
{{else}}
<select class="chart-select form-control" onChange="replaceThisGraphCode_({{../../../../chartIndex}},{{@../index}},this)">
{{#each series}}
<option value="{{code}}" {{#if isCurrent}}selected{{/if}}>{{label}}</option>
{{/each}}
</select>
{{/if}}
</div>
{{/if}}
{{/each}}
<div class="graph-line-controls">{{#ifCond @index '>' 0}}<a href="javascript:void(0)" onClick="removeThisChartCodeByIndex_({{../../chartIndex}},{{@index}})">Remove</a>{{/ifCond}}</div>
</div>
{{/each}}
</div>
{{#if isAddMoreseries}}
<div class="graph-addmore">
<span class="addmore marb20">Add More Series</span>
<select id="select_series_addmore-select_{{chartIndex}}" class="addmore-select form-control">
{{#each available_series}}
<option value="{{code}}">{{label}}</option>
{{/each}}
</select>
<div class="dv_addmore-button"><a class="addmore-button" href="javascript:void(0)" onClick="addThisGraphCode_({{chartIndex}})">Add more</a></div>
</div>
{{/if}}
{{#ifCond isBarChart '!=' true}}
<div>
<label class="control control--checkbox">Multiple yAxis
<input type="checkbox" value="checkbox" name="multiaxis_checkbox__{{chartIndex}}" id="multiaxis_checkbox__{{chartIndex}}" {{#if isMultiAxis}}checked{{/if}} onClick="switchToMultiAxisLine_({{chartIndex}},this);"/>
<div class="control__indicator"></div>
</label>
</div>
{{/ifCond}}
<div>
<label class="control control--checkbox">Bar chart
<input type="checkbox" value="checkbox" name="barchart_checkbox__{{chartIndex}}" id="barchart_checkbox__{{chartIndex}}" {{#if isBarChart}}checked{{/if}} onClick="switchToBarChart_({{chartIndex}},this);"/>
<div class="control__indicator"></div>
</label>
</div>


</div>
</script>

<!-- Template End -->


