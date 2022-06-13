<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TipoIso Entity
 *
 * @property int $id
 * @property string|null $descricao
 * @property string|null $m3
 * @property string|null $m2
 * @property float|null $comprimento
 * @property float|null $largura
 * @property float|null $altura
 * @property string|null $sigla
 * @property int $container_modelo_id
 * @property int $container_tamanho_id
 *
 * @property \App\Model\Entity\ContainerModelo $container_modelo
 * @property \App\Model\Entity\ContainerTamanho $container_tamanho
 * @property \App\Model\Entity\Container[] $containers
 */
class TipoIso extends Entity
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
        'm3' => true,
        'm2' => true,
        'comprimento' => true,
        'largura' => true,
        'altura' => true,
        'sigla' => true,
        'container_modelo_id' => true,
        'container_tamanho_id' => true,
        'container_modelo' => true,
        'container_tamanho' => true,
        'containers' => true,
    
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
                    'className' => 'TipoIsos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'sigla',
                'divClass' => 'col-lg-3',
                'label' => 'Sigla',
                'table' => [
                    'className' => 'TipoIsos',
                    'field'     => 'sigla',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'container_modelo',
                'divClass' => 'col-lg-3',
                'label' => 'Container Modelo',
                'table' => [
                    'className' => 'TipoIsos.ContainerModelos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'container_tamanho',
                'divClass' => 'col-lg-3',
                'label' => 'Container Tamanho',
                'table' => [
                    'className' => 'TipoIsos.ContainerTamanhos',
                    'field'     => 'tamanho',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }

}
