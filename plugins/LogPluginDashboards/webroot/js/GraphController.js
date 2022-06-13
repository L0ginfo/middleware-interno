const GraphController = {
    init: function() {
        this.onChangeMacro()
        this.onCompleteDates()
    },

    onCompleteDates: function() {
        $('.graph-content .macro-info .graph-date').each(function() {
            $(this).addClass('watched-changes')

            $(this).change(function() {
                var iCountDatesCompleted = 0
                var oGraphInfo = $(this).closest('.macro-info')

                if ($(this).val()) {
                    iCountDatesCompleted++
                }

                if ($(this).hasClass('date-initial')) {
                    if (oGraphInfo.find('.date-final').val()) {
                        iCountDatesCompleted++
                    }
                }else if (oGraphInfo.find('.date-initial').val()) {
                    iCountDatesCompleted++
                }

                if (iCountDatesCompleted == 2) {
                    GraphController.setGraphData(oGraphInfo.find('.macros'), {
                        first_date: oGraphInfo.find('.date-initial').val(),
                        last_date: oGraphInfo.find('.date-final').val()
                    })
                }
            })
        })
    },

    onChangeMacro: function() {
        $('.graph-content .macros:not(.watched-changes)').each(function() {
            $(this).addClass('watched-changes')
            
            $(this).change(function () {
                if ($(this).val() != 'periodo_especifico') {
                    GraphController.setGraphData($(this))
                    GraphController.hideDates($(this))
                }else {
                    GraphController.showDates($(this))
                }
            })
        })
    },

    setGraphData: async function (oMacroSelected, oDates = {}) {

        const oGraphData = await $.fn.doAjax({
            url: 'log-plugin-dashboards/dashboard-graficos/get-data-by-macro',
            data: {
                macro: oMacroSelected.val(),
                graph: oMacroSelected.attr('graph'),
                dates: oDates
            },
            type: 'POST'
        })

        if (oGraphData.status != 200)
            return;

        this.addData(oMacroSelected, oGraphData.dataExtra)
    },

    addData: function (oMacroSelected, oData) {
        var iGraphID = oMacroSelected.attr('graph')

        aCharts['oChart_' + iGraphID].data.labels = oData.query_data.labels;
        aCharts['oChart_' + iGraphID].data.series = oData.query_data.series;
        aCharts['oChart_' + iGraphID].options.plugins = new Array();

        aCharts['oChart_' + iGraphID].update();

        // aCharts['oChart_' + iGraphID].options.plugins = Chartist.plugins.legend({
        //     position: "bottom",
        //     legendNames: oData.graph_legends
        // });

        aCharts['oChart_' + iGraphID].update();

    },

    showDates: function(oMacroSelected) {
        $(oMacroSelected).closest('.macro-info').find('.graph-date').removeClass('hidden')
    },

    hideDates: function(oMacroSelected) {
        $(oMacroSelected).closest('.macro-info').find('.graph-date').val(null)
        $(oMacroSelected).closest('.macro-info').find('.graph-date').addClass('hidden')
    }
}

$(document).ready(function () {
    GraphController.init()
})