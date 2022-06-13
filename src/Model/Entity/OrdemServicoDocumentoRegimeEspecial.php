<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdemServicoDocumentoRegimeEspecial Entity
 *
 * @property int $id
 * @property int|null $ordem_servico_id
 * @property int|null $documento_regime_especial_id
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\DocumentoRegimeEspecial $documento_regime_especial
 */
class OrdemServicoDocumentoRegimeEspecial extends Entity
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
        
        'ordem_servico_id' => true,
        'documento_regime_especial_id' => true,
        'ordem_servico' => true,
        'documento_regime_especial' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
