<?php
/**
 * Author: Silvio Regis 24/06/2020 11:45
 */

namespace LogPluginDashboards\RegraNegocio\DashboardManager;

use Cake\ORM\TableRegistry;

class DashboardFinder 
{
    public static function get($aExtraWhereGraficos = [])
    {
        $aGraficoOptions = [
            'DashboardGraficos' => function ($q) use($aExtraWhereGraficos) {
                return $q->order([
                    'DashboardGraficos.ordem' => 'ASC',
                ])
                ->where($aExtraWhereGraficos + [
                    'DashboardGraficos.ativo' => 1
                ]);
            }
        ];

        $aContain = [
            'DashboardCards' => function ($q) {
                return $q->order([
                    'DashboardCards.ordem' => 'ASC',
                ]);
            },
            'DashboardGraficos' => [
                'Consultas',
                'DashboardGraficoTipos' => [
                    'DashboardGraficoFormatos'
                ]
            ]
        ];

        $aDashboardsGenericos = TableRegistry::getTableLocator()->get('LogPluginDashboards.Dashboards')->find()
            ->contain($aContain)
            ->contain($aGraficoOptions)
            ->where([
                'perfil_id IS' => null,
                'usuario_id IS' => null,
                'ativo IS' => 1
            ])
            ->order([
                'Dashboards.ordem' => 'ASC',
            ])
            ->toArray();
        
        $aDashboardsEspeficos = TableRegistry::getTableLocator()->get('LogPluginDashboards.Dashboards')->find()
            ->contain($aContain)
            ->where([
                ' ( Dashboards.perfil_id = ' . @$_SESSION['Auth']['User']['perfil_id'] . ' OR ' .
                'Dashboards.usuario_id = ' . @$_SESSION['Auth']['User']['id'] . ' )',
                'Dashboards.ativo IS' => 1
            ])
            ->toArray();
        
        return $aDashboardsGenericos + $aDashboardsEspeficos;
    }
}