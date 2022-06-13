<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * Pessoa Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $nome_fantasia
 * @property string|null $cpf
 * @property string|null $rg
 * @property string|null $cnh
 * @property \Cake\I18n\Time|null $cnh_validade
 * @property int|null $bloqueado
 *
 * @property \App\Model\Entity\Resv[] $resvs
 */
class Pessoa extends Entity
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
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        return [
            [
                'name'  => 'nom',
                'divClass' => 'col-lg-2',
                'label' => 'Nome',
                'table' => [
                    'className' => 'Pessoas',
                    'field'     => 'nome_fantasia',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'cpf',
                'divClass' => 'col-lg-2',
                'label' => 'CPF',
                'table' => [
                    'className' => 'Pessoas',
                    'field'     => 'cpf',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'rg',
                'divClass' => 'col-lg-2',
                'label' => 'RG',
                'table' => [
                    'className' => 'Pessoas',
                    'field'     => 'rg',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'cnh',
                'divClass' => 'col-lg-2',
                'label' => 'CNH',
                'table' => [
                    'className' => 'Pessoas',
                    'field'     => 'cnh',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }
}
