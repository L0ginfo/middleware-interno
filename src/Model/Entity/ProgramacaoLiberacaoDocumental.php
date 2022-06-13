<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProgramacaoLiberacaoDocumental Entity
 *
 * @property int $id
 * @property int $liberacao_documental_id
 * @property int|null $liberacao_documental_transportadora_id
 * @property int $programacao_id
 *
 * @property \App\Model\Entity\LiberacoesDocumental $liberacoes_documental
 * @property \App\Model\Entity\LiberacaoDocumentalTransportadora $liberacao_documental_transportadora
 * @property \App\Model\Entity\Programacao $programacao
 * @property \App\Model\Entity\ProgramacaoLiberacaoDocumentalItem[] $programacao_liberacao_documental_itens
 */
class ProgramacaoLiberacaoDocumental extends Entity
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
        
        'liberacao_documental_id' => true,
        'liberacao_documental_transportadora_id' => true,
        'programacao_id' => true,
        'liberacoes_documental' => true,
        'liberacao_documental_transportadora' => true,
        'programacao' => true,
        'programacao_liberacao_documental_itens' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
