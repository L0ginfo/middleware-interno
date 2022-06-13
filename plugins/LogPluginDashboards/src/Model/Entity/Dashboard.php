<?php
namespace LogPluginDashboards\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dashboard Entity
 *
 * @property int $id
 * @property string $titulo
 * @property int|null $perfil_id
 * @property int|null $usuario_id
 * @property int|null $ordem
 *
 * @property \LogPluginDashboards\Model\Entity\Perfil $perfil
 * @property \LogPluginDashboards\Model\Entity\Usuario $usuario
 * @property \LogPluginDashboards\Model\Entity\DashboardCard[] $dashboard_cards
 * @property \LogPluginDashboards\Model\Entity\DashboardGrafico[] $dashboard_graficos
 */
class Dashboard extends Entity
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
        'perfil_id' => true,
        'usuario_id' => true,
        'ordem' => true,
        'perfil' => true,
        'usuario' => true,
        'dashboard_cards' => true,
        'dashboard_graficos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
