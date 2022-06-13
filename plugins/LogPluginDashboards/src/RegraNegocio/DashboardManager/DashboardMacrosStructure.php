<?php
/**
 * Author: Silvio Regis 24/06/2020 11:45
 */

namespace LogPluginDashboards\RegraNegocio\DashboardManager;

use App\Model\Entity\Consulta;

class DashboardMacrosStructure
{
    public static $sMacroTagExpr    = '[[DASH_GRAPH_MACRO_DATE]]';
    public static $sMacroTagInitial = '[[DASH_GRAPH_MACRO_INI_DATE]]';
    public static $sMacroTagFinal   = '[[DASH_GRAPH_MACRO_FIN_DATE]]';
    public static $sMacroTagLegends = '[[DASH_GRAPH_MACRO_LEGENDS]]';

    public static function getMacros($aDatesSelected = [])
    {
        return [
            'mes_atual' => [
                'descricao' => 'Mês Atual',
                'first_date' => date('Y-m-d', strtotime(date('Y-m-1'))),
                'last_date' => date('Y-m-t', strtotime(date('Y-m-d')))
            ],
            'mes_anterior' => [
                'descricao' => 'Mês Anterior',
                'first_date' => date('Y-m-d', strtotime('first day of previous month')),
                'last_date' => date('Y-m-d', strtotime('last day of previous month'))
            ],
            'ano_atual' => [
                'descricao' => 'Ano Atual',
                'first_date' => date('Y-m-d', strtotime(date('Y-1-1'))),
                'last_date' => date('Y-m-t', strtotime(date('Y-12-d')))
            ],
            'ano_anterior' => [
                'descricao' => 'Ano Anterior',
                'first_date' => date('Y-m-d', strtotime( (date('Y') - 1) . date('-1-1'))),
                'last_date' => date('Y-m-t', strtotime( (date('Y') - 1) . date('-12-d')))
            ],
            'periodo_especifico' => [
                'descricao' => 'Período Específico',
                'first_date' => '',
                'last_date' => ''
            ],
        ];
    }

    public static function getMacrosOptions()
    {
        $aMacrosOptions = [];
        $aMacros = self::getMacros();

        foreach ($aMacros as $sMacroKey => $aMacro) {
            $aMacrosOptions[ $sMacroKey ] = $aMacro['descricao'];
        }
        
        return $aMacrosOptions;
    }

    public static function getDataByMacro($oDashboardGrafico, $sMacroSelected, $aDates)
    {
        $sMacro = !$sMacroSelected ? 'mes_atual' : $sMacroSelected;
        $aDadosConsulta = [];

        $sInitialQuery = $oDashboardGrafico->consulta->conteudo;
        $oDashboardGrafico->consulta->conteudo = DashboardMacrosStructure::getMacroExpression($oDashboardGrafico, $sMacro, $aDates);
        $aDadosConsulta = Consulta::getContentsForView($oDashboardGrafico->consulta->conteudo, $sMacro);

        if ($sMacroSelected)
            return $aDadosConsulta;

        if (!$aDadosConsulta) {
            $oDashboardGrafico->consulta->conteudo = $sInitialQuery;
            $oDashboardGrafico->consulta->conteudo = DashboardMacrosStructure::getMacroExpression($oDashboardGrafico, 'mes_anterior', $aDates);
            $aDadosConsulta = Consulta::getContentsForView($oDashboardGrafico->consulta->conteudo, 'mes_anterior');
        }

        if (!$aDadosConsulta) {
            $oDashboardGrafico->consulta->conteudo = $sInitialQuery;
            $oDashboardGrafico->consulta->conteudo = DashboardMacrosStructure::getMacroExpression($oDashboardGrafico, 'ano_atual', $aDates);
            $aDadosConsulta = Consulta::getContentsForView($oDashboardGrafico->consulta->conteudo, 'ano_atual');
        }

        if (!$aDadosConsulta) {
            $oDashboardGrafico->consulta->conteudo = $sInitialQuery;
            $oDashboardGrafico->consulta->conteudo = DashboardMacrosStructure::getMacroExpression($oDashboardGrafico, 'ano_anterior', $aDates);
            $aDadosConsulta = Consulta::getContentsForView($oDashboardGrafico->consulta->conteudo, 'ano_anterior');
        }  

        return $aDadosConsulta;
    }

    public static function getMacroExpression($oDashboardGrafico, $sMacro = 'mes_atual', $aDatesSelected = [])
    {
        $aDates = self::getDates($sMacro, $aDatesSelected);

        $sCampoMacroInicio = $oDashboardGrafico->campo_macro_dt_inicio;
        $sCampoMacroFim = $oDashboardGrafico->campo_macro_dt_fim;

        $sMacroToReplace = 
            $sCampoMacroInicio . ' >= "' . $aDates['first_date'] . '" AND '
          . $sCampoMacroFim . ' <= "' . $aDates['last_date'] . '"';

        
        $oDashboardGrafico->macro_utilizada = $sMacro;

        return str_replace(
            [self::$sMacroTagExpr, self::$sMacroTagInitial, self::$sMacroTagFinal], 
            [$sMacroToReplace, $aDates['first_date'], $aDates['last_date']], 
            $oDashboardGrafico->consulta->conteudo
        );
    }

