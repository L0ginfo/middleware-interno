<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * ControleCampo Entity
 *
 * @property int $id
 * @property string $titulo
 * @property string|null $attribute
 * @property int|null $controller_id
 * @property int $ocorrencia
 * @property int $required
 * @property int $readonly
 * @property int $hidden
 * @property string|null $pattern
 * @property int $ativo
 *
 * @property \App\Model\Entity\Controlador $controlador
 * @property \App\Model\Entity\ControleCampoActiom[] $controle_campo_actions
 */
class ControleCampo extends Entity
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
        
        'titulo' => true,
        'attribute' => true,
        'controller_id' => true,
        'ocorrencia' => true,
        'required' => true,
        'readonly' => true,
        'hidden' => true,
        'pattern' => true,
        'ativo' => true,
        'controlador' => true,
        'controle_campo_actions' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        $aControladores = LgDbUtil::get('Controladores')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->toArray();
        
        return [
            [
                'name'  => 'titulo',
                'divClass' => 'col-lg-3',
                'label' => 'Titulo',
                'table' => [
                    'className' => 'ControleCampos',
                    'field'     => 'titulo',
                    'operacao'  => 'igual'
                ]
            ],
            [
                'name'  => 'attribute',
                'divClass' => 'col-lg-3',
                'label' => 'Atributo',
                'table' => [
                    'className' => 'ControleCampos',
                    'field'     => 'attribute',
                    'operacao'  => 'igual'
                ]
            ],

            [
                'name'  => 'ativo',
                'divClass' => 'col-lg-3',
                'label' => 'Ativo',
                'table' => [
                    'className' => 'ControleCampos',
                    'field'     => 'ativo',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => [1 => 'Sim', 0 => 'Não']
                ]
            ],

            [
                'name'  => 'controller_id',
                'divClass' => 'col-lg-3',
                'label' => 'Controlador',
                'table' => [
                    'className' => 'ControleCampos',
                    'field'     => 'controller_id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aControladores
                ]
            ],
        ];
    }
}
