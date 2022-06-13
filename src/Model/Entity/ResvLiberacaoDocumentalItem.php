<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResvLiberacaoDocumentalItem Entity
 *
 * @property int $id
 * @property int $resv_liberacao_documental_id
 * @property int $liberacao_documental_item_id
 * @property int|null $liberacao_documental_transportadora_item_id
 *
 * @property \App\Model\Entity\ResvsLiberacoesDocumental $resvs_liberacoes_documental
 * @property \App\Model\Entity\LiberacoesDocumentaisItem $liberacoes_documentais_item
 * @property \App\Model\Entity\LiberacaoDocumentalTransportadoraItem $liberacao_documental_transportadora_item
 */
class ResvLiberacaoDocumentalItem extends Entity
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
        
        'resv_liberacao_documental_id' => true,
        'liberacao_documental_item_id' => true,
        'liberacao_documental_transportadora_item_id' => true,
        'resvs_liberacoes_documental' => true,
        'liberacoes_documentais_item' => true,
        'liberacao_documental_transportadora_item' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
