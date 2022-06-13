<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdemServicoTipo Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\OrdemServico[] $ordem_servicos
 */
class OrdemServicoTipo extends Entity
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
        'descricao' => true,
        'empresa_id' => true,
        'empresa' => true,
        'ordem_servicos' => true
    ];
}
