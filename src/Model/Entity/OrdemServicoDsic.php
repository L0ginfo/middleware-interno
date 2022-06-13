<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdemServicoDsic Entity
 *
 * @property int $id
 * @property int|null $ordem_servico_id
 * @property int|null $documento_mercadoria_dsic_id
 * @property int|null $documento_mercadoria_hawb_id
 * @property int $associar
 * @property int $apropriar
 * @property float $quantidade
 * @property float $peso
 * @property float $volume
 * @property \Cake\I18n\Date|null $data_recebimento
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\DocumentosMercadoria $documentos_mercadoria
 * @property \App\Model\Entity\OrdemServicoDsicApropricao[] $ordem_servico_dsic_apropricoes
 */
class OrdemServicoDsic extends Entity
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
        'documento_mercadoria_dsic_id' => true,
        'documento_mercadoria_hawb_id' => true,
        'associar' => true,
        'apropriar' => true,
        'quantidade' => true,
        'peso' => true,
        'volume' => true,
        'data_recebimento' => true,
        'created_at' => true,
        'updated_at' => true,
        'ordem_servico' => true,
        'documentos_mercadoria' => true,
        'ordem_servico_dsic_apropricoes' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
