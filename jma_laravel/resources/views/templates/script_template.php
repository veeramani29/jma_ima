<!-- Templates Start -->
<script type="text/html" id="template_graph_full" >
<div class="h_graph_wrap notranslate pad0 {{#if chart_details.isRightPannel}}col-md-8 col-xs-12{{else}}{{/if}}" id="h_graph_wrap_{{chart_details.chartIndex}}">
	<div class="h_graph_graph_area">
		<div class="h_graph_top_area">
			{{#if chart_details.isRightPannel}}
			{{#unless mychart_details.isMyChart}}
			<div class="EDHeading">
				<ul class="list-inline list_graphhead">
					<li>
						<div class="ExportHeading graph-nav ExportHeading-share graph-nav-share" id="EXDOW" >
							<a class="nav-txt nav-txt-export-share">
								<i class="fa fa-share-alt" data-toggle="tooltip"  title="Share&nbsp;Chart"></i>
							</a>
							<ul class="list-inline list_share sub-nav Exports">
								<li onClick="All_share('{{chart_details.chartIndex}}','facebook');"><i class="fa fa-facebook" aria-hidden="true" ></i></li>
								<li onClick="All_share('{{chart_details.chartIndex}}','twitter');"><i class="fa fa-twitter" aria-hidden="true" ></i></li>
								<li onClick="All_share('{{chart_details.chartIndex}}','google+');"><i class="fa fa-google-plus" aria-hidden="true" ></i></li>
								<li onClick="All_share('{{chart_details.chartIndex}}','linkedin');"><i class="fa fa-linkedin" aria-hidden="true" ></i></li>
							</ul>
						</div>
					</li>
					<li>
						<div class="ExportHeading graph-nav">
							<a href="javascript:;" class="nav-txt nav-txt-annotation"><i class="fa fa-pencil-square-o" aria-hidden="true" data-toggle="tooltip" title="Add&nbsp;Annotations"></i></a>
							<ul data-chartObj="{{chart_details.chartIndex}}" class="list-inline list_annotations sub-nav Exports">
								<li data-aType="3" class="">T</li>
								<li data-aType="2"><i class="fa fa-square-o" aria-hidden="true"></i></li>
								<li data-aType="1" class="las_line"><span>/</span></li>
								<li data-aType="0"><i class="fa fa-circle-o" aria-hidden="true"></i></li>
								<li class="las_note">
									<span data-toggle="tooltip" title="Select&nbsp;and&nbsp;drag">Drag</span>
									<span data-toggle="tooltip" title="Select&nbsp;and&nbsp;doubleclick">Delete</span>
									<span data-toggle="tooltip" title="Click&nbsp;hold&nbsp;and&nbsp;drag">Size control</span>
								</li>
							</ul>
						</div>
					</li>
					<li>
						<div class="ExportHeading graph-nav" id="EXDOW" >
							<div class="nav-txt nav-txt-export">
								<i class="fa fa-download" data-toggle="tooltip" title="Export&nbsp;Chart"></i>
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
									<input type="button" class="btn btn-primary btn-sm" value="Print" onClick="printChart_({{chart_details.chartIndex}});">
								</div>
								<div class="nte_mobexp">
									<ul data-mobileobj="{{chart_details.chartIndex}}" class="list-inline mobile-export">
										<li data-value="csv">CSV</li>
										<li data-value="jpeg">JPEG</li>
										<li data-value="png">PNG</li>
										<li data-value="pdf">PDF</li>
										<li data-value="ppt">PPTX</li>
									</ul>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="ExportHeading graph-nav" id="EXDOW" >
							<div class="nav-txt nav-txt-save"> <i class="fa fa-floppy-o" data-toggle="tooltip" title="Save&nbsp;Chart"></i></div>
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
					<div class="ExportHeading graph-nav ExportHeading-share graph-nav-share" id="EXDOW" >
						<a class="nav-txt nav-txt-export-share">
							<i class="fa fa-share-alt" data-toggle="tooltip"  title="Share&nbsp;Chart"></i>
						</a>
						<ul class="list-inline list_share sub-nav Exports">
							<li onClick="All_share('{{chart_details.chartIndex}}','facebook');"><i class="fa fa-facebook" aria-hidden="true" ></i></li>
							<li onClick="All_share('{{chart_details.chartIndex}}','twitter');"><i class="fa fa-twitter" aria-hidden="true" ></i></li>
							<li onClick="All_share('{{chart_details.chartIndex}}','google+');"><i class="fa fa-google-plus" aria-hidden="true" ></i></li>
							<li onClick="All_share('{{chart_details.chartIndex}}','linkedin');"><i class="fa fa-linkedin" aria-hidden="true" ></i></li>
						</ul>
					</div>
				</li>
				<li>
					<div class="ExportHeading graph-nav">
						<a href="javascript:;" class="nav-txt nav-txt-annotation"><i class="fa fa-pencil-square-o" aria-hidden="true" data-toggle="tooltip" title="Add&nbsp;Annotations"></i></a>
						<ul data-chartObj="{{chart_details.chartIndex}}" class="list-inline list_annotations sub-nav Exports">
							<li data-aType="3" class="">T</li>
							<li data-aType="2"><i class="fa fa-square-o" aria-hidden="true"></i></li>
							<li data-aType="1" class="las_line"><span>/</span></li>
							<li data-aType="0"><i class="fa fa-circle-o" aria-hidden="true"></i></li>
							<li class="las_note">
								<span data-toggle="tooltip" title="Select&nbsp;and&nbsp;drag">Drag</span>
								<span data-toggle="tooltip" title="Select&nbsp;and&nbsp;doubleclick">Delete</span>
								<span data-toggle="tooltip" title="Click&nbsp;hold&nbsp;and&nbsp;drag">Size control</span>
							</li>
						</ul>
					</div>
				</li>
				<li>
					<div class="ExportHeading graph-nav" id="EXDOW" >
						<a href="javascript:;" class="nav-txt nav-txt-export"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" title="Export&nbsp;Chart"></i></a>
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
								<input type="button" class="btn btn-primary btn-sm" value="Print" onClick="printChart_({{chart_details.chartIndex}});">
							</div>
							<div class="nte_mobexp">
								<ul data-mobileobj="{{chart_details.chartIndex}}" class="list-inline mobile-export">
									<li data-value="csv">CSV</li>
									<li data-value="jpeg">JPEG</li>
									<li data-value="png">PNG</li>
									<li data-value="pdf">PDF</li>
									<li data-value="ppt">PPTX</li>
								</ul>
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
						<a href="javascript:;"><i class="fa fa-download" data-toggle="tooltip" title="Export&nbsp;Chart"></i></a>
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
						<a href="javascript:;" class="nav-txt nav-txt-save"><i class="fa fa-floppy-o" aria-hidden="true" data-toggle="tooltip" title="Save&nbsp;Chart"></i></a>
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
	<form name="frm_download_chart_data_{{chart_details.chartIndex}}" id="frm_download_chart_data_{{chart_details.chartIndex}}" method="post" action="<?php echo url('chart/downloadxls');?>">
		<input type="hidden" id="frm_input_download_chart_codes_{{chart_details.chartIndex}}" name="chart_codes" value="">
		<input type="hidden" id="frm_input_download_chart_datatype_{{chart_details.chartIndex}}" name="chart_datatype" value="">
		<input type="hidden"  name="_token" value="<?php echo csrf_token();?>">
	</form>
</div>
<div id='Table_Dv_placeholder_{{chart_details.chartIndex}}' ></div>
<div class="h_graph_content_area_{{chart_details.chartIndex}}" >
	<div class="" id="Jma_chart_container_{{chart_details.chartIndex}}">
	</div>
</div>
<div class="nav_editab">
	{{#if chart_details.isRightPannel}}
	<div class="net_ttl">
		<div class="net_bg"></div>
		<i class="fa fa-angle-left"></i>
	</div>
	{{/if}}
</div>
<div class="exhtabs_charts">
	<ul class="exhibit-tab-footer_{{chart_details.chartIndex}}">
		{{#if chart_details.graphChartOption}}
		<li class="selected" data-view="chart" data-order="{{order}}"><a draggable="false"><i class="fa fa-line-chart"></i>Chart</a></li>
		{{else}}
		<li  data-view="chart" data-order="{{order}}"><a draggable="false"><i class="fa fa-line-chart"></i>Chart</a></li>
		{{/if}}
		{{#if chart_details.graphTableOption}}
		<li class="selected ecs_table" data-view="data" data-order="{{order}}"><a draggable="false"><i class="fa fa-table"></i>Table</a></li>
		{{else}}
		<li class="ecs_table" data-view="data" data-order="{{order}}"><a draggable="false"><i class="fa fa-table"></i>Table</a></li>
		{{/if}}
	</ul>
	<div class="ec_expcol" style="display:none;">
		<i class="fa fa-expand" aria-hidden="true"></i>
		<i class="fa fa-compress" aria-hidden="true" style="display:none;"></i>
	</div>
</div>
</div>
</div>
{{#if chart_details.isRightPannel}}
<div class="col-md-4 col-xs-12 pad0 h_graph_tab_area">
	<ul class="nav nav-tabs navtab-sm">
		<li class="active"><a data-toggle="tab" chart_index="{{chart_details.chartIndex}}" href="#Dv_dataseries_{{chart_details.chartIndex}}">Series</a></li>
		{{#unless mychart_details.isMyChart}}
		<li class="mdl Graph_tabset_tab_head_share"><a data-toggle="tab" chart_index="{{chart_details.chartIndex}}"  href="#Dv_share_{{chart_details.chartIndex}}">Share</a></li>
		{{/unless}}
	</ul>
	<div class="tab-content">
		<div id="Dv_dataseries_{{chart_details.chartIndex}}" class="tab-pane fade in active">
			&nbsp;
		</div>
		<div id="Dv_download_{{chart_details.chartIndex}}" class="tab-pane fade">
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
						<button class="btn btn-primary clipboard_copy" data-clipboard-action="copy" data-clipboard-target="#graph_share_url_{{chart_details.chartIndex}}">Copy URL</button>
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
<script type="template/alanee" id="template_chart_footer_layout">
<div draggable="false" id="switch_to_tabble_indicator_{{chart_details.chartIndex}}" class="exhibit{{#if isDisabled}} chart_disabled{{/if}} hidden" data-order="{{order}}" data-uuid="{{uuid}}">
	<div class="data-views">
		<div class="table-view hide" id="Dv_placeholder_tableView_{{uuid}}"></div>
		<div class="graph-view" id="Dv_placeholder_graphView_{{uuid}}"></div>
	</div>
</div>
</script>
<script type="template/alanee" id="template_graph_section_series">
<div>
	<div class="graph-list" id="Dv_placeholder_graph_series_section_{{chartIndex}}">
		{{#each current_series}}
		<div class="graph-line" id="Dv_placeholder_graph_currentseries_select_{{../chartIndex}}_{{@index}}">
			{{#ifCond ../chartType '!=' 'map'}}
			<div class="input-group">
				<div class="input-group-addon speico-con">
					<input type="text" id="spec-colpic_{{../../chartIndex}}_{{@index}}" class="basicsss1" data-param1="{{../../chartIndex}}" data-param2="{{@index}}" />
					<button class="sercol-btn">
					<i class="fa fa-minus" onClick="SeriesColorDropdown_({{../../chartIndex}},{{@index}},this)"></i>
					<i class="spec-color"></i>
					</button>
				</div>
				{{/ifCond}}
				<select class="form-control" onChange="populateYSubDropdown_({{../chartIndex}},{{@index}},this)">
					{{#each series}}
					<option value="{{@index}}" {{#if isCurrent}}selected{{/if}}>{{label}}</option>
					{{/each}}
				</select>
				{{#ifCond chartType '!=' 'map'}}
			</div>
			{{/ifCond}}
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
	{{#ifCond chartType '==' 'map'}}
	<div class="{{#ifCond chart_data_type '==' 'daily'}}Dv_placeholder_graph_currentseries_ysub_select {{/ifCond}}">
		{{#ifCond chart_data_type '==' 'anual'}}
		<select class="chart-select form-control selectpicker" id="default_year_{{chartIndex}}" data-live-search="true" onChange="replaceThisGraphCode_({{chartIndex}},'map',this)">
			{{#each YearRangeformap}}
			<option ="{{yr}}" {{#if isCurrent}}selected{{/if}}>{{yr}}</option>
			{{/each}}
		</select>
{{else}}
		<input placeholder="yyyy/mm/dd" data-first='{{YearRangeformap.[0].yr}}' data-type='map' value="{{find_Currentval YearRangeformap}}"    data-last='{{get_lastelm YearRangeformap}}' type="text" onChange="replaceThisGraphCode_({{chartIndex}},'map',this)"  data-chartindex='{{chartIndex}}' maxlength="10" data-value="{{YearRangeformap.[0].yr}}"  class="form-control yield_daily_datepicker"  />
{{/ifCond}}
	</div>
	{{/ifCond}}
	{{#if isAddMoreseries}}
		{{#ifCond chart_data_type '=^' 'yield'}}
			<div class="graph-addmore">
				<span class="addmore marb20">Add More Series</span>
				<select id="select_series_addmore-select_{{chartIndex}}" class="addmore-select form-control">
					{{#each available_series}}
					<option value="{{code}}">{{label}}</option>
					{{/each}}
				</select>
				<div class="dv_addmore-button"><a class="addmore-button" href="javascript:void(0)" onClick="addThisGraphCode_({{chartIndex}})">Add more</a></div>
			</div>
			{{else}}
			{{#ifCond ./chartType '!=' 'map'}}
				{{#ifCond ./isDesktop '==' true }}
					<div class="demo-1">
						<div class="addmor-menu dl-menuwrapper">
							<button class="dl-trigger btn btn-primary"><i class="fa fa-line-chart" aria-hidden="true"></i>Add More Series</button>
							<ul class='dl-menu'>
	              <?php if(isset($menu_items['Add_More_Section'])) {
						      echo  $menu_items['Add_More_Section']; 
						    } ?>
					    </ul>
						</div>
					</div>
		    {{else}}
					<ul class="nav navbar-nav addser-drpbtn graph-addmore">
		        <li>
		          <a href="#" class="btn-admor dropdown-toggle btn btn-primary" data-toggle="dropdown"><i class="fa fa-line-chart" aria-hidden="true"></i>Add More Series <b class="caret"></b></a>
		          <ul class="dropdown-menu multi-level">
		          	<?php if(isset($menu_items['Add_More_Section'])) {
									echo  $menu_items['Add_More_Section']; 
								} ?>
							</ul>
		        </li>
		      </ul>
				{{/ifCond}}
			{{/ifCond}}
		{{/ifCond}}
	{{/if}}
	{{#ifCond chartType '!=' 'map'}}
	<div class="gra-diffaxis">
		<label class="control gd-label control--checkbox">Multiple yAxis
			<input type="checkbox" value="checkbox" name="multiaxis_checkbox__{{chartIndex}}" id="multiaxis_checkbox__{{chartIndex}}" {{#if isMultiAxis}}checked{{/if}} onClick="switchToMultiAxisLine_({{chartIndex}},this);"/>
			<div class="control__indicator"></div>
		</label>
		<label class="control gd-label control--checkbox">Bar chart
			<input type="checkbox" value="checkbox" name="barchart_checkbox__{{chartIndex}}" id="barchart_checkbox__{{chartIndex}}" {{#if isBarChart}}{{#if graphTableOption}}{{else}}checked{{/if}}{{/if}} onClick="switchToBarChart_({{chartIndex}},this);"/>
			<div class="control__indicator"></div>
		</label>
		{{#if isMultiAxis}}
		 	<ul class="list-inline">
			 	<li><label class="control gd-label">Reverse Y axis</label></li>
			 	{{#each current_series}}
					<li>
						{{var "reversedAxis" (in_array ../reversedAxisAr @index)}}
						<label class="control control--checkbox revaxis-{{@index}}">&nbsp;
							<input type="checkbox" value="{{@index}}" name="reverse_checkbox" id="reverse_checkbox__{{../chartIndex}}" {{#if reversedAxis}}{{#if graphTableOption}}{{else}}checked{{/if}}{{/if}} onClick="JMA.JMAChart.reverseYAxis({{../chartIndex}},{{@index}});"/>
							<div class="control__indicator"></div>
						</label>
					</li>
				{{/each}}
			</ul>
		{{else}}
			<label class="control gd-label control--checkbox ">Reverse Y axis
				<input type="checkbox" value="0" name="reverse_checkbox__{{chartIndex}}" id="reverse_checkbox__{{chartIndex}}" {{#if isReverseY}}{{#if graphTableOption}}{{else}}checked{{/if}}{{/if}} onClick="JMA.JMAChart.reverseYAxis({{chartIndex}});"/>
				<div class="control__indicator"></div>
			</label>
		{{/if}}
	</div>
</div>
{{/ifCond}}
</script>
<!-- Template End -->