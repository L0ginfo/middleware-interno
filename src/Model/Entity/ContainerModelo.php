<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContainerModelo Entity
 *
 * @property int $id
 * @property string|null $descricao
 * @property int|null $refeer
 *
 * @property \App\Model\Entity\TipoIso[] $tipo_isos
 */
class ContainerModelo extends Entity
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
        
        'descricao' => true,
        'refeer' => true,
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
                'name'  => 'descricao',
                'divClass' => 'col-lg-3',
                'label' => 'Descrição',
                'table' => [
                    'className' => 'ContainerModelos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'refeer',
                'divClass' => 'col-lg-3',
                'label' => 'Refeer',
                'table' => [
                    'className' => 'ContainerModelos',
                    'field'     => 'refeer',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }
}
