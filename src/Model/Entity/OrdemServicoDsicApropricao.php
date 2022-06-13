<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdemServicoDsicApropricao Entity
 *
 * @property int $id
 * @property int|null $ordem_servico_dsic_id
 * @property int|null $documento_mercadoria_hawb_id
 * @property float $quantidade
 * @property float $peso
 * @property float $volume
 * @property \Cake\I18n\Date|null $data_recebimento
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\OrdemServicoDsic $ordem_servico_dsic
 * @property \App\Model\Entity\DocumentosMercadoria $documentos_mercadoria
 */
class OrdemServicoDsicApropricao extends Entity
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
        
        'ordem_servico_dsic_id' => true,
        'documento_mercadoria_hawb_id' => true,
        'quantidade' => true,
        'peso' => true,
        'volume' => true,
        'data_recebimento' => true,
        'created_at' => true,
        'updated_at' => true,
        'ordem_servico_dsic' => true,
        'documentos_mercadoria' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
