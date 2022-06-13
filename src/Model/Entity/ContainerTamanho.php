<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContainerTamanho Entity
 *
 * @property int $id
 * @property string $tamanho
 *
 * @property \App\Model\Entity\TipoIso[] $tipo_isos
 */
class ContainerTamanho extends Entity
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
        
        'tamanho' => true,
        'tipo_isos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        return [
            [
                'name'  => 'tamanho',
                'divClass' => 'col-lg-3',
                'label' => 'Tamanho',
                'table' => [
                    'className' => 'ContainerTamanhos',
                    'field'     => 'tamanho',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }
}
