@extends('templates.default')
@section('content')
<div class="col-md-10 col-xs-12">
  <div class="row">
    <div class="col-xs-12">
      <div class="sec-date main-title">
        <span class="released">July 15, 2019</span>
        <h1 itemprop="name" class="">
        Tokoyo Map
        </h1>
        <div class="mttl-line"></div>
      </div>
      <div class="folussoc_con fus_indicator">
        <ul class="list_socail">
          <li class="fs_linkedin" data-toggle="tooltip" title="Share on Facebook">
            <a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          </li>
          <li class="fs_twitter" data-toggle="tooltip" title="Share on Twitter">
            <a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
          </li>
          <li class="fs_facebook" data-toggle="tooltip" title="Share on Google">
            <a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
          </li>
          <li class="fs_print" data-toggle="tooltip" title="Share&nbsp;on&nbsp;Linkedin">
            <a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
          </li>
          <?php $protocol_ = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
          ?>
          <input type="hidden" class="graph_share_input form-control" name="common_share_url" id="common_share_url" value="<?php echo  $protocol_.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'];?>">
        </ul>
      </div>
      <div class="map_chart">
        <div class="col-md-8">
          <div id="japan-map"></div>
        </div>
        <div class="col-md-4 mc-righea h_graph_wrap">
          <div class="row">
            <ul class="mcr-opt">
              <li>
                <div class="ExportHeading graph-nav ExportHeading-share graph-nav-share" id="EXDOW">
                  <a class="nav-txt nav-txt-export-share">
                    <i class="fa fa-share-alt" data-toggle="tooltip" title="" data-original-title="Share&nbsp;Chart"></i>
                  </a>
                  <ul class="list-inline list_share sub-nav Exports">
                    <li onclick=""><i class="fa fa-facebook" aria-hidden="true"></i></li>
                    <li onclick=""><i class="fa fa-twitter" aria-hidden="true"></i></li>
                    <li onclick=""><i class="fa fa-google-plus" aria-hidden="true"></i></li>
                    <li onclick=""><i class="fa fa-linkedin" aria-hidden="true"></i></li>
                  </ul>
                </div>
              </li>
              <li>
                <div class="ExportHeading graph-nav">
                  <a href="" class="nav-txt nav-txt-annotation">
                    <i class="fa fa-pencil-square-o" aria-hidden="true" data-toggle="tooltip" title="" data-original-title="Add&nbsp;Annotations"></i>
                  </a>
                  <ul class="list-inline list_annotations sub-nav Exports">
                    <li class="">T</li>
                    <li><i class="fa fa-square-o" aria-hidden="true"></i></li>
                    <li class="las_line"><span>/</span></li>
                    <li><i class="fa fa-circle-o" aria-hidden="true"></i></li>
                    <li class="las_note">
                      <span data-toggle="tooltip" title="" data-original-title="Select&nbsp;and&nbsp;drag">Drag</span>
                      <span data-toggle="tooltip" title="" data-original-title="Select&nbsp;and&nbsp;doubleclick">Delete</span>
                      <span data-toggle="tooltip" title="" data-original-title="Click&nbsp;hold&nbsp;and&nbsp;drag">Size control</span>
                    </li>
                  </ul>
                </div>
              </li>
              <li>
                <div class="ExportHeading graph-nav" id="EXDOW">
                  <div class="nav-txt nav-txt-export">
                    <i class="fa fa-download" data-toggle="tooltip" title="" data-original-title="Export&nbsp;Chart"></i>
                  </div>
                  <div class="Exports sub-nav">
                    <div id="FloatLeft"></div>
                    <div id="" class="ExportItem1">
                      <select id="" class="addmore-select form-control">
                        <option value="csv">Data (CSV)</option>
                        <option value="jpeg">Image (JPEG)</option>
                        <option value="png">Image (PNG)</option>
                        <option value="pdf">Document (PDF)</option>
                        <option value="ppt">PowerPoint (PPTX)</option>
                      </select>
                    </div>
                    <div class="nte_mobexp">
                      <ul data-mobileobj="0" class="list-inline mobile-export">
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
                <div class="ExportHeading graph-nav" id="EXDOW">
                  <div class="nav-txt nav-txt-save"> <i class="fa fa-floppy-o" data-toggle="tooltip" title="" data-original-title="Save&nbsp;Chart"></i></div>
                  <div class="Folders sub-nav">
                    <div id="FloatLeft"></div>
                    <div id="" class="ExportItem1">
                      <select id="" class="addmore-select form-control mychart-select-addto-folder">
                      </select>
                      <input type="button" class="btn btn-primary btn-sm" value="Save" onclick="">
                    </div>
                  </div>
                </div>
              </li>
            </ul>
            <div class="col-xs-12">
              <form action="">
                <div class="form-group">
                  <select name="" id="" class="form-control">
                    <option value="" selected>Total Population</option>
                    <option value="">Male Population</option>
                    <option value="">Female Population</option>
                  </select>
                </div>
                <div class="form-group">
                  <select name="" id="" class="form-control">
                    <option value="" selected>Million</option>
                    <option value="">YoY, Million</option>
                    <option value="">YoY%</option>
                    <option value="">10yr Change Million</option>
                    <option value="">10yr Change %</option>
                  </select>
                </div>
                <div class="form-group">
                  <select class="selectpicker" data-live-search="true" >
                    <option>1990</option>
                    <option>1991</option>
                    <option>1992</option>
                    <option>1993</option>
                    <option>1994</option>
                    <option>1995</option>
                    <option>1996</option>
                    <option>1997</option>
                    <option>1998</option>
                    <option>1999</option>
                    <option>2000</option>
                    <option>2001</option>
                    <option>2002</option>
                    <option>2003</option>
                    <option>2004</option>
                    <option>2005</option>
                    <option>2006</option>
                    <option>2007</option>
                    <option>2008</option>
                    <option>2009</option>
                    <option>2010</option>
                  </select>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- hight chart scripts -->
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/jp/jp-all.js"></script>
<script>
// Prepare demo data
// Data is joined to map using value of 'hc-key' property by default.
// See API docs for 'joinBy' for more info on linking data and map.
var data = [{
  "hc-key": "jp-hs",
  "population": "5.2",
  "unit": "Million"
}, {
  "hc-key": "jp-sm",
  "population": "1.2",
  "unit": "Million",
}, {
  "hc-key": "jp-yc",
  "population": "1.2",
  "unit": "Million",
}, {
  "hc-key": "jp-km",
  "population": "2.3",
  "unit": "Million",
}, {
  "hc-key": "jp-eh",
  "population": "0.9",
  "unit": "Million",
}, {
  "hc-key": "jp-kg",
  "population": "1.1",
  "unit": "Million",
}, {
  "hc-key": "jp-is",
  "population": "1.8",
  "unit": "Million",
}, {
  "hc-key": "jp-hk",
  "population": "2.3",
  "unit": "Million",
}, {
  "hc-key": "jp-tk",
  "population": "13.8",
  "unit": "Million",
}, {
  "hc-key": "jp-3461",
  "population": "1.9",
  "unit": "Million",
}, {
  "hc-key": "jp-3457",
  "population": "1.9",
  "unit": "Million",
}, {
  "hc-key": "jp-ib",
  "population": "7.3",
  "unit": "Million",
}, {
  "hc-key": "jp-st",
  "population": "6.2",
  "unit": "Million",
}, {
  "hc-key": "jp-sg",
  "population": "2.8",
  "unit": "Million",
}, {
  "hc-key": "jp-yn",
  "population": "1.9",
  "unit": "Million",
}, {
  "hc-key": "jp-kn",
  "population": "1.4",
  "unit": "Million",
}, {
  "hc-key": "jp-fo",
  "population": "1.9",
  "unit": "Million",
}, {
  "hc-key": "jp-fs",
  "population": "3.6",
  "unit": "Million",
}, {
  "hc-key": "jp-3480",
  "population": "7.5",
  "unit": "Million",
}, {
  "hc-key": "jp-ts",
  "population": "1.7",
  "unit": "Million",
}, {
  "hc-key": "jp-ky",
  "population": "3.6",
  "unit": "Million",
}, {
  "hc-key": "jp-me",
  "population": "7.5",
  "unit": "Million",
}, {
  "hc-key": "jp-ai",
  "population": "1.6",
  "unit": "Million",
}, {
  "hc-key": "jp-nr",
  "population": "2.5",
  "unit": "Million",
}, {
  "hc-key": "jp-os",
  "population": "8.8",
  "unit": "Million",
}, {
  "hc-key": "jp-wk",
  "population": "1.3",
  "unit": "Million",
}, {
  "hc-key": "jp-ch",
  "population": "0.9",
  "unit": "Million",
}, {
  "hc-key": "jp-ak",
  "population": "5.4",
  "unit": "Million",
}, {
  "hc-key": "jp-mg",
  "population": "1.3",
  "unit": "Million",
}, {
  "hc-key": "jp-tt",
  "population": "0.9",
  "unit": "Million",
}, {
  "hc-key": "jp-hg",
  "population": "1.3",
  "unit": "Million",
}, {
  "hc-key": "jp-gf",
  "population": "0.7",
  "unit": "Million",
}, {
  "hc-key": "jp-nn",
  "population": "5.1",
  "unit": "Million",
}, {
  "hc-key": "jp-ty",
  "population": "0.8",
  "unit": "Million",
}, {
  "hc-key": "jp-ni",
  "population": "1.3",
  "unit": "Million",
}, {
  "hc-key": "jp-oy",
  "population": "0.7",
  "unit": "Million",
}, {
  "hc-key": "jp-ao",
  "population": "5.1",
  "unit": "Million",
}, {
  "hc-key": "jp-mz",
  "population": "0.8",
  "unit": "Million",
}, {
  "hc-key": "jp-iw",
  "population": "1.3",
  "unit": "Million",
}, {
  "hc-key": "jp-kc",
  "population": "1.7",
  "unit": "Million",
}, {
  "hc-key": "jp-ot",
  "population": "1.8",
  "unit": "Million",
}, {
  "hc-key": "jp-sz",
  "population": "2.8",
  "unit": "Million",
}, {
  "hc-key": "jp-fi",
  "population": "1.3",
  "unit": "Million",
}, {
  "hc-key": "jp-sh",
  "population": "0.7",
  "unit": "Million",
}, {
  "hc-key": "jp-tc",
  "population": "0.9",
  "unit": "Million",
}, {
  "hc-key": "jp-yt",
  "population": "5.1",
  "unit": "Million",
}, {
  "hc-key": "jp-3302",
  "population": "1.3",
  "unit": "Million",
}, {
  "hc-key": "undefined",
  "population": "1.3",
  "unit": "Million",
}];
// Create the chart
Highcharts.mapChart('japan-map', {
  chart: {
    map: 'countries/jp/jp-all',
    height: 550
  },
  title: {
    text: 'Highmaps basic demo'
  },
  mapNavigation: {
    enabled: true,
    buttonOptions: {
      verticalAlign: 'bottom'
    }
  },
  legend: {
    title: {
      text: 'Population Title',
      style: {
        color: ( // theme
          Highcharts.defaultOptions &&
          Highcharts.defaultOptions.legend &&
          Highcharts.defaultOptions.legend.title &&
          Highcharts.defaultOptions.legend.title.style &&
          Highcharts.defaultOptions.legend.title.style.color
        ) || 'black'
      }
    },
    align: 'left',
    verticalAlign: 'middle',
    floating: true,
    layout: 'vertical',
    valueDecimals: 0,
    backgroundColor: ( // theme
      Highcharts.defaultOptions &&
      Highcharts.defaultOptions.legend &&
      Highcharts.defaultOptions.legend.backgroundColor
    ) || 'rgba(255, 255, 255, 0.85)',
    symbolRadius: 0,
    symbolHeight: 14
  },
  colorAxis: {
    /*dataClasses: [{
      to: 3
    }, {
      from: 3,
      to: 10
    }, {
      from: 10,
      to: 30
    }, {
      from: 30,
      to: 100
    }, {
      from: 100,
      to: 300
    }, {
      from: 300,
      to: 1000
    }, {
      from: 1000
    }]*/
  },
  series: [{
    allAreas: true,
    data: data,
    mapData: Highcharts.maps['countries/jp/jp-all'],
    joinBy: 'hc-key',
    // name: 'Random data',
    states: {
      hover: {
        color: '#BADA55'
      }
    },
    dataLabels: {
      enabled: true,
      format: '{point.name}'
    }
  }, {
    name: 'Separators',
    type: 'mapline',
    data: Highcharts.geojson(Highcharts.maps['countries/jp/jp-all'], 'mapline'),
    color: 'silver',
    showInLegend: false,
    enableMouseTracking: false
  }],
  tooltip: {
    formatter: function() {
      return '<b>' + this.point.name + '</b> <br> Population: <b>' + this.point.population + '</b><br/>' + 'Unit: <b>' + this.point.unit + '</b><br/>';
    }
  }
});
</script>
@stop