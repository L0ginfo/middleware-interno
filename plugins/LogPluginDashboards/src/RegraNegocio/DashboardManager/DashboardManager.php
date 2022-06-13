<?php
/**
 * Author: Silvio Regis 24/06/2020 11:44
 */

namespace LogPluginDashboards\RegraNegocio\DashboardManager;

use Cake\View\View;

class DashboardManager 
{
    private static $sViewElement = 'LogPluginDashboards.Dashboards/dash_render';

    public static function init($oView)
    {
        $aDashboards = DashboardFinder::get();
        $aDashboards = self::setGraphScripts($aDashboards);
        
        return self::getHtmlDashboards($aDashboards);
    }

    private static function getHtmlDashboards($aDashboards)
    {
        $oViewBuilder = new View();

        // create a builder
        $oBuilder = $oViewBuilder->viewBuilder();

        // configure as needed
        $oBuilder->setLayout('ajax');
        $oBuilder->setTemplate(self::$sViewElement);   //Here you can use elements also
        $oBuilder->setHelpers(['Html']);

        // create a view instance
        $oView = $oBuilder->build(compact('aDashboards'));   //Pass the variables to the view

        // render to a variable
        return $oView->render();
    }

    private static function setGraphScripts($aDashboards)
    {
        foreach ($aDashboards as $oDashboard) {
            $oDashboard->dashboard_graficos = DashboardGraphStructures::getGraphScripts($oDashboard->dashboard_graficos);
        }

        return $aDashboards;
    }
}