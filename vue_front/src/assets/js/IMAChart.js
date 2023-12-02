/* eslint-disable */
function IMAChart(){
	var IMAChart = this;
	this.Charts = new Array();

	this.createChartObject = {
		'line' : function(p_chartIndex){
			LineChart.prototype = new chartCommon(p_chartIndex);
			return new LineChart();
		},
		'bar' : function(p_chartIndex,chartDetails){

			BarChart.prototype = new chartCommon(p_chartIndex);
			return new BarChart();
		},
		'multiaxisline' : function(p_chartIndex,chartDetails){
			MultiYaxisLineChart.prototype = new chartCommon(p_chartIndex);
			return new MultiYaxisLineChart();
		},
		'multiaxisbar' : function(p_chartIndex,chartDetails){
			MultiYaxisLineChart.prototype = new chartCommon(p_chartIndex);
			return new MultiYaxisLineChart();
		}

	};
	
	
	
	
	//initiate a new chart object
	this.initiateChart = function(chartIndex,chartDetails){
		
		var old = JSON.stringify(chartDetails).replace(/&amp;/g, '&').replace(/&#039;/g, "'"); //convert to JSON string
        var chartDetails = JSON.parse(old); //convert back to array
		this.Charts[chartIndex] = this.createChartObject[chartDetails.chart_config.chartType](chartIndex);
		this.Charts[chartIndex].setAllConfigurations(chartIndex,chartDetails);	
	};
	
	//Switch graphTypes
	this.switchGraph = function(chartIndex,chartType,mobileView){
		var md = new MobileDetect(window.navigator.userAgent);
		var currentConfig = this.Charts[chartIndex].getAllConfigurations();
		currentConfig.chartType = chartType;
		if (md.mobile() || md.tablet()) {
			currentConfig.chartColorSatus = 'true';
		} else {
			mobileView = false;
			currentConfig.view_option = 'chart';
			currentConfig.chartColorSatus = 'true';
			currentConfig.reverseYAxis = IMA.JMAChart.Charts[chartIndex].Conf.reverseYAxis;
		}
		this.Charts[chartIndex] = this.createChartObject[chartType](chartIndex);
		this.Charts[chartIndex].copyThisConfigurations(currentConfig);
		this.Charts[chartIndex].drawChart(mobileView);
	};
	
	this.initialize = function(){
		Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {
			switch (operator) {
				case '==':
				return (v1 == v2) ? options.fn(this) : options.inverse(this);
				case '!=':
				return (v1 != v2) ? options.fn(this) : options.inverse(this);
				case '===':
				return (v1 === v2) ? options.fn(this) : options.inverse(this);
				case '<':
				return (v1 < v2) ? options.fn(this) : options.inverse(this);
				case '<=':
				return (v1 <= v2) ? options.fn(this) : options.inverse(this);
				case '>':
				return (v1 > v2) ? options.fn(this) : options.inverse(this);
				case '>=':
				return (v1 >= v2) ? options.fn(this) : options.inverse(this);
				case '&&':
				return (v1 && v2) ? options.fn(this) : options.inverse(this);
				case '||':
				return (v1 || v2) ? options.fn(this) : options.inverse(this);
				default:
				return options.inverse(this);
			}
		});
	}
	
	// Dom initialize
	this.domInitialize = function(){
		$('.Graph_tabset_tab.inactive').on("click",function(){
			var chart_fnd_index = $(this).attr('chart_index');
			var graph_container_obj = $('#h_graph_wrap_'+chart_fnd_index);
			var jqobj = $(this);
			var contentdiv = jqobj.attr('contentdiv');
			graph_container_obj.find('.Graph_tabset_tab').removeClass('active').addClass('inactive');
			jqobj.removeClass('inactive').addClass('active');
			graph_container_obj.find('.Graph_tabset_contentdiv').hide();
			graph_container_obj.find('.Graph_tabset_contentarea').find(contentdiv).show();
		});
	};
	
	
	  
	  

	  
	 

	// Draw all charts
	this.drawAllCharts = function(mobileView){
		var md = new MobileDetect(window.navigator.userAgent);
		if (md.mobile() || md.tablet()) {	
			$('.amc-btn').on('click', function() {
			    $(this).parent('.add-more-con').toggleClass('amc-menu');
			    var menuEls = document.querySelectorAll('nav.amc-maimen');
				console.log(menuEls.length);
				menuEls.forEach(function(menuEl) {
					var mlmenu = new MLMenu(menuEl, {
						backCtrl : false,
					});
				});
			 });
		} else {
			mobileView =false;
		}
		/*if(this.Maps.length>0){
			$.each(this.Maps,function(idx,chartObj){
				chartObj.drawChart(mobileView);
			});
		}*/
		if(this.Charts.length>0){
			$.each(this.Charts,function(idx,chartObj){
				chartObj.drawChart(mobileView);
			});
			this.domInitialize();
		}
	};
	
	
	
	// Draw a chart by chart index
	this.redrawChart = function(p_chart_idx){
		var md = new MobileDetect(window.navigator.userAgent);
		if (md.mobile() || md.tablet()) {
			mobileview = true;
		} else {
			mobileview = false;
			$('a.btn-admor').unbind('click', function(event) {
				event.preventDefault();
				event.stopPropagation();
				$(this).parent().siblings().removeClass('dropdown-clicked');
				$(this).parent().children('.dropdown-menu').children('.dropdown-clicked').removeClass('dropdown-clicked');
				$(this).parent().toggleClass('dropdown-clicked');
			  });
			  $(document).unbind('click', 'body', function(e) {
				if (!$(e.target).is('.dropdown-clicked'))
				  $('.dropdown-clicked').removeClass('dropdown-clicked');
			  });
		}
			var dataUrl = IMA.baseURL+'chart/getchartdata';
			var data_type = IMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type;
			var chartcodes = IMA.JMAChart.Charts[p_chart_idx].Conf.current_chart_codes;
			$.ajax({
				url : dataUrl,
				dataType : 'json',
				type : 'POST',
				data : {'type' : data_type, 'chartcodes' : chartcodes},
				beforeSend: function() { IMA.showLoading(); },
				success : function(data){
					IMA.JMAChart.Charts[p_chart_idx].Conf.chartData = IMA.JMAChart.Charts[p_chart_idx].formatData(data.data);
					IMA.JMAChart.Charts[p_chart_idx].Conf.sources = data.sources;
					IMA.JMAChart.Charts[p_chart_idx].Conf.isPremiumData = data.isPremiumData;
					IMA.JMAChart.Charts[p_chart_idx].drawJmaChart(mobileview);
					$("div.input-group-addon i.fa-minus").trigger('click');
					if (!md.mobile() && !md.tablet()) {
						$('[data-placement="top"]').tooltip();
						var seriesHeight = $('#Dv_placeholder_graph_series_section_'+p_chart_idx).height();
						$('#Chart_Dv_placeholder_'+p_chart_idx).find(".addser-drpbtn").css('top',seriesHeight + 40);
						if(seriesHeight > 150){
							$('#Chart_Dv_placeholder_'+p_chart_idx).find(".addser-drpbtn").addClass('asdb-upper');
						} else {
							$('#Chart_Dv_placeholder_'+p_chart_idx).find(".addser-drpbtn").removeClass('asdb-upper');
						}
					}
					IMA.hideLoading();
				},
				error : function() {
					IMA.hideLoading();
					IMA.handleError();
				}
			});
	};


	

	

	
	

	
	
	
	
	
this.get_chart_fields_labels = function(p_chart_idx,p_graph_code){

	try{
			// Get list of charts for selected folder
			// create array or chart objects
			$.ajax({
				url : IMA.baseURL + "chart/get_chart_fields_labels",
				dataType : 'json',
				type : 'POST',
				data : { p_graph_code: p_graph_code },
				beforeSend: function() { IMA.showLoading(); },
				success : function(response){
					if(response.status!=1){
						IMA.handleErrorWithMessage(response.message);
					}else{
						$.extend( IMA.JMAChart.Charts[p_chart_idx].Conf.charts_fields_available, response.charts_fields_available);
						$.extend( IMA.JMAChart.Charts[p_chart_idx].Conf.chart_labels_available, response.chart_labels_available);
						//IMA.hideLoading();	
					}
					
				},
				error : function(){
					IMA.hideLoading();
					IMA.handleError();
				}
			});
			
		}catch(Err){
			IMA.handleError();
		}
	};
	
	// Add new graph code to current graph codes
	this.addThisGraphCode = function(p_chart_idx,p_graph_code){
		var SetTime=0;
		
			
		if(arguments.length==2 && typeof p_graph_code=='object'){
			var series_main_code = $('a#'+p_graph_code.id).attr('value');
		

			if(!(IMA.JMAChart.Charts[p_chart_idx].Conf.charts_codes_available).includes(series_main_code)){
				var SetTime=1500;
			var series_main_code_text = $('a#'+p_graph_code.id).text();
			
			(IMA.JMAChart.Charts[p_chart_idx].Conf.charts_codes_available).push(series_main_code);
			$.extend(IMA.JMAChart.Charts[p_chart_idx].Conf.charts_available, {series_main_code: series_main_code_text} );
			
			this.get_chart_fields_labels(p_chart_idx,series_main_code);
			
		   }
		}else{
			var series_main_code = $('#select_series_addmore-select_'+p_chart_idx).val();
		}

		//console.log(series_main_code); return false;
		// Get previous chart's y-sub text
		var prev_ysub_selected_text = $('#Dv_placeholder_graph_series_section_'+p_chart_idx+' > div').last().find('.Dv_placeholder_graph_currentseries_ysub_select').find('select option:selected').text();
		var thing = this;
		setTimeout(function() {
		//console.log(IMA.JMAChart.Charts[p_chart_idx].Conf.charts_fields_available[series_main_code]);
		var arr_available_fields = IMA.JMAChart.Charts[p_chart_idx].Conf.charts_fields_available[series_main_code][Object.keys(IMA.JMAChart.Charts[p_chart_idx].Conf.charts_fields_available[series_main_code])[0]];
		if(arr_available_fields.hasOwnProperty(prev_ysub_selected_text)){
			var series_code = arr_available_fields[prev_ysub_selected_text];
		}else{
			var series_code = series_main_code+'-0';
		}
		IMA.JMAChart.Charts[p_chart_idx].addThisToCurrentGraphCode(series_code);
		IMA.JMAChart.Charts[p_chart_idx].drawSeriesLayout();
		IMA.JMAChart.Charts[p_chart_idx].Conf.chartColorSatus = 'true';

		thing.redrawChart(p_chart_idx);
		}, SetTime);

		
	};	
	// Replace existing graph code
	this.replaceThisGraphCode = function(p_chart_idx,p_code_idx,elm){
		var p_graph_code= $(elm).val();
		IMA.JMAChart.Charts[p_chart_idx].replaceCurrentGraphCode(p_code_idx,p_graph_code);
		IMA.JMAChart.Charts[p_chart_idx].drawSeriesLayout();
		this.redrawChart(p_chart_idx);
	};
	
	
	
	 this.replaceColorofChartForIndicator = function(p_chart_idx,color_code_idx,indexChart1){
	
		IMA.JMAChart.Charts[p_chart_idx].Conf.chartColorSeries.push(indexChart1);
		var colorArr = IMA.JMAChart.Charts[p_chart_idx].Conf.chartColor;
		
		if (typeof colorArr !== 'undefined') 
		{
			IMA.JMAChart.Charts[p_chart_idx].Conf.chartColor[indexChart1] = color_code_idx;
			IMA.JMAChart.Charts[p_chart_idx].Conf.commonColorCode[p_chart_idx][indexChart1] = color_code_idx;
		}
		else
		{
			IMA.JMAChart.Charts[p_chart_idx].Conf.chartColor.push(color_code_idx);
		}
			
		IMA.JMAChart.Charts[p_chart_idx].Conf.chartColorSatus = false;
		this.redrawChart(p_chart_idx);
	};
	
	
	this.replaceThisGraphCodeDirect = function(p_chart_idx,p_code_idx,new_ch_code){
		IMA.JMAChart.Charts[p_chart_idx].replaceCurrentGraphCode(p_code_idx,new_ch_code);
		IMA.JMAChart.Charts[p_chart_idx].drawSeriesLayout();
		IMA.JMAChart.Charts[p_chart_idx].Conf.chartColorSatus = 'true';
		this.redrawChart(p_chart_idx);
	};
	this.removeThisChartCodeByIndex = function(p_chart_idx,p_chart_code_idx){
		IMA.JMAChart.Charts[p_chart_idx].removeThisChartCodeByIndex(p_chart_code_idx);
		IMA.JMAChart.Charts[p_chart_idx].drawSeriesLayout();
		IMA.JMAChart.Charts[p_chart_idx].Conf.chartColorSatus = 'true';
		this.redrawChart(p_chart_idx);
	}
	
	 // Create and populate Y sub select dropdown
	this.changeColorofChartForIndicator = function(p_chart_idx,color_code,indexChart1){
		this.replaceColorofChartForIndicator(p_chart_idx,color_code,indexChart1);
	};
	
	
	// Create and populate Y sub select dropdown
	this.populateYSubDropdown = function(p_chart_idx,p_code_idx,p_element){
		/* var y_idx = $(p_element).val();
		//Find y-sub text
		var ySub_text = $(p_element).next('.Dv_placeholder_graph_currentseries_ysub_select').find('select option:selected').text();
		var array_y_sub_vals = IMA.JMAChart.Charts[p_chart_idx].populateYSubDropdownData(p_code_idx,y_idx);
		var new_ch_code = array_y_sub_vals[0].code; 
		$.each(array_y_sub_vals,function(dd_k,dd_v){
			if(dd_v.label == ySub_text){
				new_ch_code = dd_v.code;
			}
		})
		this.replaceThisGraphCodeDirect(p_chart_idx,p_chart_idx,new_ch_code); */
		
		
		var y_idx = $(p_element).val();
		//Find y-sub text
		
		var ySub_text = $(p_element).parent().next('.Dv_placeholder_graph_currentseries_ysub_select').find('select option:selected').text();

		var array_y_sub_vals = IMA.JMAChart.Charts[p_chart_idx].populateYSubDropdownData(p_code_idx,y_idx);
		var new_ch_code = array_y_sub_vals[0].code; 
		
		$.each(array_y_sub_vals,function(dd_k,dd_v){
			if(dd_v.label == ySub_text){
				new_ch_code = dd_v.code;
			}
		})
		this.replaceThisGraphCodeDirect(p_chart_idx,p_code_idx,new_ch_code);
		
		/*
		var str_option = '<select onChange="IMA.JMAChart.replaceThisGraphCode('+p_chart_idx+','+p_code_idx+',this)">';
		$.each(array_y_sub_vals, function(ky,options_obj){
			str_option+='<option value="'+options_obj.code+'">'+options_obj.label+'</optopn>';
		});
		str_option+='</select>';
		$('#Dv_placeholder_graph_currentseries_select_'+p_chart_idx+'_'+p_code_idx).find('.Dv_placeholder_graph_currentseries_ysub_select').html(str_option);
		*/
	};

	this.SeriesColorDropdown = function(chart_index,series_idx,el){

		var $Seriescolor=IMA.JMAChart.Charts[chart_index].chartConfigs.colors[series_idx];
		var $Seriescolor=($Seriescolor!=null)?$Seriescolor:'red';
		return el.style.color = $Seriescolor;
		
	};
	
	

	this.reverseYAxis = function(p_chart_idx){
				if($('#reverse_checkbox__'+p_chart_idx).is(':checked')){
					IMA.JMAChart.Charts[p_chart_idx].Conf.reverseYAxis=true;
				}else{
					IMA.JMAChart.Charts[p_chart_idx].Conf.reverseYAxis=false;
				}
			var reversed = IMA.JMAChart.Charts[p_chart_idx].chart_object.yAxis[0].reversed;

			for(var yX=0; yX<IMA.JMAChart.Charts[p_chart_idx].chart_object.yAxis.length; yX++) {
						IMA.JMAChart.Charts[p_chart_idx].chart_object.yAxis[yX].update({ reversed: !reversed });
				    }
			reversed = !reversed;
	};
	
	// Switch to barchart
	this.switchToBarChart = function(p_chart_idx,p_element,mobileView){
		var md = new MobileDetect(window.navigator.userAgent);
		if (!md.mobile() && !md.tablet()) {
			mobileView = false;
		}
		if($(p_element).is(':checked') && !$('#multiaxis_checkbox__'+p_chart_idx).is(':checked')){
		this.switchGraph(p_chart_idx,'bar',mobileView);
		}else if($(p_element).is(':checked') && $('#multiaxis_checkbox__'+p_chart_idx).is(':checked')){
			this.switchGraph(p_chart_idx,'multiaxisbar',mobileView);
		}else if(!$(p_element).is(':checked') && $('#multiaxis_checkbox__'+p_chart_idx).is(':checked')){
			this.switchGraph(p_chart_idx,'multiaxisline',mobileView);
		}else{
			this.switchGraph(p_chart_idx,'line',mobileView);
		}
		$("div.input-group-addon i.fa-minus").trigger('click');
	};
	
	// Switch to multiaxisline
	this.switchToMultiAxisLine = function(p_chart_idx,p_element,mobileView){
		var md = new MobileDetect(window.navigator.userAgent);
		if (!md.mobile() && !md.tablet()) {
			mobileView = false;
		}
		console.log(mobileView);
		if($(p_element).is(':checked') && !$('#barchart_checkbox__'+p_chart_idx).is(':checked')){
		this.switchGraph(p_chart_idx,'multiaxisline',mobileView);
		}else if($(p_element).is(':checked') && $('#barchart_checkbox__'+p_chart_idx).is(':checked')){
			this.switchGraph(p_chart_idx,'multiaxisbar',mobileView);
		}else if(!$(p_element).is(':checked') && $('#barchart_checkbox__'+p_chart_idx).is(':checked')){
			this.switchGraph(p_chart_idx,'bar',mobileView);
		}else{
			this.switchGraph(p_chart_idx,'line',mobileView);
		}
		$("div.input-group-addon i.fa-minus").trigger('click');
	};
	
	// Download chart data
	this.downloadChartData = function(p_chart_idx) {
		var jq_frm_obj = $('#frm_download_chart_data_'+p_chart_idx);
		// IMA.JMAChart.Charts[p_chart_idx].Conf.isPremiumData
		var cht_codes_str = IMA.JMAChart.Charts[p_chart_idx].Conf.current_chart_codes.toString();
		
		jq_frm_obj.find('#frm_input_download_chart_codes_'+p_chart_idx).attr('value',cht_codes_str);
		jq_frm_obj.find('#frm_input_download_chart_datatype_'+p_chart_idx).attr('value',IMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type);
		
		if(IMA.userDetails.hasOwnProperty('id') && IMA.userDetails.id>0) {
			
			try{
				if(IMA.JMAChart.Charts[p_chart_idx].Conf.isPremiumData == true) {
					if(IMA.userDetails.user_permissions.graph.datadownload.allowpremiumdatadownload == 'Y') {
						jq_frm_obj.submit();
					}
					else {
						IMA.User.showUpgradeBox('premium',IMA.JMAChart.Charts[p_chart_idx].Conf.share_chart.share_page_url);
					}
				}
				else {
					if(IMA.userDetails.user_permissions.graph.datadownload.allowdatadownload == 'Y') {
						jq_frm_obj.submit();
					}else {
						// Show membership upgrade form
						IMA.User.showUpgradeBox('download',p_chart_idx);
					}
				}
			} catch(e){
				IMA.User.showUpgradeBox('download',p_chart_idx);
			}
			
		} else {
			$.createCookie("downloadData",window.location.href);
			// Show log-in box
			IMA.User.showLoginBox('download',p_chart_idx);
			var currentUrl = window.location;
			var str = ""+currentUrl+"";
			var res = str.split('/').join('@'); 
			//var avoid = "@japanmacroadvisors@";
			//var test = res.replace(avoid, '');
			//var linkedInUrl = 'user/linkedinProcess/'+test+'code='+cht_codes_str+'datatype='+IMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type;
			if(window.location.hostname == "localhost")
			{
				var href = window.location.href.split('/');
				var linkedInUrl = href[3]+'/user/linkedinProcess/?'+res;
			}
			else
			{
				var linkedInUrl = 'user/linkedinProcess/?'+res;
			}
			//+'index='+p_chart_idx
			$("a.linkedIn").attr("href", linkedInUrl);
		}
	};
	// Chart full screen - toggle
	this.switchChartFullscreen = function(spDvId){
		var elem = document.getElementById(spDvId);
		req = elem.requestFullScreen || elem.webkitRequestFullScreen || elem.mozRequestFullScreen || elem.msRequestFullscreen;
		req.call(elem);
		$( ".highcharts-dd" ).hide();
		
	};
	var nIntervId;
	this.screen=function(){  nIntervId = setInterval(this.flashText, 500);}
	this.flashText=function () {
		if(!(document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement)){
			$( ".highcharts-dd" ).show();
		}
	}
	
	this.initialize();
}

module.exports=IMAChart;