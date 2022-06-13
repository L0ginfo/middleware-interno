<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Logradouro Entity
 *
 * @property int $id
 * @property string $num_cep
 * @property int $bairro_id
 * @property string $descricao
 * @property int|null $tipo_logradouro_id
 *
 * @property \App\Model\Entity\Bairro $bairro
 * @property \App\Model\Entity\TipoLogradouro $tipo_logradouro
 */
class Logradouro extends Entity
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
        'num_cep' => true,
        'bairro_id' => true,
        'descricao' => true,
        'tipo_logradouro_id' => true,
        'bairro' => true,
        'tipo_logradouro' => true
    ];
}
