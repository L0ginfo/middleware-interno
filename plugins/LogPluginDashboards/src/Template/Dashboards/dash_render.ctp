<script>
    var aCharts = new Array()
</script>
<?php 

    echo $this->Html->css([        
        '/LogPluginDashboards/css/Plugins/Chartist/chartist.min',
        '/LogPluginDashboards/css/Plugins/Chartist/chartist-plugin-tooltip',
    ]);

    echo $this->Html->script([        
        '/LogPluginDashboards/js/Plugins/Chartist/chartist.min',
        '/LogPluginDashboards/js/Plugins/Chartist/chartist-plugin-tooltip.min',
        '/LogPluginDashboards/js/Plugins/Chartist/chartist-plugin-legend',
        '/LogPluginDashboards/js/GraphController',
    ]);

?>

<?php echo $this->element('LogPluginDashboards./../Dashboards/Elements/cards'); ?>

<div class="graph-structure">
    <?php

        foreach ($aDashboards as $oDashboard) {
            foreach ($oDashboard->dashboard_graficos as $oDashboardGraph) {
                echo $this->element('LogPluginDashboards./../Dashboards/Elements/grafico', compact('oDashboardGraph'));
            }
        }

    ?>
</div>

<style>
    .graph-structure {
        display: flex;
        flex-wrap: wrap;
    }

    .graph-content {
        margin-bottom: 40px;
    }

    .graph-title {
        text-align: center;
        font-size: 18px;
        font-weight: 600;
    }

    .macro-info {
        font-size: 13px;
        margin: 14px 30px;
    }

    .macro-info select,
    .macro-info input {
        font-size: 13px;
        margin: 0px 2px;
        height: 24px;
    }

    .fa.fa-filter {
        margin-right: 9px;
    }

    .ct-labels span {
        color: #000;
        font-size: 10px;
    }

    .ct-label {
        fill: rgba(0,0,0,.4);
        color: rgba(0,0,0);
        font-size: .99rem;
        line-height: 1;
    }

    .ct-chart {
        position: relative;
    }
    
    .ct-legend {
        position: relative;
        z-index: 10;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding-inline-start: 0px;
    }

    .ct-legend li {
        position: relative;
        padding-left: 23px;
        margin-bottom: 3px;
        list-style: none;
    }

    .ct-legend li:before {
        width: 12px;
        height: 12px;
        position: absolute;
        top: 4px;
        left: 7px;
        content: '';
        border: 3px solid transparent;
        border-radius: 2px;
    }

    .ct-legend li.inactive:before {
        background: transparent;
    }

    .ct-legend.ct-legend-inside {
        position: absolute;
        top: 0;
        right: 0;
    }

    .ct-legend .ct-series-0:before {
        background-color: #d70206;
        border-color: #d70206;
    }

    .ct-legend .ct-series-1:before {
        background-color: #f05b4f;
        border-color: #f05b4f;
    }

    .ct-legend .ct-series-2:before {
        background-color: #f4c63d;
        border-color: #f4c63d;
    }

    .ct-legend .ct-series-3:before {
        background-color: #d17905;
        border-color: #d17905;
    }

    .ct-legend .ct-series-4:before {
        background-color: #453d3f;
        border-color: #453d3f;
    }

    .ct-legend .ct-series-5:before {
        background-color: #59922b;
        border-color: #59922b;
    }

    .ct-legend .ct-series-6:before {
        background-color: #0544d3;
        border-color: #0544d3;
    }

    .ct-legend .ct-series-7:before {
        background-color: #6b0392;
        border-color: #6b0392;
    }

    .ct-legend .ct-series-8:before {
        background-color: #f05b4f;
        border-color: #f05b4f;
    }

    .ct-legend .ct-series-9:before {
        background-color: #dda458;
        border-color: #dda458;
    }

    .ct-legend .ct-series-10:before {
        background-color: #eacf7d;
        border-color: #eacf7d;
    }

    .ct-legend .ct-series-11:before {
        background-color: #86797d;
        border-color: #86797d;
    }

    .ct-legend .ct-series-12:before {
        background-color: #b2c326;
        border-color: #b2c326;
    }

    .ct-legend .ct-series-13:before {
        background-color: #6188e2;
        border-color: #6188e2;
    }

    .ct-legend .ct-series-14:before {
        background-color: #a748ca;
        border-color: #a748ca;
    }

</style>