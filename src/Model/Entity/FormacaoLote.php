<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FormacaoLote Entity
 *
 * @property int $id
 * @property int $documento_transporte_id
 * @property int $consolidado
 *
 * @property \App\Model\Entity\DocumentosTransporte $documentos_transporte
 * @property \App\Model\Entity\FormacaoLoteItem[] $formacao_lote_itens
 */
class FormacaoLote extends Entity
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
        
        'documento_transporte_id' => true,
        'consolidado' => true,
        'documentos_transporte' => true,
        'formacao_lote_itens' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {   
        return [
            [
                'name'  => 'id',
                'divClass' => 'col-lg-3',
                'label' => 'ID',
                'table' => [
                    'className' => 'FormacaoLotes',
                    'field'     => 'id',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'nota_exportacao',
                'divClass' => 'col-lg-3',
                'label' => 'Note Exportação',
                'table' => [
                    'className' => 'FormacaoLotes.DocumentosTransportes',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'consolidado',
                'divClass' => 'col-lg-3',
                'label' => 'Consolidado',
                'table' => [
                    'className' => 'FormacaoLotes',
                    'field'     => 'consolidado',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }
}
