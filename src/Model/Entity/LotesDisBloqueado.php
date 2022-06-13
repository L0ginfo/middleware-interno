<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LotesDisBloqueado Entity.
 *
 * @property int $id
 * @property int $contratos_bloqueio_id
 * @property \App\Model\Entity\ContratosBloqueio $contratos_bloqueio
 * @property int $tipos_bloqueio_id
 * @property \App\Model\Entity\TiposBloqueio $tipos_bloqueio
 * @property string $nr_lote
 * @property string $nr_di
 * @property int $tipos_unidade_id
 * @property \App\Model\Entity\TiposUnidade $tipos_unidade
 * @property float $peso_bloqueado
 */
class LotesDisBloqueado extends Entity
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
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