    private static function getDates($sMacro, $aDatesSelected)
    {
        $aMacros = self::getMacros();

        if (!array_key_exists($sMacro, $aMacros))
            $sMacro = 'mes_atual';

        $aMacroSelected = $aMacros[$sMacro];

        if ($sMacro == 'periodo_especifico') {
            $aMacroSelected['first_date'] = $aDatesSelected['first_date'];
            $aMacroSelected['last_date']  = $aDatesSelected['last_date'];
        }

        return $aMacroSelected;
    }

    public static function getLegendsPeriod($aDataByPeriod)
    {
        $aLegends = [];
        
        foreach ($aDataByPeriod as $aDataQuery) {
            $sAxisX = array_keys($aDataQuery)[1];
            $aLegends[$aDataQuery[$sAxisX]] = $aDataQuery[$sAxisX];
        }

        return array_values($aLegends);
    }

    private static function agroupDataByAxisY($aDataByPeriod)
    {
        $aDataByAxisY = [];

        foreach ($aDataByPeriod as $sPeriodKey => $aDataQuery) {
            $sPeriodName = explode('_', $sPeriodKey)[0];
            $sAxisY = array_keys($aDataQuery)[0];
            $sAxisX = array_keys($aDataQuery)[1];
            $aDataByAxisY[ $aDataQuery[$sAxisX] ][ $sPeriodName ] = [
                'meta'  => $aDataQuery[$sAxisX],
                'name'  => $aDataQuery[$sAxisX],
                'value' => $aDataQuery[$sAxisY],
                'data'  => $aDataQuery[$sAxisY]
            ];
        }

        //order asc
        foreach ($aDataByAxisY as $sAxisX => $aDataByPeriod) {
            ksort($aDataByPeriod);
            $aDataByAxisY[$sAxisX] = $aDataByPeriod;
        }

        return $aDataByAxisY;
    }

    public static function getSeriesPeriod($aDataByPeriod)
    {
        $aSeries = [];

        //$aDataByAxisY = self::agroupDataByAxisY($aDataByPeriod);

        foreach ($aDataByPeriod as $sPeriodName => $aDataAgroup) {
            $aSeries[] = array_values($aDataAgroup);
        }
        
        return $aSeries;
    }

    // private static function getAllDataFromAxisYByPeriodKey($aDataByPeriod, $sPeriodKeySearch)
    // {
    //     $sPeriodType = explode('_', $sPeriodKeySearch)[1];
    //     $sKeyToSearch = '_' . $sPeriodType . '__';

    //     $aAllData = [];

    //     foreach ($aDataByPeriod as $sPeriodKey => $aData) {
    //         if (strpos($sPeriodKey, $sKeyToSearch) !== false) {
    //             $sAxisY = array_keys($aData)[0];
    //             $aAllData[] = $aData[$sAxisY];
    //         }
    //     }

    //     return $aAllData;
    // }

    public static function getLabelsPeriod($aDataByPeriod)
    {
        $aLabels = [];

        foreach ($aDataByPeriod as $sPeriodKey => $aData) {
            $sPeriodName = explode('_', $sPeriodKey)[0];
            $aLabels[$sPeriodName] = true;
        }

        //order asc
        ksort($aLabels);

        return array_keys($aLabels);
    }

    public static function getDataByPeriod($oDashboardGrafico, $aDadosConsulta)
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $aDataInDays   = self::getByDays($oDashboardGrafico, $aDadosConsulta, $oDashboardGrafico->campo_macro_dt_inicio);
        $aDataInMonths = self::getByMonths($oDashboardGrafico, $aDadosConsulta, $oDashboardGrafico->campo_macro_dt_inicio);
        $aDataInYears  = self::getByYears($oDashboardGrafico, $aDadosConsulta, $oDashboardGrafico->campo_macro_dt_inicio);

        $aDataInDaysAgroup   = self::agroupDataByAxisY($aDataInDays);
        $aDataInMonthsAgroup = self::agroupDataByAxisY($aDataInMonths);
        $aDataInYearsAgroup  = self::agroupDataByAxisY($aDataInYears);
        
