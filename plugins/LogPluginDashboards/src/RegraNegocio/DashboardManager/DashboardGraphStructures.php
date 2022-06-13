<?php
/**
 * Author: Silvio Regis 24/06/2020 11:45
 */

namespace LogPluginDashboards\RegraNegocio\DashboardManager;

use App\Model\Entity\Consulta;
use App\Util\ObjectUtil;
use Cake\ORM\TableRegistry;

class DashboardGraphStructures
{
    private static $oDashboardGrafico = null; 
    private static $aFormatos = [
        'Line' => '
            aCharts.oChart_[[GRAPH_REFERER]] = new Chartist.Line(".graph_[[GRAPH_REFERER]]", 
                [[GRAPH_DATA]]
                [[GRAPH_PARAMS]]
                [[GRAPH_RESPONSIVE_OPTS]]
            );

            [[GRAPH_EXTRA]]
        ',
        'Bar' => '
            aCharts.oChart_[[GRAPH_REFERER]] = new Chartist.Bar(".graph_[[GRAPH_REFERER]]", 
                [[GRAPH_DATA]]
                [[GRAPH_PARAMS]]
                [[GRAPH_RESPONSIVE_OPTS]]
            );

            [[GRAPH_EXTRA]]
        '
    ];

    public static function getGraphScripts($aDashboardGraficos)
    {
        foreach ($aDashboardGraficos as $oDashboardGrafico) {
            self::setGraphScript($oDashboardGrafico);
        }

        return $aDashboardGraficos;
    }

    public static function setGraphScript($oDashboardGrafico, $sMacro = '', $aDates = [])
    {
        self::$oDashboardGrafico = $oDashboardGrafico;

        $sGraphScript = '';
        $sFormat = self::getFormat();

        if (!$sFormat)
            return '';

        $sGraphScript = $sFormat;
        $sGraphScript = self::setParams($sGraphScript);
        $sGraphScript = self::setResponsiveOpts($sGraphScript);
        $sGraphScript = self::setExtra($sGraphScript);
        $sGraphScript = self::setReferer($sGraphScript);
        $sGraphScript = self::setData($sGraphScript, $sMacro, $aDates);
        
        $oDashboardGrafico->script = $sGraphScript;

        $oDashboardGrafico->macros = DashboardMacrosStructure::getMacrosOptions();

        //seta legends
        $oDashboardGrafico->script = str_replace(
            DashboardMacrosStructure::$sMacroTagLegends, 
            $oDashboardGrafico->graph_legends, 
            $oDashboardGrafico->script
        );

        // echo '<textarea>';
        // echo $oDashboardGrafico->script;
        // die;

        return $oDashboardGrafico;
    }

    private static function setData($sGraphScript, $sMacro, $aDates)
    {
        $aDadosConsulta = [];

        if(self::$oDashboardGrafico->consulta->conteudo){
            $aDadosConsulta = DashboardMacrosStructure::getDataByMacro(self::$oDashboardGrafico, $sMacro, $aDates);
        }

        if (!$aDadosConsulta) {
            self::$oDashboardGrafico->query_data = [
                'labels' => [],
                'series' => []
            ];
            return null;
        }
        
        $aData = self::getData($sGraphScript, $aDadosConsulta);

        self::$oDashboardGrafico->query_data = $aData;

        return str_replace('[[GRAPH_DATA]]', ObjectUtil::getAsJson($aData), $sGraphScript);
    }

    private static function setExtra($sGraphScript)
    {
        return str_replace('[[GRAPH_EXTRA]]', self::$oDashboardGrafico->extra_script, $sGraphScript);
    }

    private static function setParams($sGraphScript)
    {
        $sParams = self::$oDashboardGrafico->dashboard_grafico_tipo->grafico_params;
        
        if (!$sParams)
            $sParams = '{}';
        
        return str_replace('[[GRAPH_PARAMS]]', ', ' . $sParams, $sGraphScript);
    }

    private static function setResponsiveOpts($sGraphScript)
    {
        $sResponsiveOpts = self::$oDashboardGrafico->responsive_options;
        
        if (!$sResponsiveOpts)
            $sResponsiveOpts = '{}';
            
        return str_replace('[[GRAPH_RESPONSIVE_OPTS]]', ', ' . $sResponsiveOpts, $sGraphScript);
    }

    private static function setReferer($sGraphScript)
    {
        return str_replace('[[GRAPH_REFERER]]', self::$oDashboardGrafico->id, $sGraphScript);
    }

    private static function getFormat()
    {
        $oFormato = self::$oDashboardGrafico->dashboard_grafico_tipo->dashboard_grafico_formato;

        if (array_key_exists($oFormato->descricao, self::$aFormatos)) {
            return self::$aFormatos[$oFormato->descricao];
        }

        return '';
    }

    private static function getData($sGraphScript, $aDadosConsulta)
    {
        $aData = [];
        $aLegends = [];

        if (self::$oDashboardGrafico->usa_macros_periodos){
            $aDataByPeriod = DashboardMacrosStructure::getDataByPeriod(self::$oDashboardGrafico, $aDadosConsulta);

            $aData['labels'] = DashboardMacrosStructure::getLabelsPeriod($aDataByPeriod['full_data']);
            $aData['series'] = DashboardMacrosStructure::getSeriesPeriod($aDataByPeriod['data_agroup']);
            
            $aLegends = DashboardMacrosStructure::getLegendsPeriod($aDataByPeriod['full_data']);
            
        }else {
            $aData['labels'] = array_keys($aDadosConsulta[0]);
            $aData['series'] = array_reduce($aDadosConsulta, function($aCarry, $aItem) {
                $aCarry[] = array_values($aItem);
                return $aCarry;
            }, []);
            
            $aLegends = $aData['labels'];
        }

        self::$oDashboardGrafico->graph_legends = json_encode($aLegends);

        return $aData;
    }
}