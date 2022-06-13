<?php
namespace LogPluginDashboards\Model\Entity;

use Cake\ORM\Entity;

/**
 * DashboardCard Entity
 *
 * @property int $id
 * @property string $titulo
 * @property int|null $ordem
 * @property string $cor
 * @property string|null $url
 * @property string|null $controller
 * @property string|null $action
 * @property string|null $icone
 * @property string|null $consulta_coluna_dado
 * @property int $dashboard_id
 *
 * @property \LogPluginDashboards\Model\Entity\Dashboard $dashboard
 */
class DashboardCard extends Entity
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
        
        'titulo' => true,
        'ordem' => true,
        'cor' => true,
        'url' => true,
        'controller' => true,
        'action' => true,
        'icone' => true,
        'consulta_coluna_dado' => true,
        'dashboard_id' => true,
        'dashboard' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
