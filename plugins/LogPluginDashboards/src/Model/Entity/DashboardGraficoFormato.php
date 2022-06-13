<?php
namespace LogPluginDashboards\Model\Entity;

use Cake\ORM\Entity;

/**
 * DashboardGraficoFormato Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \LogPluginDashboards\Model\Entity\DashboardGraficoTipo[] $dashboard_grafico_tipos
 */
class DashboardGraficoFormato extends Entity
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
        'dashboard_grafico_tipos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
