/* eslint-disable */
//Class LineChart
function LineChart(p_chartIndex, chartDetails) {
    var chartCommon = this;
    this.setConfigurations = function() {

    };

    this.createChartDataSeries = function() {
        var chartDataSeries = [];
        var chart_series_count = 0;

       // chartCommon.createIndividualColorPicker();

        var d = 0;


        $.each(chartCommon.Conf.chartData, function(chartcode, chart_data_col) {

            if (chartCommon.Conf.chartColor.hasOwnProperty(d)) {
                chartCommon.chartConfigs.colors[d] = chartCommon.Conf.chartColor[d];
            } else if (typeof chartCommon.Conf.mychartchartColor !== "undefined") {

                $.each(chartCommon.Conf.chartColor, function(idx) {

                    if (chartCommon.Conf.chartColor[idx] === undefined) {} else {
                        chartCommon.Conf.mychartchartColor[idx] = chartCommon.Conf.chartColor[idx];
                    }
                });


                if (chartCommon.Conf.mychartchartColor[d]) {
                    chartCommon.chartConfigs.colors[d] = chartCommon.Conf.mychartchartColor[d];
                }

            }

            chartDataSeries[chart_series_count] = {
                name: chartCommon.Conf.chart_labels_available[chartcode],
                data: chart_data_col,

            }

            chart_series_count++;
            d++;
        });
        return chartDataSeries;
    }

    this.createHighChart = function(chart_data_series, mobileView) {
        var md = new MobileDetect(window.navigator.userAgent);
        if (md.mobile() || md.tablet()) {
            var toolTipYvalue = 205;
            if (chartCommon.Conf.current_chart_codes.length > 1) {
                toolTipYvalue = 130;
            }
            var md = new MobileDetect(window.navigator.userAgent);
            if (!md.mobile() || !md.tablet()) {
                var tooltipstyle = {};

                var chartHeight = 400;
                var renderX = 93;
                var renderY = 377;
                var renderYsource = 385;

            } else {
                var tooltipstyle = {};

                var chartHeight = 300;

                var renderX = 53;
                var renderY = 277;
                var renderYsource = 285;
            }
            var graph_containerID = '#' + graph_container;
            var position_legend_x = 17;
            var position_legend_width = 527;
            var position_legend_x_export = 17;
            var position_legend_width_export = 547;
            if (this.Conf.chart_data_type == 'quaterly') {

                var xAxis = {
                    //	ordinal:false,
                    minRange: 1,
                    gridLineWidth: 0, // New value
                    events: {
                        setExtremes: function(e) {
                            chartCommon.Conf.navigator_date_from = e.min;
                            chartCommon.Conf.navigator_date_to = e.max;
                            chartCommon.updateChartShareURL(e.min, e.max);
                            chartCommon.updateCommonShareURL();
                            // changeShare(index);
                        }
                    },
                    labels: {
                        showFirstLabel: true,
                        showLastLabel: true,
                        style: tooltipstyle,
                        //format : '{value}'
                        formatter: function() {
                            var s = "";
                            if (Highcharts.dateFormat('%b', this.value) == 'Mar') {
                                s = s + "Q1"
                            };
                            if (Highcharts.dateFormat('%b', this.value) == 'Jun') {
                                s = s + "Q2"
                            };
                            if (Highcharts.dateFormat('%b', this.value) == 'Sep') {
                                s = s + "Q3"
                            };
                            if (Highcharts.dateFormat('%b', this.value) == 'Dec') {
                                s = s + "Q4"
                            };
                            s = s + " " + Highcharts.dateFormat('%Y', this.value);
                            return s;
                        }
                    },
                    tickInterval: 3 * 30 * 24 * 3600 * 1000,
                    type: 'datetime',
                    //  startOnTick : true,
                    tickPositioner: function(vMin, vMax) {
                        return chartCommon.generateChartTickPositions(vMin, vMax);
                    }
                };

                var toolTip = {
                    formatter: function() {
                        var s = '<b>';
                        if (Highcharts.dateFormat('%b', this.x) == 'Mar') {
                            s = s + "Q1"
                        };
                        if (Highcharts.dateFormat('%b', this.x) == 'Jun') {
                            s = s + "Q2"
                        };
                        if (Highcharts.dateFormat('%b', this.x) == 'Sep') {
                            s = s + "Q3"
                        };
                        if (Highcharts.dateFormat('%b', this.x) == 'Dec') {
                            s = s + "Q4"
                        };
                        s = s + " " + Highcharts.dateFormat('%Y', this.x) + '</b>';


                        $.each(this.points, function(i, point) {
                            var symbol = '<span style="color:' + point.series.color + '">●</span>';
                            s += '<br/>' + symbol + point.series.name + ': ' + point.y;
                        });
                        return s;
                    },
                    shared: true,
                    followTouchMove: false,
                    useHTML: true,
                    backgroundColor: null,
                    borderWidth: 0,
                    shadow: false,
                    positioner: function() {
                        return { x: 37, y: toolTipYvalue };
                    }
                };
            } else {

                var xAxis = {
                    minRange: 1,
                    gridLineWidth: 0, // New value
                    events: {
                        setExtremes: function(e) {
                            chartCommon.Conf.navigator_date_from = e.min;
                            chartCommon.Conf.navigator_date_to = e.max;
                            chartCommon.updateChartShareURL(e.min, e.max);
                            chartCommon.updateCommonShareURL();
                            // changeShare(index);
                        }
                    }
                };

                var toolTip = {
                    shared: false,
                    useHTML: true,
                    backgroundColor: null,
                    padding: 0,
                    /* borderWidth: 0,
                    shadow: false, */
                    positioner: function() {
                        return { x: 37, y: toolTipYvalue };
                    },
                    followTouchMove: false,
                    style: tooltipstyle,
                    /*formatter: function () {
					 var s = '';
					  $.each(this.points, function () {
						s += this.series.name;
						   
					});
						var match = s.match(/.{1,70}/g);
						return match.toString().replace(/\,/g,"<br/>");

				  
					  }*/
                };
            }
            var yAxis = {
                gridLineWidth: 1.5, // The default value, no need to change it
                gridLineDashStyle: 'Dot',
                gridLineColor: '#999999',
                gridZIndex: -10,
                // offset : 10,
                opposite: false,
                labels: {
                    align: 'right',
                    // y: 3
                },
                plotLines: [{
                    value: 0,
                    color: 'black',
                    dashStyle: 'shortdash',
                    width: 1.5
                }]
            };
            // var nav_ser_data = chart_data_series[0];
            // nav_ser_data['color'] = '#DE4623';
            // nav_ser_data['type'] = 'areaspline';

            if (mobileView == true) {
                var graph_container = 'Jma_chart_containerNew_' + this.Conf.chartIndex;

                var scrollbar = {
                    enabled: true
                }
                var navigators = {
                    enabled: true,
                    maskFill: "rgba(0, 0, 0, 0.10)",
                    series: {
                        lineColor: '#316AB4'
                    }
                }

                var legends = {
                    enabled: true,
                    align: 'center',
                    backgroundColor: '#dddddd',
                    verticalAlign: 'top',
                    layout: 'horizontal',
                    //labelFormatter: wordwapF,
                    itemStyle: {
                        color: '#274b6d'
                    }
                }

                var pointEvents = {}


            } else {
                var graph_container = 'Jma_chart_container_' + this.Conf.chartIndex;
                var scrollbar = {
                    enabled: false
                }
                var navigators = {
                    enabled: false
                }
                var legends = {
                    enabled: false
                }
                var toolTip = { enabled: false }

                var pointEvents = {
                    click: function(event) {
                        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        var m = (new Date(this.category)).getMonth();
                        if (chartCommon.Conf.chart_data_type == "anual") {
                            dateTimeOfSeries = (new Date(this.category)).getFullYear();
                        } else {
                            if (chartCommon.Conf.chart_data_type == 'quaterly') {
                                if (monthNames[m] == 'Mar') {
                                    dateTimeOfSeries = " Q1 - " + (new Date(this.category)).getFullYear();
                                } else if (monthNames[m] == 'Jun') {
                                    dateTimeOfSeries = "Q2 - " + (new Date(this.category)).getFullYear();
                                } else if (monthNames[m] == 'Sep') {
                                    dateTimeOfSeries = "Q3 - " + (new Date(this.category)).getFullYear();
                                } else if (monthNames[m] == 'Dec') {
                                    dateTimeOfSeries = "Q4 - " + (new Date(this.category)).getFullYear();
                                }
                            } else {
                                dateTimeOfSeries = monthNames[m] + " - " + (new Date(this.category)).getFullYear();
                            }

                            console.log(dateTimeOfSeries);
                        }
                        $(".legentSeriesDate_" + chartCommon.Conf.chartIndex + "_" + this.series._i).html(dateTimeOfSeries);
                        $(".legentSeriesDegault_" + chartCommon.Conf.chartIndex + "_" + this.series._i).html(this.y);
                    }
                }
            }


            var cht = new Highcharts.StockChart({
                chart: {
                    renderTo: graph_container,
                    /* events: {
                    	click: function (event) {
                    		console.log(Highcharts.numberFormat(event.yAxis[0].value, 2));
                    	}
                    }, */
                    panning: false,
                    height: chartHeight,
                    //backgroundColor : '#FBFBFB',
                    backgroundColor: '#f5f5f5',
                    plotBorderColor: '#000000',
                    plotBackgroundColor: '#FFFFFF',
                    plotBorderWidth: 0.5,
                    spacingBottom: 35,
                    alignTicks: true
                },

                exporting: {
                    enabled: false,
                    chartOptions: {
                        chart: {
                            //	spacingBottom : 85,
                            events: {
                                load: function() {
                                    this.renderer.image(IMA.baseURL + 'assets/images/logo.png', 385, 300, 195, 16).add();
                                    this.renderer.text("Source : " + chartCommon.Conf.sources, 10, 310, 159, 33).css({ size: '3px' }).add();
                                }
                            }
                        },
                        navigator: {
                            enabled: false
                        },
                        scrollbar: {
                            enabled: false
                        },
                        tooltip: { enabled: false },
                        legend: {
                            enabled: true,
                            backgroundColor: '#fffde1',
                            verticalAlign: 'top',
                            align: 'center',
                            itemStyle: {
                                color: '#274b6d',

                            }
                        }
                    }
                },
                colors: chartCommon.chartConfigs.colors,
                credits: {
                    enabled: false,
                    href: 'https://www.indiamacroadvisors.com',
                    text: 'indiamacroadvisors.com'
                },
                series: chart_data_series,
                rangeSelector: {
                    enabled: false,
                },
                plotOptions: {
                    line: {

                        dataGrouping: {
                            enabled: false,
                            approximation: 'average',
                            dateTimeLabelFormats: {
                                month: ['%B %Y', '%B', '-%B %Y']
                            }
                        }
                    },
                    series: {
                        // allowPointSelect: true,
                        connectNulls: true,
                        dataLabels: {
                            allowOverlap: true,


                        },
                        point: {
                            events: pointEvents
                        },
                    },
                },

                responsive: {
                    rules: [{
                        condition: {
                            minWidth: 500
                        },
                        chartOptions: {
                            legend: legends,
                        }
                    }, {
                        condition: {
                            maxWidth: 439
                        },
                        chartOptions: {
                            legend: legends,
                        }
                    }]
                },


                navigator: navigators,

                scrollbar: scrollbar,
                yAxis: yAxis,
                xAxis: xAxis,
                tooltip: toolTip
            }, function(p_chrtObj) {

                p_chrtObj.renderer.image(IMA.baseURL + 'assets/images/favicon.png', (chartCommon.Conf.chartLayout == 'narrow' && IMA.controller != 'home') ? 700 : p_chrtObj.chartWidth - renderX, renderY, 45, 11).add();
                p_chrtObj.renderer.text("Source : " + chartCommon.Conf.sources, 10, renderYsource, 159, 33).add();
                this.controller != 'home'
                p_chrtObj.xAxis[0].setExtremes(
                    chartCommon.Conf.navigator_date_from,
                    chartCommon.Conf.navigator_date_to);
                if (p_chrtObj.xAxis[0].tickPositions.length > 12) {
                    p_chrtObj.xAxis[0].update({ labels: { rotation: -45 } });
                }
                if (chartCommon.Conf.reversedAxis_.length > 0) {
                    chartCommon.Conf.reversedAxis_ = chartCommon.Conf.reversedAxis_.map(Number);
                }
                for (var yX = 0; yX < p_chrtObj.yAxis.length; yX++) {
                    if ($.inArray(yX, chartCommon.Conf.reversedAxis_) != -1) {
                        p_chrtObj.yAxis[yX].update({ reversed: chartCommon.Conf.reverseYAxis });
                    }
                }
            });

            return cht;

        } else {
            var isBig = window.matchMedia("(min-width: 1025px)");


            if (isBig.matches) {
                var tooltipstyle = {};
            } else {
                var tooltipstyle = { width: '100px' };
            }


            var graph_container = 'Jma_chart_container_' + this.Conf.chartIndex;
            var graph_containerID = '#' + graph_container;
            var position_legend_x = 17;
            var position_legend_width = 527;
            var position_legend_x_export = 17;
            var position_legend_width_export = 547;
            var quaterly_Extra = {};
            if (this.Conf.chart_data_type == 'quaterly') {
                var quaterly_Extra = {
                    labels: {
                        showFirstLabel: true,
                        showLastLabel: true,
                        style: tooltipstyle,
                        //format : '{value}'
                        formatter: function() {
                            var s = "";
                            if (Highcharts.dateFormat('%b', this.value) == 'Mar') {
                                s = s + "Q1"
                            };
                            if (Highcharts.dateFormat('%b', this.value) == 'Jun') {
                                s = s + "Q2"
                            };
                            if (Highcharts.dateFormat('%b', this.value) == 'Sep') {
                                s = s + "Q3"
                            };
                            if (Highcharts.dateFormat('%b', this.value) == 'Dec') {
                                s = s + "Q4"
                            };
                            s = s + " " + Highcharts.dateFormat('%Y', this.value);
                            return s;
                        }
                    },
                    tickInterval: 3 * 30 * 24 * 3600 * 1000,
                    type: 'datetime',
                    //  startOnTick : true,
                    tickPositioner: function(vMin, vMax) {
                        return chartCommon.generateChartTickPositions(vMin, vMax);
                    }
                };
            }

            var xAxis = {
                //	ordinal:false,
                minRange: 1,
                gridLineWidth: 0, // New value
                events: {
                    setExtremes: function(e) {
                        chartCommon.Conf.navigator_date_from = e.min;
                        chartCommon.Conf.navigator_date_to = e.max;
                        chartCommon.updateChartShareURL(e.min, e.max);
                        chartCommon.updateCommonShareURL();
                        // changeShare(index);
                    }
                },

            };
            $.extend(true, xAxis, quaterly_Extra);
            //Object.assign(xAxis, quaterly_Extra)

            //console.log(Object.assign(xAxis, quaterly_Extra));
            var toolTip = {
                formatter: function() {
                    var s = '<b>';
                    var ss = '';
                    var _Inside_data_Type;

                    $.each(this.points, function(i, point) {

                        var eachSeriesData = point.series.userOptions.data;
                        var eachSeriesDataLast = eachSeriesData.length - 1;
                        var eachSeriesDataQuat = eachSeriesData.length - 2;

                        //var Second_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataLast][0]));
                        //var First_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataQuat][0]));
                        var diffTime = Math.abs(parseInt(eachSeriesData[eachSeriesDataLast][0]) - parseInt(eachSeriesData[eachSeriesDataQuat][0]));
                        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        //console.log(diffDays);
                        if (diffDays >= 90 && diffDays <= 92) {
                            _Inside_data_Type = 'quaterly';
                        } else if (diffDays >= 28 && diffDays <= 32) {
                            _Inside_data_Type = 'monthly';
                        } else if (diffDays >= 360 && diffDays <= 365) {
                            _Inside_data_Type = 'anual';
                        } else if (diffDays == 1) {
                            _Inside_data_Type = 'daily';
                        } else {
                            _Inside_data_Type = chartCommon.Conf.chart_data_type;
                        }



                        var s = '<b>';
                        if (_Inside_data_Type == 'quaterly') {

                            if (Highcharts.dateFormat('%b', point.x) == 'Mar') {
                                s = s + "Q1"
                            } else if (Highcharts.dateFormat('%b', point.x) == 'Jun') {
                                s = s + "Q2"
                            } else if (Highcharts.dateFormat('%b', point.x) == 'Sep') {
                                s = s + "Q3"
                            } else if (Highcharts.dateFormat('%b', point.x) == 'Dec') {
                                s = s + "Q4"
                            } else {
                                s = s + Highcharts.dateFormat('%b', point.x);
                            }
                        } else if (_Inside_data_Type == 'monthly') {
                            s = s + Highcharts.dateFormat('%b', point.x);
                        } else if (_Inside_data_Type == 'daily') {
                            s = s + Highcharts.dateFormat('%a %b %e,', point.x);
                        }
                        // console.log(_Inside_data_Type);
                        s = s + " " + Highcharts.dateFormat('%Y', point.x) + '</b>';
                        var symbol = '<span style="color:' + point.series.color + '">●</span>';
                        ss += symbol + point.series.name + ' (' + s + '): ' + point.y + '<br/>';
                    });
                    ss = ss.slice(0, -5);
                    return ss;
                },

                followTouchMove: false,
                useHTML: true,
                backgroundColor: null,
                positioner: function() {
                    return { x: 37, y: 285 };
                }
            };

            if (this.Conf.chart_data_type == 'quaterly') {
                Object.assign(toolTip, { shared: true, borderWidth: 0, shadow: false });
            } else {
                Object.assign(toolTip, { style: tooltipstyle, padding: 0 });
            }



            var yAxis = {
                gridLineWidth: 1.5, // The default value, no need to change it
                gridLineDashStyle: 'Dot',
                gridLineColor: '#999999',
                gridZIndex: -10,
                // offset : 10,
                opposite: false,
                labels: {
                    align: 'right',
                    // y: 3
                },
                plotLines: [{
                    value: 0,
                    color: 'black',
                    dashStyle: 'shortdash',
                    width: 1.5
                }]
            };
            // var nav_ser_data = chart_data_series[0];
            // nav_ser_data['color'] = '#DE4623';
            // nav_ser_data['type'] = 'areaspline';









            var cht = new Highcharts.StockChart({
                chart: {
                    renderTo: graph_container,
                    //backgroundColor : '#FBFBFB',
                    backgroundColor: '#f5f5f5',
                    plotBorderColor: '#000000',
                    plotBackgroundColor: '#FFFFFF',
                    plotBorderWidth: 0.5,
                    spacingBottom: 35,
                    alignTicks: true
                },

                exporting: {
                    enabled: false,
                    chartOptions: {
                        chart: {
                            //	spacingBottom : 85,
                            events: {
                                load: function() {
                                    this.renderer.image(window.location.protocol + '//www.indiamacroadvisors.com/assets/images/logo.png', 385, 300, 195, 16).add();
                                    this.renderer.text("Source : " + chartCommon.Conf.sources, 10, 310, 159, 33).css({ size: '3px' }).add();
                                }
                            }
                        },
                        navigator: {
                            enabled: false
                        },
                        scrollbar: {
                            enabled: false
                        },
                        tooltip: { enabled: false },
                        legend: {
                            enabled: true,
                            backgroundColor: '#fffde1',
                            verticalAlign: 'top',
                            align: 'center',
                            itemStyle: {
                                color: '#274b6d',

                            }
                        }
                    }
                },
                colors: chartCommon.chartConfigs.colors,
                credits: {
                    enabled: false,
                    href: 'https://www.indiamacroadvisors.com',
                    text: 'indiamacroadvisors.com'
                },
                series: chart_data_series,
                rangeSelector: {
                    enabled: false,
                },
                plotOptions: {
                    line: {

                        dataGrouping: {
                            enabled: false,
                            approximation: 'average',
                            dateTimeLabelFormats: {
                                month: ['%B %Y', '%B', '-%B %Y']
                            }
                        }
                    },
                    series: {
                        // allowPointSelect: true,
                        connectNulls: true,
                        dataLabels: {
                            allowOverlap: true,


                        }
                    },
                },

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                enabled: true,
                                align: 'center',
                                backgroundColor: '#dddddd',
                                verticalAlign: 'top',
                                layout: 'horizontal',
                                labelFormatter: function() {
                                    var legendName = this.name;
                                    var match = legendName.match(/.{1,70}/g);
                                    return match.toString().replace(/\,/g, "<br/>");
                                },
                                itemStyle: {
                                    width: 350,
                                    fontSize: 11
                                }
                            },
                        }
                    }, {
                        condition: {
                            minWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                enabled: true,
                                align: 'center',
                                backgroundColor: '#dddddd',
                                verticalAlign: 'top',
                                layout: 'horizontal',
                                //labelFormatter: wordwapF,
                                itemStyle: {
                                    color: '#274b6d'
                                }
                            },
                        }
                    }, {
                        condition: {
                            maxWidth: 439
                        },
                        chartOptions: {
                            legend: {
                                enabled: true,
                                align: 'center',
                                backgroundColor: '#dddddd',
                                verticalAlign: 'top',
                                layout: 'horizontal',
                                itemStyle: {
                                    width: 190,
                                    fontSize: 11
                                }
                            },
                        }
                    }]
                },


                navigator: {
                    enabled: chartCommon.Conf.isNavigator,
                    maskFill: "rgba(0, 0, 0, 0.10)",
                    series: {
                        lineColor: '#316AB4'
                    }
                },

                yAxis: yAxis,
                xAxis: xAxis,
                tooltip: toolTip
            }, function(p_chrtObj) {

                p_chrtObj.renderer.image(window.location.protocol + '//www.indiamacroadvisors.com/assets/images/logo.png', (chartCommon.Conf.chartLayout == 'narrow' && IMA.controller != 'home') ? 700 : 365, 380, 218, 17).add();
                p_chrtObj.renderer.text("Source : " + chartCommon.Conf.sources, 10, 388, 159, 33).add();
                this.controller != 'home'
                p_chrtObj.xAxis[0].setExtremes(
                    chartCommon.Conf.navigator_date_from,
                    chartCommon.Conf.navigator_date_to);
                if (p_chrtObj.xAxis[0].tickPositions.length > 12) {
                    p_chrtObj.xAxis[0].update({ labels: { rotation: -45 } });
                }

                p_chrtObj.yAxis[0].update({ reversed: chartCommon.Conf.reverseYAxis });


            });

            return cht;
        }
    };



    this.drawJmaChart = function(mobileView) {
        var md = new MobileDetect(window.navigator.userAgent);
        var chart_data_series = this.createChartDataSeries();
       // var tableClass = new creativeTableOnIndicatorPage(chart_data_series, chartCommon);
        //tableClass.enableSwitchingChartToTable();
        if (md.mobile() || md.tablet()) {
            tableClass.mobilelegent(chart_data_series);
            $('.amc-btn').on('click', function() {
                $(this).parent('.add-more-con').toggleClass('amc-menu');
                var menuEls = document.querySelectorAll('nav.amc-maimen');
                console.log(menuEls.length);
                menuEls.forEach(function(menuEl) {
                    var mlmenu = new MLMenu(menuEl, {
                        backCtrl: false,
                    });
                });
            });
        } else {
            mobileView = false;
        }
        this.chart_object = this.createHighChart(chart_data_series, mobileView);
        //tableClass.enableSwitchingChartToTableOnDefault();
    };

    this.drawChart = function(mobileView) {
        var md = new MobileDetect(window.navigator.userAgent);
        if (md.mobile() || md.tablet()) {
            $('.amc-btn').on('click', function() {
                $(this).parent('.add-more-con').toggleClass('amc-menu');
                var menuEls = document.querySelectorAll('nav.amc-maimen');
                console.log(menuEls.length);
                menuEls.forEach(function(menuEl) {
                    var mlmenu = new MLMenu(menuEl, {
                        backCtrl: false,
                    });
                });
            });
        } else {
            mobileView = false;
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
       // this.drawChartLayout(mobileView);
        if (this.Conf.chartLayout == 'normal') {
            this.drawSeriesLayout();
        }
        this.drawJmaChart(mobileView);
       // this.initializeGraphDomelements();
    };
    this.setConfigurations();
}

// Class LineChart
module.exports = LineChart;