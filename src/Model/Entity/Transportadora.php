<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transportadora Entity
 *
 * @property int $id
 * @property string|null $razao_social
 * @property int|null $ativo
 */
class Transportadora extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
      *  'razao_social' => true,
      *  'ativo' => true
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        return [
            [
                'name'  => 'raz',
                'divClass' => 'col-lg-2',
                'label' => 'Razão Social',
                'table' => [
                    'className' => 'Transportadoras',
                    'field'     => 'razao_social',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'nom',
                'divClass' => 'col-lg-2',
                'label' => 'Nome Fantasia',
                'table' => [
                    'className' => 'Transportadoras',
                    'field'     => 'nome_fantasia',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }
}
