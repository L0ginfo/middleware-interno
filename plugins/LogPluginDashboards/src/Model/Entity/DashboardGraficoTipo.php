<?php
namespace LogPluginDashboards\Model\Entity;

use Cake\ORM\Entity;

/**
 * DashboardGraficoTipo Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $grafico_params
 * @property int $dashboard_grafico_formato_id
 *
 * @property \LogPluginDashboards\Model\Entity\DashboardGraficoFormato $dashboard_grafico_formato
 * @property \LogPluginDashboards\Model\Entity\DashboardGrafico[] $dashboard_graficos
 */
class DashboardGraficoTipo extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
     /* Default fields
        
        'descricao' => true,
        'grafico_params' => true,
        'dashboard_grafico_formato_id' => true,
        'dashboard_grafico_formato' => true,
        'dashboard_graficos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
