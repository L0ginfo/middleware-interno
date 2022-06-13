jQuery(function ($) {

    var demo = {
        initDocumentationCharts: function() {
            if ($('#dailySalesChart').length != 0 && $('#websiteViewsChart').length != 0) {
                /* ----------==========     Daily Sales Chart initialization For Documentation    ==========---------- */
    
                dataDailySalesChart = {
                    labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
                    series: [
                        [12, 17, 7, 17, 23, 18, 38]
                    ]
                };
    
                optionsDailySalesChart = {
                    lineSmooth: Chartist.Interpolation.cardinal({
                        tension: 0
                    }),
                    low: 0,
                    high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                    chartPadding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    },
                }
    
                var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);
    
                var animationHeaderChart = new Chartist.Line('#websiteViewsChart', dataDailySalesChart, optionsDailySalesChart);
            }
        },
    
        initDashboardPageCharts: function() {
    
            if ($('#dailySalesChart').length != 0 || $('#completedTasksChart').length != 0 || $('#websiteViewsChart').length != 0) {
                /* ----------==========     Daily Sales Chart initialization    ==========---------- */
    
                dataDailySalesChart = {
                    labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                    series: [
                        [30, 10, 20, 49, 41, 35],
                        [20, 40, 10, 30, 11, 55],
                        [50, 1, 28, 40, 32, 15]
                    ]
                };
    
                optionsDailySalesChart = {
                    lineSmooth: Chartist.Interpolation.cardinal({
                        tension: 0
                    }),
                    low: 0,                    
                    showArea: true,
                    showPoint: false,
                    fullWidth: true,
                    high: 60, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                    chartPadding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    },
                }
    
                
                var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);
    
                dailySalesChart.on('draw', function(data) {
                    if(data.type === 'line' || data.type === 'area') {
                        data.element.animate({
                            d: {
                                begin: 1000 * data.index,
                                dur: 1000,
                                from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                                to: data.path.clone().stringify(),
                                easing: Chartist.Svg.Easing.easeOutQuint
                            }
                        });
                    }
                });
    
                /* ----------==========     Completed Tasks Chart initialization    ==========---------- */
    
                datacompletedTasksChart = {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    series: [
                        [5, 4, 3, 7, 5, 10, 3, 4, 8, 10, 6, 8],
                        [3, 2, 9, 5, 4, 6, 4, 6, 7, 8, 7, 4]
                    ]
                };
    
                optionscompletedTasksChart = {
                    seriesBarDistance: 10
                }
    
                var completedTasksChart = new Chartist.Bar('#completedTasksChart', datacompletedTasksChart, optionscompletedTasksChart);
    
                completedTasksChart.on('draw', function(data) {
                    if(data.type == 'bar') {
                        data.element.animate({
                            y1: {
                                dur: '0.1s',
                                from: data.y2,
                                to: data.y1
                            },
                            x1: {
                                dur: '1s',
                                from: data.x2,
                                to: data.x2
                            },
                            y2: {
                                dur: '2.2s',
                                from: data.y1,
                                to: data.y2
                            }
                        });
                    }
                });
            }
        },
    
    }

    $(window).load(function () {
        demo.initDashboardPageCharts()
    });

})