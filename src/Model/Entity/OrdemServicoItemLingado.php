<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdemServicoItemLingado Entity
 *
 * @property int $id
 * @property string $codigo
 * @property float|null $qtde
 * @property float|null $peso
 * @property int $ordem_servico_id
 * @property int $sentido_id
 * @property int $terno_id
 * @property int $resv_id
 * @property int $plano_carga_porao_id
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\Sentido $sentido
 * @property \App\Model\Entity\Terno $terno
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\PlanoCargaPorao $plano_carga_porao
 */
class OrdemServicoItemLingado extends Entity
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
        
        'codigo' => true,
        'qtde' => true,
        'peso' => true,
        'ordem_servico_id' => true,
        'sentido_id' => true,
        'terno_id' => true,
        'resv_id' => true,
        'plano_carga_porao_id' => true,
        'ordem_servico' => true,
        'sentido' => true,
        'terno' => true,
        'resv' => true,
        'plano_carga_porao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