        if (@count($aDataInDaysAgroup[@array_keys($aDataInDaysAgroup)[0]]) <= 31)
            return [
                'full_data' => $aDataInDays,
                'data_agroup' => $aDataInDaysAgroup
            ];
        elseif (@count($aDataInMonthsAgroup[@array_keys($aDataInMonthsAgroup)[0]]) <= 12)
            return [
                'full_data' => $aDataInMonths,
                'data_agroup' => $aDataInMonthsAgroup
            ];
        else 
            return [
                'full_data' => $aDataInYears,
                'data_agroup' => $aDataInYearsAgroup
            ];
    }

    private static function agroupDataXY($oDashboardGrafico, $aDataInPeriod)
    {
        $aDataAgroup = [];

        foreach ($aDataInPeriod as $sPeriodName => $aDataInPeriod) {
            $aTempDataAgroup = [];

            foreach ($aDataInPeriod as $key => $aDataQuery) {
                $sAxisY = array_keys($aDataQuery)[0];
                $sAxisX = array_keys($aDataQuery)[1];
                $sKeyAgroup = $sPeriodName . '_' . $aDataQuery[ $sAxisX ] . '__';

                if (array_key_exists($sKeyAgroup, $aTempDataAgroup)) {
                    $aTempDataAgroup[$sKeyAgroup][$sAxisY] += $aDataQuery[$sAxisY];
                }else {
                    $aTempDataAgroup[$sKeyAgroup] = $aDataQuery;
                }
            }
            
            $aTempDataAgroup = self::orderData($oDashboardGrafico, $aTempDataAgroup, $sPeriodName);

            $aDataAgroup += $aTempDataAgroup;
        }

        $aDataAgroup = self::insertDataInNulls($oDashboardGrafico, $aDataAgroup);

        return $aDataAgroup;
    }

    private static function insertDataInNulls($oDashboardGrafico, $aDataAgroup)
    {
        $aExemple = [];

        foreach ($aDataAgroup as $sPeriodKey => $aDataQuery) {
            if ($aDataQuery != null) {
                $aExemple = $aDataQuery;
                break;
            }
        }

        foreach ($aDataAgroup as $sPeriodKey => $aDataQuery) {
            if ($aDataQuery == null) {
                $sPeriodAxisX = explode('_', $sPeriodKey)[1];
                @$sAxisY = array_keys($aExemple)[0];
                @$sAxisX = array_keys($aExemple)[1];
                
                $aDataAgroup[$sPeriodKey] = $aExemple;
                $aDataAgroup[$sPeriodKey][$sAxisY] = 0;
                $aDataAgroup[$sPeriodKey][$sAxisX] = $sPeriodAxisX;
                $aDataAgroup[$sPeriodKey][$oDashboardGrafico->campo_macro_dt_inicio] = '';
            }
        }

        return $aDataAgroup;
    }

    private static function orderData($oDashboardGrafico, $aTempDataAgroup, $sPeriodName)
    {
        $aOrder = explode(',', $oDashboardGrafico->ordenacao_eixo_x);

        //adiciona os exios X que não existem
        foreach ($aOrder as $sOrderName) {
            $sKeyPeriod = $sPeriodName . '_' . $sOrderName . '__';
            if (!array_key_exists($sKeyPeriod, $aTempDataAgroup)) {
                $aTempDataAgroup[$sKeyPeriod] = null;
            }
        }

        $aAuxTempDataAgroup = [];

        //ordena conforme o cadastro
        foreach ($aOrder as $sOrderName) {
            $sKeyPeriod = $sPeriodName . '_' . $sOrderName . '__';
            $aAuxTempDataAgroup[$sKeyPeriod] = $aTempDataAgroup[$sKeyPeriod];
        }

        $aTempDataAgroup = $aAuxTempDataAgroup;

        return $aTempDataAgroup;
    }

    private static function getByDays($oDashboardGrafico, $aDadosConsulta, $sColumnDate)
    {
        $aDays = [];

        foreach ($aDadosConsulta as $aDado) {
            $iDay = (int) date('d', strtotime($aDado[$sColumnDate]));
            $aDays[ $iDay ][] = $aDado;
        }

        $aDays = self::agroupDataXY($oDashboardGrafico, $aDays);

        return $aDays;
    }

    private static function getByMonths($oDashboardGrafico, $aDadosConsulta, $sColumnDate)
    {
        $aMonths = [];

        foreach ($aDadosConsulta as $aDado) {
            $sMonth = strftime('%B', strtotime($aDado[$sColumnDate]));
            $aMonths[ ucwords($sMonth) ][] = $aDado;
        }

        $aMonths = self::agroupDataXY($oDashboardGrafico, $aMonths);

        return $aMonths;
    }

    private static function getByYears($oDashboardGrafico, $aDadosConsulta, $sColumnDate)
    {
        $aYears = [];

        foreach ($aDadosConsulta as $aDado) {
            $sYear = date('Y', strtotime($aDado[$sColumnDate]));
            $aYears[ ucwords($sYear) ][] = $aDado;
        }
        
        $aYears = self::agroupDataXY($oDashboardGrafico, $aYears);

        return $aYears;
    }
}