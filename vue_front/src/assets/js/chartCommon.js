/* eslint-disable */
// Class chartCommon
function chartCommon(p_chartIndex, chartDetails) {

    this.Conf = {
        chartType: '',
        chartIndex: null,
        view_option: '',
        reverseYAxis: false,
        reversedAxis_: [],
        chartColor: [],
        chartColorSeries: [],
        chartColorSatus: false,
        mychartchartColor: [],
        color_series: [],
        color_status: false,
        commonColorCode: [
            [],
            [],
            [],
            [],
            [],
            [],
            [],
            []
        ],
        mychart_color_code: [
            [],
            [],
            [],
            []
        ],
        isChartTypeSwitchable: 'Y',
        isPremiumData: false,
        chartLayout: 'normal',
        isNavigator: true,
        isMultiaxis: false,
        chartExport: {},
        chart_actual_code: '',
        chart_data_type: 'monthly',
        current_chart_codes: [],
        chart_labels_available: [],
        charts_available: [],
        charts_codes_available: [],
        charts_fields_available: [],
        navigator_date_from: '',
        navigator_date_to: '',
        share_chart: {
            share_page_url: '',
            dateRange_from: '',
            dateRange_to: ''
        },
        sources: '',
        chartData: {}
    };
    this.chartConfigs = {
        colors: ['#316AB4', '#E60013', '#FF9900', '#910000',
            '#1aadce', '#492970', '#f28f43', '#77a1e5',
            '#c42525', '#a6c96a'
        ]
    };


    this.chart_object = null;
    this.chartLayoutData = { 'chart_details': {}, 'series_details': {}, 'mychart_details': {} };
    this.dominitialize = function() {

    };

    this.formatData = function(ap_data) {
        var out_data = {};
        $.each(ap_data, function(graph_code, data_rows) {
            var p_data_rows = new Array();
            $.each(data_rows, function(ky, row) {
                var datetimeVal = row[0].split('-');
                var utcTime = Date.UTC(datetimeVal[2], datetimeVal[1] - 1, datetimeVal[0]);
                var float_value = row[1] == null ? null : parseFloat(row[1]);
                p_data_rows[ky] = [utcTime, float_value];
            });
            out_data[graph_code] = p_data_rows;
        });
        return out_data;
    }




    // Set all Chart configurations
    this.setAllConfigurations = function(p_chartIndex, p_configs) {

        this.Conf.chartType = p_configs.chart_config.chartType;
        this.Conf.chartIndex = p_chartIndex;
        this.Conf.view_option = p_configs.chart_config.ViewOption;
        this.Conf.reverseYAxis = (typeof(p_configs.chart_config.reverseYAxis) === 'undefined') ? false : JSON.parse(p_configs.chart_config.reverseYAxis);
        this.Conf.reversedAxis_ = (typeof(p_configs.chart_config.reversedAxis_) === 'undefined') ? [] : p_configs.chart_config.reversedAxis_;
        // this.Conf.reverseYAxis =  typeof(p_configs.reverseYAxis === undefined )? false : p_configs.p_configs.reverseYAxis;
        this.Conf.isPremiumData = p_configs.isPremiumData;
        this.Conf.chartLayout = p_configs.chart_config.chartLayout;
        this.Conf.isMultiaxis = p_configs.chart_config.isMultiaxis;
        this.Conf.isNavigator = p_configs.chart_config.isNavigator;
        this.Conf.chartExport = p_configs.chart_config.chartExport;
        this.Conf.chart_actual_code = p_configs.chart_actual_code;
        this.Conf.mychartchartColor = p_configs.color_code;
        this.Conf.color_series = p_configs.color_series;
        this.Conf.color_status = typeof(p_configs.color_status === undefined) ? 'true' : p_configs.color_status;
        this.Conf.mychart_color_code = p_configs.mychart_color_code;
        this.Conf.chart_data_type = p_configs.chart_data_type;
        this.Conf.current_chart_codes = p_configs.current_chart_codes;
        this.Conf.chart_labels_available = p_configs.chart_labels_available;
        this.Conf.charts_codes_available = p_configs.charts_codes_available;
        this.Conf.charts_available = p_configs.charts_available;
        this.Conf.charts_fields_available = p_configs.charts_fields_available;
        this.Conf.share_chart.share_page_url = p_configs.share_page_url;
        this.Conf.share_chart.dateRange_from = p_configs.navigator_date_from;
        this.Conf.share_chart.dateRange_to = p_configs.navigator_date_to;
        var js_dateRange_from = p_configs.navigator_date_from.split('-');
        var js_dateRange_to = p_configs.navigator_date_to.split('-');
        this.Conf.navigator_date_from = Date.UTC(js_dateRange_from[2], js_dateRange_from[1] - 1, js_dateRange_from[0]);
        this.Conf.navigator_date_to = Date.UTC(js_dateRange_to[2], js_dateRange_to[1] - 1, js_dateRange_to[0]);
        this.Conf.sources = p_configs.sources;
        this.Conf.chartData = this.formatData(p_configs.chart_data);
    };



    // Copy configuration sets
    this.copyThisConfigurations = function(p_configs) {
        this.Conf = p_configs;
    };
    // Get all configurations
    this.getAllConfigurations = function() {
        return this.Conf;
    };


    // All data sets
    this.data = {};
 // Update common share url
	this.updateCommonShareURL = function(){
		var new_url = this.Conf.share_chart.share_page_url;
		$('#common_share_url').val(new_url);
	}
	// Update chart share url
	this.updateChartShareURL = function(min,max){
		var js_min_date = new Date(min);
		var js_max_date = new Date(max);
		this.Conf.share_chart.dateRange_from = js_min_date.getDate()+'-'+(js_min_date.getMonth()+1)+'-'+js_min_date.getFullYear();
		this.Conf.share_chart.dateRange_to = js_max_date.getDate()+'-'+(js_max_date.getMonth()+1)+'-'+js_max_date.getFullYear();
		var new_url = this.Conf.share_chart.share_page_url+'?gids='+this.Conf.current_chart_codes.join('|')+'&graph_index='+this.Conf.chartIndex+'&graph_type='+this.Conf.chartType+'&graph_data_from='+this.Conf.share_chart.dateRange_from+'&graph_data_to='+this.Conf.share_chart.dateRange_to;
		$('#graph_share_url_'+this.Conf.chartIndex).val(new_url);
	};

}
// Class chartCommon
module.exports=chartCommon;