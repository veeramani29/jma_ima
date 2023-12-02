<script type="template/alanee" id="template_mychart_folder_content_list_layout">
<div draggable="false" class="chart_listview exhibit{{#if isDisabled}} chart_disabled{{/if}}" data-order="{{order}}" data-uuid="{{uuid}}"></div>
</script>
<!-- Templates ...   -->
<script type="template/alanee" id="template_mychart_folder_content">
<div class="page large-view mychart_pagecon">
<div class="col-xs-12">
<div class="grids row" id="grids">
</div>
</div>
</div>
</script>
<script type="template/alanee" id="template_mychart_folder_content_smallView">
<div class="page large-view mychart_pagecon">
<div class="col-xs-12">
<div class="grids row" id="smallView_grids">
<div class="main-title small_minttl"></div>
</div>
</div>
</div>
</script>
<script type="template/alanee" id="template_mychart_folder_content_chart_layout">
<div draggable="false" class="col-xs-12 col-lg-6 exhibit{{#if isDisabled}} chart_disabled{{/if}}" data-order="{{order}}" data-uuid="{{uuid}}">
<div class="sub-title ">
<h5 class="exhibit-title">{{title}}</h5>
<div class="sttl-line"></div>
</div>
<div class="data-views">
<div class="table-view hide" id="Dv_placeholder_tableView_{{uuid}}"></div>
<div class="graph-view" id="Dv_placeholder_graphView_{{uuid}}">
</div>
</div>
{{#if editOption}}
<div class="charts_exhtabs">
<ul class="exhibit-tab">
<li class="selected" data-view="chart" data-order="{{order}}"><a draggable="false" href="#"><i class="fa fa-line-chart"></i>Chart</a></li>
<li data-view="data" data-order="{{order}}"><a draggable="false" href="#"><i class="fa fa-table"></i>Table</a></li>
</ul>
<ul class="abs-menus">
<li class="floatleft"><a draggable="false" href="#" class="chart_options"><i class="fa fa-bars"></i>Menu</a>
<ul class="foldercontent-sub-menu">
<li class="duplicate"><a draggable="false" href="#"><i class="fa fa-copy"></i>Duplicate</a></li>
<li class="make-note-ex"><a draggable="false" href="#"><i class="fa fa-file-o"></i>Make a note</a></li>
<li class="delete-ex"><a draggable="false" href="#"><i class="fa fa-remove"></i>Delete</a></li>
<li><a draggable="false" href="#" class="mychart_download_data"><i class="fa fa-download"></i>Download data</a></li>
<li><a draggable="false" href="#" class="mychart_export"><i class="fa fa-file-photo-o"></i>Export</a></li>
</ul>
</li>
<li class="floatleft mychart-menu-edit"><a draggable="false" href="#" class="chart_edit"><i class="fa fa-cog"></i>Edit</a></li>
</ul>
</div>
{{/if}}
{{#unless editOption}}
<div class="charts_exhtabs chabok_user">
<ul class="exhibit-tab">
<li  data-order="{{order}}"></li>
</ul>
</div>
{{/unless}}
</div>
</script>
<script type="template/alanee" id="template_mychart_folder_content_chart_smallView_layout">
<div draggable="false" class="col-xs-12 col-lg-6 exhibit{{#if isDisabled}} chart_disabled{{/if}}" data-order="{{order}}" data-uuid="{{uuid}}">
<div class="sub-title ">
<h5 class="exhibit-title">{{title}}</h5>
<div class="sttl-line"></div>
</div>
<div class="data-views">
<div class="table-view hide" id="Dv_placeholder_tableView_small_{{uuid}}"></div>
<div class="graph-view" id="Dv_placeholder_graphView_small_{{uuid}}">
</div>
</div>

{{#if editOption}}
<div class="charts_exhtabs">
<ul class="exhibit-tab">
<li class="selected" data-view="chart" data-order="{{order}}"><a draggable="false" href="#"><i class="fa fa-line-chart"></i>Chart</a></li>
<li data-view="data" data-order="{{order}}"><a draggable="false" href="#"><i class="fa fa-table"></i>Table</a></li>
</ul>
<ul class="abs-menus">
<li class="floatleft"><a draggable="false" href="#" class="chart_options"><i class="fa fa-bars"></i>Menu</a>
<ul class="foldercontent-sub-menu">
<li class="duplicate"><a draggable="false" href="#"><i class="fa fa-copy"></i>Duplicate</a></li>
<li class="make-note-ex"><a draggable="false" href="#"><i class="fa fa-file-o"></i>Make a note</a></li>
<li class="delete-ex"><a draggable="false" href="#"><i class="fa fa-remove"></i>Delete</a></li>
<li><a draggable="false" href="#" class="mychart_download_data"><i class="fa fa-download"></i>Download data</a></li>
<li><a draggable="false" href="#" class="mychart_export"><i class="fa fa-file-photo-o"></i>Export</a></li>
</ul>
</li>
<li class="floatleft mychart-menu-edit"><a draggable="false" href="#" class="chart_edit"><i class="fa fa-cog"></i>Edit</a></li>
</ul>
</div>
{{/if}}
{{#unless editOption}}
<div class="charts_exhtabs">
<ul class="exhibit-tab">
<li class="selected" data-view="chart" data-order="{{order}}"></li>
</ul>
</div>
{{/unless}}
</div>
</script>
<script type="template/alanee" id="template_mychart_folder_content_note_layout">
<div class="col-xs-12 col-lg-6 exhibit note{{#if isDisabled}} chart_disabled{{/if}}" data-order="{{order}}" data-uuid="{{uuid}}">
<div class="sub-title ">
<h5 contenteditable="false" class="exhibit-title" id="Dv_placeholder_noteTitle_{{uuid}}">{{title}}</h5>
<div class="sttl-line"></div>
</div>
<div class="noteContent" id="Dv_placeholder_noteContent_{{uuid}}" contenteditable="false"></div>
{{#if editOption}}
<ul class="abs-menus">
<li class="floatleft"><a draggable="false" href="#" class="chart_options"><i class="fa fa-bars"></i>Menu</a>
<ul class="foldercontent-sub-menu">
<li class="duplicate"><a href="#"><i class="fa fa-copy"></i>Duplicate</a></li>
<li class="make-note-ex"><a href="#"><i class="fa fa-file-o"></i>Make a note</a></li>
<li class="delete-note-ex"><a href="#"><i class="fa fa-remove"></i>Delete</a></li>
</ul>
</li>
</ul>
{{/if}}
</div>
</script>
<script type="template/alanee" id="template_mychart_folder_content_note_smallView_layout">
<div class="col-xs-12 col-lg-6 exhibit note{{#if isDisabled}} chart_disabled{{/if}}" data-order="{{order}}" data-uuid="{{uuid}}">
<div class="sub-title ">
<h5 contenteditable="false" class="exhibit-title" id="Dv_placeholder_noteTitle_small_{{uuid}}">{{title}}</h5>
<div class="sttl-line"></div>
</div>
<div class="noteContent" id="Dv_placeholder_noteContent_{{uuid}}" contenteditable="false"></div>
{{#if editOption}}
<ul class="abs-menus">
<li class="floatleft"><a draggable="false" href="#" class="chart_options"><i class="fa fa-bars"></i>Menu</a>
<ul class="foldercontent-sub-menu">
<li class="duplicate"><a href="#"><i class="fa fa-copy"></i>Duplicate</a></li>
<li class="make-note-ex"><a href="#"><i class="fa fa-file-o"></i>Make a note</a></li>
<li class="delete-note-ex"><a href="#"><i class="fa fa-remove"></i>Delete</a></li>
</ul>
</li>
</ul>
{{/if}}
</div>
</script>