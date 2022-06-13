<?php
namespace LogPluginDashboards\Model\Entity;

use Cake\ORM\Entity;

/**
 * DashboardGrafico Entity
 *
 * @property int $id
 * @property int|null $ordem
 * @property string|null $responsive_options
 * @property int|null $consulta_id
 * @property int $dashboard_id
 * @property int $dashboard_grafico_tipo_id
 *
 * @property \LogPluginDashboards\Model\Entity\Consulta $consulta
 * @property \LogPluginDashboards\Model\Entity\Dashboard $dashboard
 * @property \LogPluginDashboards\Model\Entity\DashboardGraficoTipo $dashboard_grafico_tipo
 */
class DashboardGrafico extends Entity
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
        
        'ordem' => true,
        'responsive_options' => true,
        'consulta_id' => true,
        'dashboard_id' => true,
        'dashboard_grafico_tipo_id' => true,
        'consulta' => true,
        'dashboard' => true,
        'dashboard_grafico_tipo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
